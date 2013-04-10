<?php
 class Model_CampanhasConfigs {
 	//Model_Table_Guestbook
 	protected $_table;
 	
 	public function getTable() {
 		if(null === $this->_table) {
	 		require_once APPLICATION_PATH . '/models/DbTable/CampanhasConfigs.php';
	 		$this->_table = new Model_DbTable_CampanhasConfigs;
 		}
 		return $this->_table;
 	}
 	
 	//Grava uma nova entrada
 	public function save(array $data) {
 		$table = $this->getTable();
 		$fields = $table->info(Zend_Db_Table_Abstract::COLS);
 		foreach ($data as $field => $value) {
 			if(!in_array($field, $fields)) {
 				unset($data[$fields]);
 			}
 		}
 		return $table->insert($data);
 	}
 	
 	//Busca todas as entradas
 	public function fetchEntries() {
 		
 		return $this->getTable()->fetchAll('1')->toArray();
 	}
 	
 	//Busca uma entrada específica
 	public function fetchEntry($id) {
 		$table = $this->getTable();
 		$select = $table->select()->where('id = ?', $id);
 			
 		return $table->fetchRow($select)->toArray();
 	}
 	
 	//Retorna TRUE se o perfil definido na config da campanha se encaixarem com as informacoes do usuario
 	public function checkConfig($id_config, $profile) {
 		$config = $this->fetchEntry($id_config);
 		
 		if($config['genero']) {
 			if($config['genero'] != substr($profile['gender'],0,1)) return false;
 		}
 		
 		if($config['idade_min']) {
 			if($profile['idade'] < $config['idade_min']) return false;
 		}
 		
 		if($config['idade_max']) {
 			if($profile['idade'] > $config['idade_max']) return false;
 		}
 		

		$data_atual = new DateTime();
// 		$data_atual->setTimezone(new DateTimeZone('America/Bahia'));
 		if($config['data_min']) {
			$data_min = new DateTime($config['data_min']);
 			if($data_atual < $data_min) return false;
 		}
 		
 		if($config['data_max']) {
 			$data_max = new DateTime($config['data_max']);
 			if($data_atual > $data_max) return false;
 		}
 		
 		return true;
 	}

 	
 	//Retorna TRUE se a config da campanha se encaixa com a visualizacao publica
 	public function checkConfigPublico($id_config) {
 		$config = $this->fetchEntry($id_config);
 			
 		if($config['maior_idade']) {
 			if($config['maior_idade'] == 1) return false;
 		}
 			
 	
 		$data_atual = new DateTime();
 		if($config['data_min']) {
 			$data_min = new DateTime($config['data_min']);
 			if($data_atual < $data_min) return false;
 		}
 			
 		if($config['data_max']) {
 			$data_max = new DateTime($config['data_max']);
 			if($data_atual > $data_max) return false;
 		}
 			
 		return true;
 	}
 }