<?php

class Model_DbTable_Assinaturas extends Zend_Db_Table_Abstract {
	protected $_name = 'assinaturas';
	
	//Incluir Nova Linha
	public function insert(array $data) {
		
		return parent::insert($data);
	}
	
}