<?php

class Model_DbTable_Telefones extends Zend_Db_Table_Abstract {
	protected $_name = 'telefones';
	
	//Incluir Nova Linha
	public function insert(array $data) {
		
		return parent::insert($data);
	}
	
}