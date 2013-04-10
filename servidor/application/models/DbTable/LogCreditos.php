<?php

class Model_DbTable_LogCreditos extends Zend_Db_Table_Abstract {
	protected $_name = 'logCreditos';
	
	//Incluir Nova Linha
	public function insert(array $data) {
		
		
		return parent::insert($data);
	}
	
}