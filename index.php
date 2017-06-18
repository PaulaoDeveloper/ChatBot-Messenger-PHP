<?php

	require_once __DIR__ ."/vendor/autoload.php";

	use \NoahBuscher\Macaw\Macaw as Route;
	use \Src\Bot\BotCore as BotCore;
	use \Src\Bot\Callbacks as Callbacks;
	use \Src\Bot\Facebook as Facebook;

	// DEFINE AS ROTAS
	Route::get('/termos', function(){
		include "views/termos.txt";
	});
	Route::get('/privacidade', function(){
		include "views/privacidade.txt";
	});
	Route::get('/endpoint/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)', function($key, $secret, $app_id, $canal, $event, $msg){
		$options = array('cluster' => 'us2','encrypted' => true);
  		$pusher = new Pusher($key,$secret,$app_id,$options);
  		$data = array();
  		$data['message'] = $msg;
  		$pusher->trigger($canal, $event, $msg);
	});
	Route::get('/logs', function(){
		include "views/logs.html";
	});

	Route::get('/webhook', function() {
  		
		// VERIFICAÇAO DO FACEBOOK
		$challenge = $_REQUEST['hub_challenge'];
		$verify_token = $_REQUEST['hub_verify_token'];
		// Senha Default para configurar no Webhook no Developers
		$token_access = "minhasenha123";
		// VERIFICACAO DE ACESSO A PARTIR DA SENHA
		if ($verify_token === $token_access) {
    		echo $challenge;
    		http_response_code(200);
		}else{
			die("Error");
			http_response_code(403);
		}

	});

	Route::post("/webhook", function(){

		// Cria o Robo
		$BotCore = BotCore::getInstance();
		// Seta as Configs
		$BotCore->setKey("KEY GERADA DA SUA PAGINA");
		$BotCore->setToken("minhasenha123");
		$BotCore->setDominio("https://meusite.com");
		$BotCore->endpoint("https://meusite.com/endpoint");
		// Configura o Pusher , http://pusher.com
		$BotCore->configPusher(array(
			"key" => "KEY PUSHER",
			"secret" => "KEY SECRET PUSHER",
			"app_id" => "APP ID PUSHER"
		));
		// Log Ativo se estiver configurado o Pusher.
		$BotCore->logger(true);
		// Passa Callbacks junto com Api Rest do Facebook OO
		$BotCore->setCallbacks(new Callbacks(new Facebook($BotCore->getKey())));
		// Bot Inicia
		$BotCore->Run();

	});

	// Pega as rotas das Frases Para Callback
	Route::get("/neuros", function(){

		header("Content-Type: application/json");
		echo file_get_contents('neural/neuro-system.json');

	});

	// ROTA PARA TESTAR O ROBO FEITO
	Route::get('/teste/(:any)/(:any)', function($id, $msg){

		
		print_r($callback->$msg($id));
		$url = 'https://graph.facebook.com/v2.6/me/messages?access_token=EAAQGTdkGPRgBAMOhvQMHZCZA349OpG2fpBRQslZAzYQgQ09LznZAFLJYLIW7HzGCKKF5flTPpe3GohE40BzXBWfwUGfXZChafcZAIXZCoRy5OnUj03ViD6ITJRUmls6090BcTuoe7GCMbAZC11a1qk39DEtuRZAsSed0JAPsGkXBs1QZDZD';
		$client = new \GuzzleHttp\Client(['headers' => [
			'Content-Type' => 'application/json'
		]]);
		$response = $client->post($url, array('body' => json_encode(array(
			"recipient" => array("id" => $id),
			"message" => array("text" => urldecode($msg))
		))));

	});

	Route::dispatch();