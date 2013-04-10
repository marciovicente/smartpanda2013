<?php
 class Model_Convites {
 	protected $_table;
 	
 	public function getTable() {
 		if(null === $this->_table) {
	 		require_once APPLICATION_PATH . '/models/DbTable/Convites.php';
	 		$this->_table = new Model_DbTable_Convites;
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
 	
 	//Busca convites pelo id do shopping
 	public function getConvites($id_shopping) {
 		$table = $this->getTable();
 		$select = $table->select()->where('id_shopping = ?', $id_shopping);
 	
 		return $table->fetchAll($select)->toArray();
 	}
 	
 	//Busca um convite pelo seu codigo
 	public function getConviteByCodigo($codigo) {
 		$table = $this->getTable();
 		$select = $table->select()->where('codigo = ?', $codigo);
 		$rowset = $table->fetchRow($select);
 		if(count($rowset)>0) {
 			return $rowset->toArray();
 		} else {
 			return false;
 		}
 		
 	}
 	
 	//Gera convite e retorna o codigo dele
 	public function gerarConvite($id_shopping) {
 		do {
 			$codigo = $this->random_string(8);
 		} while ($this->getConviteByCodigo($codigo));
 		
 		$convite['codigo'] = $codigo;
 		$convite['id_shopping'] = $id_shopping;
 		
 		$this->save($convite);
 		
 		return $codigo;
 	}
 	
 	//Remove um convite
 	public function removerConvite($id) {
 		if($this->conviteDisponivel($id)) {
 			$where = 'id = '.$id;
 			$table = $this->getTable();
 			$table->delete($where);
 			
 			return true;
 		} else {
 			return false;
 		}
 		
 	}
 	
 	//Retorna TRUE (convite disponivel) ou FALSE (convite nao disponivel)
 	public function conviteDisponivel($id) {
 		$table = $this->getTable();
 		$select = $table->select()->where('id = '.$id.' AND id_lojista IS NULL');
 		$rowset = $table->fetchRow($select);
 		if(count($rowset)>0) {
 			return true;
 		} else {
 			return false;
 		}
 	}
 	
 	public function aceitarConvite($id, $id_lojista) {
 		$convite = $this->fetchEntry($id);
 		$id_shopping = $convite['id_shopping'];
 		
 		$where = 'id = '.$id;
 		$data = array('id_lojista' => $id_lojista);
 		
 		$table = $this->getTable();
 		$table->update($data, $where);
 		
 		require_once APPLICATION_PATH . '/models/Usuarios.php';
 		$model_usuario = new Model_Usuarios();
 		$model_usuario->entrarNoShopping($id_lojista, $id_shopping);
 	}
 	
 	//Gera sequencias aleatorias
 	private function random_string($tamanho)
 	{
 		$character_set_array = array();
 		$character_set_array[] = array('count' => $tamanho, 'characters' => '0123456789abcdefghijklmnopqrstuvwxyz');
 		$temp_array = array();
 		foreach ($character_set_array as $character_set) {
 			for ($i = 0; $i < $character_set['count']; $i++) {
 				$temp_array[] = $character_set['characters'][rand(0, strlen($character_set['characters']) - 1)];
 			}
 		}
 		shuffle($temp_array);
 		return implode('', $temp_array);
 	}

 }