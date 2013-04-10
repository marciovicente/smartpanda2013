<?php

class Model_DbTable_LogPromocoes extends Zend_Db_Table_Abstract {
	protected $_name = 'logPromocoes';
	
	//Incluir Nova Linha
	public function insert(array $data) {

		return parent::insert($data);
	}
	
}