<?php

class Model_DbTable_Ofertas extends Zend_Db_Table_Abstract {
	protected $_name = 'ofertas';
	
	//Incluir Nova Linha
	public function insert(array $data) {
		mb_internal_encoding("UTF-8");
		
		$data['titulo'] = mb_substr(trim(preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", " ", $data['titulo'])),0,30);
		$data['nome'] = mb_substr(trim(preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", " ", $data['nome'])),0,30);
		$data['texto'] = mb_substr(trim(preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", " ", $data['texto'])),0,120);
		$data['imagem'] = mb_substr(trim($data['imagem']),0,32);
		
		return parent::insert($data);
	}
	
}