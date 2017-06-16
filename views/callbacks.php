<?php

	function getFacebookPessoa($id){

		$payloadFB = "https://graph.facebook.com/v2.6/{$id}?access_token=".KEY;
		$response = (array) json_decode(file_get_contents($payloadFB));
		$data = array(
			"nome" => $response["first_name"]." ".$response["last_name"],
			"imagem" => $response["profile_pic"],
			"localizacao" => $response["locale"],
			"sexo" => $response["gender"]
		);
		return $data;

	}
	
	function callbackName($info){

		$getPessoa = getFacebookPessoa($info["user_id"]);
		return "Seu Nome é: ".$getPessoa["nome"];

	}

	function callbackOi($info){

		$getPessoa = getFacebookPessoa($name["user_id"]);
		return "Olá, tudo bem ".$getPessoa["nome"]." ?";

	}

	function callbackBoaNoite($info){

		$pessoa = getFacebookPessoa($info["user_id"]);
		$n = explode(" ", $pessoa["nome"]);
		return "Olá ".$n[0].", Boa Noite!!";

	}

	function callbackRoboIgual(){

		return "https://github.com/PaulaoDeveloper/ChatBot-Messenger-PHP";

	}

	function help(){

		return "↪ Meu Nome \n↪ Oi \n↪ Boa Noite \n↪ Fazer um robo igual";

	}