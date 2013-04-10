<?php

class Model_DbTable_Estabelecimentos extends Zend_Db_Table_Abstract {
	protected $_name = 'estabelecimentos';
	
	//Incluir Nova Linha
	public function insert(array $data) {
		mb_internal_encoding("UTF-8");
		
		if(isset($data['razao_social'])) $data['razao_social'] = mb_substr(trim(preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", " ", $data['razao_social'])),0,100);
		$data['nome_fantasia'] = mb_substr(trim(preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", " ", $data['nome_fantasia'])),0,100);
		if(isset($data['cnpj'])) $data['cnpj'] = mb_substr(trim(preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", " ", $data['cnpj'])),0,14);
		if(isset($data['endereco'])) $data['endereco'] = mb_substr(trim(preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", " ", $data['endereco'])),0,120);
		if(isset($data['complemento'])) $data['complemento'] = mb_substr(trim(preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", " ", $data['complemento'])),0,50);
		if(isset($data['cep'])) $data['cep'] = mb_substr(trim(preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", " ", $data['cep'])),0,8);
		if(isset($data['email'])) $data['email'] = mb_substr(trim(preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", " ", $data['email'])),0,255);
		
		return parent::insert($data);
	}
	
}