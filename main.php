<?php  
error_reporting(0);
include "func.php";

if (!$link = $_GET['url']) {
	die();
}
else{
	$link = $_GET['url'];
	preg_match('/https?:\/\/(?:www\.)?(?:drive|docs)\.google\.com\/(?:file\/d\/|open\?id=)?([a-z0-9A-Z_-]+)(?:\/.+)?/is', $link, $id);
	if(empty($id[1])){
		die();
	}
	else {
	$cache_file = 'cache/'.md5($id[1]).'.CACHE';
	if (file_exists($cache_file) && (filemtime($cache_file) > (time() - 60 * 60 * 2))) {
	   $file = file_get_contents($cache_file);
	} else {
	   $file = Drive($id[1]);
	   file_put_contents($cache_file, $file, LOCK_EX);
	}
		if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") {
			echo $file = str_replace('http://', 'https://', $file);
		} else{
			echo $file;
		}
	}
}
	
?>