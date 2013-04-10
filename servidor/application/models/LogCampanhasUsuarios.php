<?php
 class Model_LogCampanhasUsuarios {
 	protected $_table;
 	
 	public function getTable() {
 		if(null === $this->_table) {
	 		require_once APPLICATION_PATH . '/models/DbTable/LogCampanhasUsuarios.php';
	 		$this->_table = new Model_DbTable_LogCampanhasUsuarios;
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
 	
 	//Registra uma acao no log
 	public function setAcao($id_campanha, $id_usuario, $acao) {
 		$log['id_campanha'] = $id_campanha;
 		$log['id_usuario'] = $id_usuario;
 		$log[$acao] = 1;
 		
 		return $this->save($log);
 	}
 	
 	//Verifica se um usuario ja realizou uma determinada acao para uma oferta/campanha especifica
 	public function isChecked($id_campanha, $id_usuario, $acao) {
 		$table = $this->getTable();
 		$select = $table->select()->where('id_campanha = '.$id_campanha.' and id_usuario = '.$id_usuario.' and '.$acao.' = 1');
 		$rowset = $table->fetchRow($select);
 		if(count($rowset)>0) {
 			return true;
 		} else return false;
 	
 	}
 	
 	//Retorna o numero total de uma acao (incluindo repeticoes por usuario)
 	public function getTotalAcao($id_campanha, $acao) {
 		$table = $this->getTable();
 		$select = $table->select()->where('id_campanha = '.$id_campanha.' and '.$acao.' = 1');
 		$rowset = $table->fetchAll($select);
 		
 		return count($rowset);
 	}
 	
 	//Retorna o numero total de visitantes unicos (sem repeticoes)
 	public function getTotalDistinctUser($id_campanha, $acao) {
 		$table = $this->getTable();
 		$select = $table->select()->distinct()->from('logCampanhasUsuarios','id_usuario')->where('id_campanha = '.$id_campanha.' and '.$acao.' = 1');
 		$rowset = $table->fetchAll($select);
 			
 		return count($rowset);
 	}

 }