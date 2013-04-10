<?php

class Model_DbTable_Planos extends Zend_Db_Table_Abstract {
	protected $_name = 'planos';
	
	//Incluir Nova Linha
	public function insert(array $data) {
		
		return parent::insert($data);
	}
	
}