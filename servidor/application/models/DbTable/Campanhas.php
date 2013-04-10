<?php

class Model_DbTable_Campanhas extends Zend_Db_Table_Abstract {
	protected $_name = 'campanhas';
	
	//Incluir Nova Linha
	public function insert(array $data) {
		
		return parent::insert($data);
	}
	
}