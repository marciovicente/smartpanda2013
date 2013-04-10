<?php

class Model_DbTable_LogCampanhasUsuarios extends Zend_Db_Table_Abstract {
	protected $_name = 'logCampanhasUsuarios';
	
	//Incluir Nova Linha
	public function insert(array $data) {

		return parent::insert($data);
	}
	
}