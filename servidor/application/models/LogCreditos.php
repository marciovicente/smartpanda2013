<?php
 class Model_LogCreditos {
 	protected $_table;
 	
 	public function getTable() {
 		if(null === $this->_table) {
	 		require_once APPLICATION_PATH . '/models/DbTable/LogCreditos.php';
	 		$this->_table = new Model_DbTable_LogCreditos;
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
 	
 	//Busca historico pelo id do remetente
 	public function getLogRemetente($id_remetente) {
 		$table = $this->getTable();
 		$select = $table->select()
 			->where('id_remetente = ?', $id_remetente)
	 		->order('id DESC')
	 		->limit(20,0);
 	
 		return $table->fetchAll($select)->toArray();
 	}
 	
 	//Busca historico pelo id do destinatario
 	public function getLogDestinatario($id_destinatario) {
 		$table = $this->getTable();
 		$select = $table->select()
 			->where('id_destinatario = ?', $id_destinatario)
 			->order('id DESC')
 			->limit(20,0);
 	
 		return $table->fetchAll($select)->toArray();
 	}

 	//Grava no log uma transacao
 	public function log($id_remetente, $id_destinatario, $creditos) {
 		$log['id_remetente'] = $id_remetente;
 		$log['id_destinatario'] = $id_destinatario;
 		$log['quantidade'] = $creditos;
 		
 		$this->save($log);
 	}

 }