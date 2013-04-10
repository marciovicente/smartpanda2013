<?php

class Model_DbTable_Promocoes extends Zend_Db_Table_Abstract {
	protected $_name = 'promocoes';
	
	//Incluir Nova Linha
	public function insert(array $data) {

		return parent::insert($data);
	}
	
}