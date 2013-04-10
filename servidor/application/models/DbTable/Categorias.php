<?php

class Model_DbTable_Categorias extends Zend_Db_Table_Abstract {
	protected $_name = 'categorias';
	
	//Incluir Nova Linha
	public function insert(array $data) {
		
		
		return parent::insert($data);
	}
	
}