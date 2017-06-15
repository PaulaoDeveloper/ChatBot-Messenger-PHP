<?php 

	$methods = explode('/', $_GET['url']);
	$name = end($methods);
	$page = "views/".$name.".php";

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

	$realType = explode('.', strrev($_GET['url']));
	$realType = $realType[0];
	$typeReal = "";

	for ($i=0; $i < strlen($realType); $i++) { 
		$typeReal = $realType[$i].$typeReal;
	}

	if(file_exists($page)): include $page; endif;
	if(file_exists($_GET['url'])){
		if(isset($types[$typeReal])){
			header($types[$typeReal]);
		}
		include $_GET['url'];
	}