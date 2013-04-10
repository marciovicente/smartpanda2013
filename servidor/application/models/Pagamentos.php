<?php
 class Model_Pagamentos {
 	protected $_table;
 	
 	public function getTable() {
 		if(null === $this->_table) {
	 		require_once APPLICATION_PATH . '/models/DbTable/Pagamentos.php';
	 		$this->_table = new Model_DbTable_Pagamentos;
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
 	
 	//Altera um campo especifico de uma linha especifica
 	public function setFieldById($id, $field, $value) {
 		try {
 			$where = 'id = '.$id;
 			$data = array($field => $value);
 			$table = $this->getTable();
 			$table->update($data, $where);
 	
 			return true;
 		} catch (Exception $e) {
 			return false;
 		}
 	}
 	
 	//Retorna os resultados ativos (ativo == 1)
 	public function getAtivos() {
 		$table = $this->getTable();
 		$select = $table->select()->where('ativo = 1');
 	
 		return $table->fetchAll($select)->toArray();
 	}
 	
 	//Atualiza informacoes do pagamento a partir do que foi recebido do pagseguro
 	public function updatePagamento($id_pagamento, $notificationCode, $transactionID, $status) {
 		try {
 			$where = 'id = '.$id_pagamento;
 			$data = array('notification_code' => $notificationCode, 'transaction_id' => $transactionID, 'status' => $status);
 			$table = $this->getTable();
 			$table->update($data, $where);
 		
 			return true;
 		} catch (Exception $e) {
 			return false;
 		}
 	}

 }