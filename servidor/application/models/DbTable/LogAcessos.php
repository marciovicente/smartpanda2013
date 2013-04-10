<?php

class Model_DbTable_LogAcessos extends Zend_Db_Table_Abstract {
	protected $_name = 'logAcessos';
	
	//Incluir Nova Linha
	public function insert(array $data) {
		
		return parent::insert($data);
	}
	
}