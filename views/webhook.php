<?php

		function sendApi($d){
			/* KEY DA PAGINA GERADO NO MESSENGER NO FACEBOOK DEVELOPERS */
			$key = "KEY DA SUA PAGINA";
			// Rest do Chatbot
			$url = 'https://graph.facebook.com/v2.6/me/messages?access_token='.$key;
			// Iniciando o Envio.
			$ch = curl_init($url);
			$data = json_encode($d);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    			'Content-Type: application/json'
			));
			if (!empty($d['message'])) {
   				$result = curl_exec($ch);
			}
		}

		function eventsTrigger($id, $text){

			/* MENSAGEM PARA ENVIAR CASO NAO EXISTA NA MEMORIA DO ROBO */
			$mensagemDefault = "Obrigado por nos Enviar a Mensagem!!";
			/* SISTEMA DE MEMORIA DO ROBO */
			$neuros = (array) json_decode(file_get_contents('./neural/neuro-system.json'));
			/* TRATA A MENSAGEM */
			$trataNeuro = trim(strtolower($text));
			/* DADOS A SER ENVIADO PELO BOT */
			$dataInfo = array(
				"recipient" => array("id" => $id)
			);
		
			/* VERIFICA SE EXISTE A MENSAGEM NA MEMORIA DO ROBO */
			if(isset($neuros[$text])){
				$dataInfo["message"] = array("text" => $neuros[$text]);
				sendApi($dataInfo);
			}else{
				$dataInfo["message"] = array("text" => $mensagemDefault);
				sendApi($dataInfo);
			}
			

		}

		function trataMensagem($msg){

			/* PEGA TODAS INFORMAÇOES ENVIADAS PELO FACEBOOK */
			$senderID = $msg["sender"]["id"];
			$recipientID = $msg["recipient"]["id"];
			$timeOfMessage = $msg["timestamp"];
			$message = $msg["message"];
			$messageID = $message["mid"];
			$messageText = $message["text"];
			$attachments = $message["attachments"];

			// INICIA O TRATAMENTO PARA ENVIO param1: id, param2: mensagem
			eventsTrigger($senderID, $messageText);

		}

		// VERIFICAÇAO DO FACEBOOK
		$challenge = $_REQUEST['hub_challenge'];
		$verify_token = $_REQUEST['hub_verify_token'];
		
		// Senha Default para configurar no Webhook no Developers
		$senha = 'minhasenha123';

		// VERIFICACAO DE ACESSO A PARTIR DA SENHA
		if ($verify_token === $senha) {
    		echo $challenge;
		}

		// RECEBE AS INFOS
		$receive = json_decode(file_get_contents('php://input'), true);

		// INICIA O TRATAMENTO DE MENSAGEM POR MENSAGEM
		foreach ($receive['entry'] as $key => $entry) {
				
				$pageID = $entry["id"];
				$timeOfEvent = $entry["time"];

				foreach($entry["messaging"] as $k => $event){

					if(isset($event['message'])){

						trataMensagem($event);

					}

				}

			}
