<?php
require '../asset.inc.php';

$file = $_GET['file'];

$cache_folder = realpath(__DIR__.'/../cache/').'/';
$type_map = array('css'=>'text/css','js'=>'text/javascript');
$type = strtolower(pathinfo($file,PATHINFO_EXTENSION));

if (!file_exists($file) || !array_key_exists($type,$type_map)) {
	header('HTTP/1.1 404 Not Found');
}

/* if cache=no set on a single file or envirnmental variable noCache = true (effects all files) then don't cache */
if (strpos($_SERVER['REQUEST_URI'],'cache=no') !== false || $_SERVER['noCache']  === 'true') {

  $key = 'raw_file:'.$file;

	$content = get_cache($key);

	if ($content === null) {
		$content = file_get_contents($file);
		set_cache($key,$content);
	}

} else {

	//get the last-modified-date of this very file
	$lastModified = filemtime($file);

	//get a unique hash of this file (etag)
	$etagFile = md5_file($file);

	//get the HTTP_IF_MODIFIED_SINCE header if set
	$ifModifiedSince = (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) ? $_SERVER['HTTP_IF_MODIFIED_SINCE'] : false);

	//get the HTTP_IF_NONE_MATCH header if set (etag: unique file hash)
	$etagHeader = (isset($_SERVER['HTTP_IF_NONE_MATCH']) ? trim($_SERVER['HTTP_IF_NONE_MATCH']) : false);

	//check if page has changed. If not, send 304 and exit
	if (@strtotime($ifModifiedSince) == $lastModified || $etagHeader == $etagFile) {
		// set last-modified header
		header("Last-Modified: ".gmdate("D, d M Y H:i:s", $lastModified)." GMT");

		// set etag-header
		header("ETag: $etagFile");

		// make sure caching is turned on
		header('Cache-Control: public, must-revalidate');

		header('Expires: -1');

		// cache type
		header('Pragma: public');

		// not modifed
		header("HTTP/1.1 304 Not Modified");
		exit;
	}

	/* get cached data */
	$data = get_cache('cache:'.$file);

	/* did the file change? */
	$content = ($data['etagFile'] === $etagFile) ? $data['content'] : null;

	switch($type) {
		case 'css':
			if ($content === null) {
				$compressor = new CSSmin();
				$content = trim($compressor->run(file_get_contents($file)));
				set_cache('cache:'.$file,array('etagFile'=>$etagFile,'file'=>$file,'content'=>$content));
			}
		break;
		case 'js':
			if ($content === null) {
				$content = trim(JSMin::minify(file_get_contents($file)));
				set_cache('cache:'.$file,array('etagFile'=>$etagFile,'file'=>$file,'content'=>$content));
			}
		break;
	}
}

/* send $content */
$mime = $type_map[$type];

session_cache_limiter('public');

ob_end_clean();
ob_start('ob_gzhandler');

// set last-modified header
header("Last-Modified: ".gmdate("D, d M Y H:i:s", $lastModified)." GMT");

// set etag-header
header("ETag: $etagFile");

// make sure caching is turned on
header('Cache-Control: public, must-revalidate');

header('Expires: -1');

// cache type
header('Pragma: public');

// what type of file
header("content-type: ".$mime."; charset: UTF-8");

echo($content);

ob_end_flush();