<?php

class Model_DbTable_Estados extends Zend_Db_Table_Abstract {
	protected $_name = 'estados';
	
	//Incluir Nova Linha
	public function insert(array $data) {
		
		return parent::insert($data);
	}
	
}