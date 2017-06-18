<?php

	class BotCore {

		private static $key;
		private static $token;
		private static $pusher;
		private static $logger;
		private static $endpoint;
		private static $dominio;

		// Pattern Singleton

    	public static function getInstance(){
        	static $instance = null;
        	if (null === $instance) {
            	$instance = new static();
        	}
       	 	return $instance;
		}

    	protected function __construct(){}	

    	// Configs do ChatBot

		public function setKey($key){ self::$key = $key; }
		public function setToken($token){ self::$token = $token; }
		public function logger($cond){
			if(!empty(self::$pusher) && count(self::$pusher) == 3 && $cond == true){
				self::$logger = $cond;
			}else{
				self::$logger = false;
				echo "Configure o acesso ao seu Pusher !!";
			}
		}
		public function setDominio($dominio){ self::$dominio = $dominio; }

		public static function configPusher(array $config){
			self::$pusher = $config;
		}

		public function endpoint($point){
			self::$endpoint = $point;
		}

		// Envia o Log Pelo Pusher
		public function MsgPusher($msg){
			$canal = "chatbotphp";
  			$event = "logger";
  			$req_url = self::$endpoint."?key=".self::$pusher["key"]."&secret=".self::$pusher["secret"]."&app_id=".self::$pusher["app_id"]."&canal={$canal}&event={$event}&msg={$msg}";
  			$req_url = self::$dominio.$req_url;
			$exec = file_get_contents($req_url);
		}

		public function sendApi($d){
			/* KEY DA PAGINA GERADO NO MESSENGER NO FACEBOOK DEVELOPERS */
			$key = self::$key;
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

		public function eventsTrigger($id, $text, $user){
			/* MENSAGEM PARA ENVIAR CASO NAO EXISTA NA MEMORIA DO ROBO */
			$mensagemDefault = 'Digite "help" para ver os Comandos!!';
			/* SISTEMA DE MEMORIA DO ROBO */
			$query = self::$dominio.'/neural/neuro-system.json';
			$neuros = (array) json_decode(file_get_contents($query));
			/* TRATA A MENSAGEM */
			$trataNeuro = trim(strtolower($text));
			/* DADOS A SER ENVIADO PELO BOT */
			$dataInfo = array(
				"recipient" => array("id" => $id)
			);
			/* VERIFICA SE EXISTE A MENSAGEM NA MEMORIA DO ROBO */
			if(isset($neuros[$trataNeuro])){
				$funcao = $neuros[$trataNeuro];
				$dataInfo["message"] = array("text" => $funcao($user));
				$this->sendApi($dataInfo);
			}else{	
				$keys = explode(" ", $trataNeuro);
				$search = trim($keys[0]);
				if(isset($neuros[$search])){
					$funcao = $neuros[$search];
					$user["extern_value"] = trim(str_replace($search, "",$trataNeuro));
					$dataInfo["message"] = array("text" => $funcao($user));
				}
				if(empty($dataInfo["message"])){
					$dataInfo["message"] = array("text" => $keys);
				}
				$this->sendApi($dataInfo);		
			}
		}

		public function trataMensagem($msg){
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
				$infos["token_access"] = self::$token;
				$this->MsgPusher(json_encode($infos));
				// INICIA O TRATAMENTO PARA ENVIO param1: id, param2: mensagem
				$this->eventsTrigger($senderID, $messageText, $infos);
			}
		}

		public function Run(){
			// VERIFICAÇAO DO FACEBOOK
			$challenge = $_REQUEST['hub_challenge'];
			$verify_token = $_REQUEST['hub_verify_token'];
			// Senha Default para configurar no Webhook no Developers
			$token_access = self::$token;
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
						if(isset($event['message'])){ $this->trataMensagem($event); }
					}
				}
			}
		}

}
