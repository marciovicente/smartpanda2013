<?php

class Model_DbTable_Pagamentos extends Zend_Db_Table_Abstract {
	protected $_name = 'pagamentos';
	
	//Incluir Nova Linha
	public function insert(array $data) {
		
		return parent::insert($data);
	}
	
}