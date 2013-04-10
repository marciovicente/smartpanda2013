<?php
 class Model_CampanhasVotos {
 	//Model_Table_Guestbook
 	protected $_table;
 	
 	public function getTable() {
 		if(null === $this->_table) {
	 		require_once APPLICATION_PATH . '/models/DbTable/CampanhasVotos.php';
	 		$this->_table = new Model_DbTable_CampanhasVotos;
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
 	
 	//Verifica se um usuario ja votou:curtir ou nao curtir
 	public function jaVotou($id_campanha, $id_facebook) {
 		$table = $this->getTable();
 		$select = $table->select()->where('id_campanha = '.$id_campanha.' AND id_usuario = '.$id_facebook);
 		$linha = $table->fetchAll($select)->toArray();
 		if(isset($linha[0])) {
 			return TRUE;
 		} else {
 			return FALSE;
 		}
 		
 	}
 	
 	//Verifica se um usuario curtiu a oferta
 	public function curtiu($id_campanha, $id_facebook) {
 		$table = $this->getTable();
 		$select = $table->select()->where('id_campanha = '.$id_campanha.' AND id_usuario = '.$id_facebook);
 		$linha = $table->fetchAll($select)->toArray();
 		if($linha[0]['curtir']) {
 			return TRUE;
 		} else {
 			return FALSE;
 		}
 			
 	}
 	
 	//Busca usuarios que escolheram uma determinada opcao na campanha
 	public function usuariosVotaram($id_opcao) {
 		$table = $this->getTable();
 		$select = $table->select()->where('curtir = '.$id_opcao);
 		$linha = $table->fetchAll($select)->toArray();
 		
 		return $linha;
 	}

 }