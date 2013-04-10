<?php

class Model_DbTable_Cidades extends Zend_Db_Table_Abstract {
	protected $_name = 'cidades';
	
	//Incluir Nova Linha
	public function insert(array $data) {
		
		return parent::insert($data);
	}
	
}