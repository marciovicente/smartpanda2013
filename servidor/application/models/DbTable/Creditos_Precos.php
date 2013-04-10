<?php

class Model_DbTable_Creditos_Precos extends Zend_Db_Table_Abstract {
	protected $_name = 'creditos_precos';
	
	//Incluir Nova Linha
	public function insert(array $data) {
		
		return parent::insert($data);
	}
	
}