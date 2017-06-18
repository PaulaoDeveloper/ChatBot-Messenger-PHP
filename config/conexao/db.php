<?php

	define("HOST", "mysql873.umbler.com");
	define("DB_NAME", "neural");
	define("DB_USER", "chatbotphp");
	define("DB_PASS", "paulo2017");

	$db = null;
	try {
		$db = new PDO("mysql:host=".HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch (PDOException $e) {
		echo "Erro: ".$e->getMessage();
	}