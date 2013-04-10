<?php
 class Model_Telefones {
 	protected $_table;
 	
 	public function getTable() {
 		if(null === $this->_table) {
	 		require_once APPLICATION_PATH . '/models/DbTable/Telefones.php';
	 		$this->_table = new Model_DbTable_Telefones;
 		}
 		return $this->_table;
 	}
 	
 	//Grava uma nova entrada
 	public function save(array $data) {
 		if(($data['numero'] != null) and ($data['numero'] != "")) {
	 		$table = $this->getTable();
	 		$fields = $table->info(Zend_Db_Table_Abstract::COLS);
	 		foreach ($data as $field => $value) {
	 			if(!in_array($field, $fields)) {
	 				unset($data[$fields]);
	 			}
	 		}
	 		return $table->insert($data);
 		} else return false;
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
 	
 	//Retorna os telefones de um estabelecimento
 	public function getTelefonesByEstabelecimento($id_estabelecimento) {
 		$table = $this->getTable();
 		$select = $table->select()->where('id_estabelecimento = '.$id_estabelecimento);
 	
 		return $table->fetchAll($select)->toArray();
 	}
 	

 }