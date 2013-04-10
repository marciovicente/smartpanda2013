<?php
 class Model_Usuarios {
 	public $id_facebook;

 	
//  	//Configura o id_facebook a partir do usuario logado
//  	public function loadUsuarioLogado() {
//  		$face = Zend_Registry::get('facebook');
//  		$facebook = new Facebook($face);
//  		$this->id_facebook = $facebook->getUser();
//  		if($this->id_facebook == "") $this->id_facebook = $face['appId']; // SOMENTE PARA TESTES
 		
//  		return $this->getUsuario();
//  	}
 	
//  	//Retorna um usuario a partir do ID_FACEBOOK
//  	public function getUsuario() {
//  		$face = Zend_Registry::get('facebook');
//  		$facebook = new Facebook($face);
//  		$token = $facebook->getAccessToken();
 		
//  		$servidor = Zend_Registry::get('configuration')->servidor;
//  		file_get_contents($servidor."login?t=".$token);
//  		$usuario = json_decode(file_get_contents($servidor."getusuariologado"), true);
 		
//  		return $usuario[0];
//  	}
 	
 	public function getUserProfile() {
 		$face = Zend_Registry::get('facebook');
 		$facebook = new Facebook($face);
 		
 		try {
 			$profile = $facebook->api('/me','GET');
 		} catch (Exception $e) {
 			$profile['first_name'] = "Usuário";
 			$profile['name'] = "Usuário";
 			$profile['gender'] = "male";
 		}
 		
 		return $profile;
 	}

 }