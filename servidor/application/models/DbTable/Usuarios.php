<?php

class Model_DbTable_Usuarios extends Zend_Db_Table_Abstract {
	protected $_name = 'usuarios';
	
	//Incluir Nova Linha
	public function insert(array $data) {
		
		return parent::insert($data);
	}
	
}