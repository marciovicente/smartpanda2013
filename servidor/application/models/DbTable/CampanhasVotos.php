<?php

class Model_DbTable_CampanhasVotos extends Zend_Db_Table_Abstract {
	protected $_name = 'campanhasVotos';
	
	//Incluir Nova Linha
	public function insert(array $data) {
		$face = Zend_Registry::get('facebook');
		$facebook = new Facebook($face);
		$user = $facebook->getUser();
		
		if($user=="") { $user = $face['appId']; }
		$data['id_usuario'] = $user;

		return parent::insert($data);
	}
	
	public function update(array $data, $where) {
		throw new Exception('Erro ao salvar o voto no servidor.');
	}
	
}