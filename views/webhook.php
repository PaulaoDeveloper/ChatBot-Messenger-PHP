<?php

		define('KEY', "EAAQGTdkGPRgBAMOhvQMHZCZA349OpG2fpBRQslZAzYQgQ09LznZAFLJYLIW7HzGCKKF5flTPpe3GohE40BzXBWfwUGfXZChafcZAIXZCoRy5OnUj03ViD6ITJRUmls6090BcTuoe7GCMbAZC11a1qk39DEtuRZAsSed0JAPsGkXBs1QZDZD");
		define('TOKEN_ACCESS', 'minhasenha123');
		define('ENDPOINT', "http://endpoint-chatbotphp.uphero.com");
		include "views/callbacks.php";

  		function MsgPusher($msg){

  			$canal = "chatbotphp";
  			$event = "logger";
			//open connection
			$exec = file_get_contents(ENDPOINT."?canal={$canal}&event={$event}&msg={$msg}");

  		}

  		function GetFacebookPage($id){

  			$payloadFB = "https://graph.facebook.com/v2.6/{$id}?fields=id,name,picture&access_token=".KEY;
  			$response = (array) json_decode(file_get_contents($payloadFB));
  			/*$data = array(
  				"id" => $response["id"],
  				"nome" => $response["name"],
  				"imagem" => $response["picture"]["data"]["url"]
  			);*/
  			return json_encode($response);

  		}

		function GetFacebook($id){

			$payloadFB = "https://graph.facebook.com/v2.6/{$id}?access_token=".KEY;
			$response = (array) json_decode(file_get_contents($payloadFB));
			/*$data = array(
				"nome" => $response["first_name"]." ".$response["last_name"],
				"imagem" => $response["profile_pic"],
				"localizacao" => $response["locale"],
				"sexo" => $response["gender"]
			);*/
			return json_encode($response);

		}

		function sendApi($d){
			/* KEY DA PAGINA GERADO NO MESSENGER NO FACEBOOK DEVELOPERS */
			$key = KEY;
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

		function eventsTrigger($id, $text, $user){

			/* MENSAGEM PARA ENVIAR CASO NAO EXISTA NA MEMORIA DO ROBO */
			$mensagemDefault = 'Digite "help" para ver os Comandos!!';
			/* SISTEMA DE MEMORIA DO ROBO */
			$neuros = (array) json_decode(file_get_contents('./neural/neuro-system.json'));
			/* TRATA A MENSAGEM */
			$trataNeuro = trim(strtolower($text));
			/* DADOS A SER ENVIADO PELO BOT */
			$dataInfo = array(
				"recipient" => array("id" => $id)
			);
			foreach ($variable as $key => $value) {
				# code...
			}
			/* VERIFICA SE EXISTE A MENSAGEM NA MEMORIA DO ROBO */
			if(isset($neuros[$trataNeuro])){
				$funcao = $neuros[$trataNeuro];
				$dataInfo["message"] = array("text" => $funcao($user));
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

			// ENVIA LOGS
			if(isset($messageText)){
				$infos = array();
				$infos["message"] = $messageText;
				$infos["time"] = $timeOfMessage;
				$infos["message_id"] = $messageID;
				$infos["user_id"] = $senderID;
				$infos["page_id"] = $recipientID;
				$infos["token_access"] = "EAAQGTdkGPRgBAMOhvQMHZCZA349OpG2fpBRQslZAzYQgQ09LznZAFLJYLIW7HzGCKKF5flTPpe3GohE40BzXBWfwUGfXZChafcZAIXZCoRy5OnUj03ViD6ITJRUmls6090BcTuoe7GCMbAZC11a1qk39DEtuRZAsSed0JAPsGkXBs1QZDZD";
				MsgPusher(json_encode($infos));

				// INICIA O TRATAMENTO PARA ENVIO param1: id, param2: mensagem
				eventsTrigger($senderID, $messageText, $infos);

			}


		}

		// VERIFICAÇAO DO FACEBOOK
		$challenge = $_REQUEST['hub_challenge'];
		$verify_token = $_REQUEST['hub_verify_token'];
		
		// Senha Default para configurar no Webhook no Developers
		$token_access = TOKEN_ACCESS;

		// VERIFICACAO DE ACESSO A PARTIR DA SENHA
		if ($verify_token === $token_access) {
    		echo $challenge;
		}

		// RECEBE AS INFOS
		$receive = json_decode(file_get_contents('php://input'), true);

		// INICIA O TRATAMENTO DE MENSAGEM POR MENSAGEM
		if(isset($receive["entry"]) && $receive["object"] == "page"){
			foreach ($receive['entry'] as $key => $entry) {
				
				$pageID = $entry["id"];
				$timeOfEvent = $entry["time"];

				foreach($entry["messaging"] as $k => $event){

					if(isset($event['message'])){

						trataMensagem($event);

					}

				}

			}
		}