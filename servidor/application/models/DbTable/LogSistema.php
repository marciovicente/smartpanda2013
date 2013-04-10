<?php

class Model_DbTable_LogSistema extends Zend_Db_Table_Abstract {
	protected $_name = 'logSistema';
	
	//Incluir Nova Linha
	public function insert(array $data) {
		
		return parent::insert($data);
	}
	
}