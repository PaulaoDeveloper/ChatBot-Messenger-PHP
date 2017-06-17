<?php
class CallBacksMessages
{
	private static $info;
	private static $data;

	private construct() { }
	
	public static function getInstance(array $userInfo)
	{
		if (is_null(self::$info)
		{
			self::$info = $userInfo;
			self::$data = Facebook::people(self::$info['user_id']);
		}
		
		return self::$info;
	}

	public static function callBackName()
	{
		return 'Seu nome é: ' . self::$data['nome'];
	}

	public static function callBackHi()
	{
		return 'Olá, tudo bem ' . self::$data['nome'] . ' ?';
	}
}

/*
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
*/
	
