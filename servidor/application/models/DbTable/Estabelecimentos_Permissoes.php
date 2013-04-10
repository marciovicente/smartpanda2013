<?php

class Model_DbTable_Estabelecimentos_Permissoes extends Zend_Db_Table_Abstract {
	protected $_name = 'estabelecimentos_permissoes';
	
	//Incluir Nova Linha
	public function insert(array $data) {
		
		return parent::insert($data);
	}
	
}