<?php
 class Model_LogSistemas {
 	protected $_table;
 	
 	public function getTable() {
 		if(null === $this->_table) {
	 		require_once APPLICATION_PATH . '/models/DbTable/LogSistema.php';
	 		$this->_table = new Model_DbTable_LogSistema;
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
 	
 	//Busca um campo especifico de uma linha especifica
 	public function getFieldById($id, $field) {
 		$entrada = $this->fetchEntry($id);
 		return $entrada[$field];
 	}
 	
 	//Retorna os resultados ativos (ativo == 1)
 	public function getAtivos() {
 		$table = $this->getTable();
 		$select = $table->select()->where('ativo = 1');
 	
 		return $table->fetchAll($select)->toArray();
 	}
 	
 	public function log($tipo, $mensagem) {
//  		EMERG   = 0;  // Emergency: system is unusable
//  		ALERT   = 1;  // Alert: action must be taken immediately
//  		CRIT    = 2;  // Critical: critical conditions
//  		ERR     = 3;  // Error: error conditions
//  		WARN    = 4;  // Warning: warning conditions
//  		NOTICE  = 5;  // Notice: normal but significant condition
//  		INFO    = 6;  // Informational: informational messages
//  		DEBUG   = 7;  // Debug: debug messages
 		
 		$log['tipo'] = $tipo;
 		$log['mensagem'] = $mensagem;
 			
 		return $this->save($log);
 	}

 }