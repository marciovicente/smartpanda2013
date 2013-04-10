<?php

class Model_DbTable_CampanhasConfigs extends Zend_Db_Table_Abstract {
	protected $_name = 'campanhasConfigs';
	
	//Incluir Nova Linha
	public function insert(array $data) {
		
		if($data['idade_min'] <= 0) $data['idade_min'] = "";
		if($data['idade_min'] > 99) $data['idade_min'] = 99;
		
		if($data['idade_max'] < 0) $data['idade_max'] = 0;
		if($data['idade_max'] >= 99) $data['idade_max'] = "";
		
		if(($data['maior_idade'] == 1) and ($data['idade_min'] < 18)) $data['idade_min'] = 18; 
		
		if($data['data_min']) {
			$validade = new DateTime($data['data_min']);
			$validade->setTime(0, 0, 0);
			$data['data_min'] = $validade->format('Y-m-d H:i:s');
		}
		
		if($data['data_max']) {
			$validade = new DateTime($data['data_max']);
			$validade->setTime(23, 59, 59);
			$data['data_max'] = $validade->format('Y-m-d H:i:s');
		}
		
		return parent::insert($data);
	}
	
}