<?php
 class Model_LogPromocoes {
 	protected $_table;
 	
 	public function getTable() {
 		if(null === $this->_table) {
	 		require_once APPLICATION_PATH . '/models/DbTable/LogPromocoes.php';
	 		$this->_table = new Model_DbTable_LogPromocoes;
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
 	
 	//Registra entrada de um usuario em um plano promocional no log
 	public function joinPromocao($id_promocao, $id_usuario) {
 		$log['id_promocao'] = $id_promocao;
 		$log['id_usuario'] = $id_usuario;
 		
 		return $this->save($log);
 	}
 	
 	//Retorna qtd de assinantes de uma promocao
 	public function getQtdAssinantes($id_promocao) {
 		$table = $this->getTable();
 		$select = $table->select()->where('id_promocao = '.$id_promocao.' and ativo = 1');
 		$rowset = $table->fetchAll($select);
 		if(count($rowset) < 1)
 			return false;
 		else
 			return count($rowset);
 	}
 	
 	//Verifica se um usuario se inscreveu em uma promocao
 	public function getPromocaoByUsuario($id_usuario) {
 		$table = $this->getTable();
 		$select = $table->select()->where('id_usuario = ?', $id_usuario);
 		$rowset = $table->fetchAll($select);
 		if(count($rowset)>0) {
 			$promocao = $rowset->toArray();
 			return $promocao[0];
 		} else return false;
 	}

 }