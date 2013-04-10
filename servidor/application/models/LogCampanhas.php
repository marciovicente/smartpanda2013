<?php
 class Model_LogCampanhas {
 	protected $_table;
 	
 	public function getTable() {
 		if(null === $this->_table) {
	 		require_once APPLICATION_PATH . '/models/DbTable/LogCampanhas.php';
	 		$this->_table = new Model_DbTable_LogCampanhas;
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
 	
 	//Registra inicio no log
 	public function startCampanha($id_campanha, $id_usuario) {
 		$data_atual = new DateTime();
 		$log['id_campanha'] = $id_campanha;
 		$log['inicio'] = $data_atual->format('Y-m-d H:i:s');
 		$log['id_usuario_inicio'] = $id_usuario;
 		
 		return $this->save($log);
 	}
 	
 	//Registra fim no log
 	public function endCampanha($id_campanha, $id_usuario) {
 		$data_atual = new DateTime();
 		$log['id_campanha'] = $id_campanha;
 		$log['fim'] = $data_atual->format('Y-m-d H:i:s');
 		$log['id_usuario_fim'] = $id_usuario;
 			
 		return $this->save($log);
 	}
 	

 }