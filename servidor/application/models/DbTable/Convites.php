<?php

class Model_DbTable_Convites extends Zend_Db_Table_Abstract {
	protected $_name = 'convites';
	
	//Incluir Nova Linha
	public function insert(array $data) {
		
		
		return parent::insert($data);
	}
	
}