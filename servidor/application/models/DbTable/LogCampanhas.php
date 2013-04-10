<?php

class Model_DbTable_LogCampanhas extends Zend_Db_Table_Abstract {
	protected $_name = 'logCampanhas';
	
	//Incluir Nova Linha
	public function insert(array $data) {
		
		return parent::insert($data);
	}
	
}