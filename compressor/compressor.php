<?php 
require 'cache.php';
require 'cssmin.php';
require 'jsmin.php';

function test($filename) {
	//get the last-modified-date of this very file
	$lastModified = filemtime($filename);
	
	//get a unique hash of this file (etag)
	$etagFile = md5_file($filename);
	
	//get the HTTP_IF_MODIFIED_SINCE header if set
	$ifModifiedSince = (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) ? $_SERVER['HTTP_IF_MODIFIED_SINCE'] : false);
	
	//get the HTTP_IF_NONE_MATCH header if set (etag: unique file hash)
	$etagHeader = (isset($_SERVER['HTTP_IF_NONE_MATCH']) ? trim($_SERVER['HTTP_IF_NONE_MATCH']) : false);
	
	//set last-modified header
	header("Last-Modified: ".gmdate("D, d M Y H:i:s", $lastModified)." GMT");
	
	//set etag-header
	header("Etag: $etagFile");
	
	//make sure caching is turned on
	header('Cache-Control: public');
	
	//check if page has changed. If not, send 304 and exit
	if (@strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE'])==$lastModified || $etagHeader == $etagFile) {
		header("HTTP/1.1 304 Not Modified");
		exit;
	}
	
}

function send($output,$mine,$filename) {
  ob_start('ob_gzhandler');

	header("content-type: ".$mime."; charset: UTF-8");

	//get the last-modified-date of this very file
	$lastModified=filemtime($filename);
	
	//get a unique hash of this file (etag)
	$etagFile = md5_file($filename);

	//header("expires: ".gmdate ("D, d M Y H:i:s", time() + 604800)." GMT");
	//header("Cache-Control: max-age=604800, public, must-revalidate", true);
	//header("Last-Modified: ".gmdate("D, d M Y H:i:s", filemtime($file))." GMT");

	$seconds_to_cache = 3600*24;
	$ts = gmdate("D, d M Y H:i:s", time() + $seconds_to_cache) . " GMT";
	//header("Expires: $ts");
	//header("Pragma: cache");
	//header("Cache-Control: max-age=$seconds_to_cache, public, must-revalidate", true);
	
	//set last-modified header
	header("Last-Modified: ".gmdate("D, d M Y H:i:s", $lastModified)." GMT");
	
	//set etag-header
	header("Etag: $etagFile");
	
	//make sure caching is turned on
	header('Cache-Control: public');
	header('Pragma: public');

	$output = trim($output);

  echo($output);

  ob_end_flush();
}

function mylogger($v,$name='logname',$new=false) {
	$path = '/Users/myersd/Desktop/';
	$flag = ($new) ? 'w' : 'a';
	if ($log_handle = fopen($path.$name.'.log',$flag)) {
		fwrite($log_handle,$v.chr(10));
		fclose($log_handle);
	}
}
