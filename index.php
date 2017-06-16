<?php 

	$methods = explode('/', $_GET['url']);
	define("PATH", dirname(__FILE__).DIRECTORY_SEPARATOR);
	define("FILE_NAME", strip_tags(addslashes(end($methods))));

	$page = PATH."views/".FILE_NAME.".php";

	$types = array(
		"json" => "Content-type:application/json",
		"html" => "Content-type:text/plain",
		"js"   => "Content-type:text/javascript",
		"css"  => "Content-type:text/css",
		"png"  => "Content-type:image/png",
		"jpg"  => "Content-type:image/jpg",
		"mp4"  => "Content-type:video/mp4",
		"mp3"  => "Content-type:audio/mp3"
	);

	$typeReal = pathinfo($_GET['url'], PATHINFO_EXTENSION);;

	if(file_exists($page)): include $page; endif;
	if(file_exists($_GET['url'])){
		if(isset($types[$typeReal])){
			header($types[$typeReal]);
		}else{
			http_response_code(404);
		}
		include PATH.$_GET['url'];
	}
