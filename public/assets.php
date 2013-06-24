<?php

require '../compressor/compressor.php';

$file = $_GET['file'];
$cache_folder = realpath(__DIR__.'/../compressor/cache/').'/';

if (file_exists($file)) {

	$type = strtolower(pathinfo($file,PATHINFO_EXTENSION));
	switch($type) {
		case 'css':
			mylogger($file);
			test($file);

			$cache = new cache($cache_folder,3600);
			
			$content = $cache->get($file);
			if ($content == null) {
				$compressor = new CSSmin();
				$content = $compressor->run(file_get_contents($file));
				$cache->set($file,$content);
			}
			
		  send($content,'text/css',$file);				
			exit;		
		
		break;
		case 'js':
			mylogger($file);
			test($file);

			$cache = new cache($cache_folder,3600);
			
			$content = $cache->get($file);
			if ($content == null) {
				$content = JSMin::minify(file_get_contents($file));
				$cache->set($file,$content);
			}
			
			send($content,'text/javascript',$file);
			exit;
				
		break;
	}
}

header('HTTP/1.1 404 Not Found');