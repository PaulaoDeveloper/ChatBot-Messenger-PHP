<?php

	define("HOST", "HOST DO SEU BANCO");
	define("DB_NAME", "NAME DO SEU BANCO");
	define("DB_USER", "USER DO SEU BANCO");
	define("DB_PASS", "SENHA DO SEU BANCO");

	$db = null;
	try {
		$db = new PDO("mysql:host=".HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch (PDOException $e) {
		echo "Erro: ".$e->getMessage();
	}
