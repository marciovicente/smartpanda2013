<?php
 class Model_Cidades {
 	protected $_table;
 	
 	public function getTable() {
 		if(null === $this->_table) {
	 		require_once APPLICATION_PATH . '/models/DbTable/Cidades.php';
	 		$this->_table = new Model_DbTable_Cidades;
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
 	
 	//Retorna as cidades ativas em ordem alfabetica
 	public function getCidades() {
 		$table = $this->getTable();
 		$select = $table->select()->order('nome');
 	
 		return $table->fetchAll($select)->toArray();
 	}
 	
 	//Verifica tem cadastrada uma determinada cidade em um estado especifico
 	public function temCidade($id_estado, $cidade) {
 		$table = $this->getTable();
 		$select = $table->select()->where('id_estado = '.$id_estado.' and nome = "'.$cidade.'"');
 		$rowset = $table->fetchRow($select);
 		if(count($rowset)>0) {
 			return $rowset->toArray();
 		} else return false;
 	}

 }