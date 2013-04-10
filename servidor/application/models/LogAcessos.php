<?php
 class Model_LogAcessos {
 	protected $_table;
 	
 	public function getTable() {
 		if(null === $this->_table) {
	 		require_once APPLICATION_PATH . '/models/DbTable/LogAcessos.php';
	 		$this->_table = new Model_DbTable_LogAcessos;
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
 	
 	public function log($id_usuario) {
 		$log['id_usuario'] = $id_usuario;
 		$log['ip'] = $_SERVER['REMOTE_ADDR'];
 		$log['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
 		
 		return $this->save($log);
 	}
 	

 }