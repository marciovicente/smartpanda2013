<?php
 class Model_Campanhas {
 	//Model_Table_Guestbook
 	protected $_table;
 	
 	public function getTable() {
 		if(null === $this->_table) {
	 		require_once APPLICATION_PATH . '/models/DbTable/Campanhas.php';
	 		$this->_table = new Model_DbTable_Campanhas;
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
 	
 	//Incrementa o nr de curtidas
 	public function curtir($id_campanha) {
 		$where = 'id = '.$id_campanha;
 		$data = array('curtiram' => new Zend_Db_Expr('curtiram + 1'));
 		$table = $this->getTable();
 		$table->update($data, $where);
 	}
 	
 	//Incrementa o nr de "não curtidas"
 	public function naoCurtir($id_campanha) {
 		$where = 'id = '.$id_campanha;
 		$data = array('nao_curtiram' => new Zend_Db_Expr('nao_curtiram + 1'));
 		$table = $this->getTable();
 		$table->update($data, $where);
 	}
 	
 	//Incrementa o nr de uma acao
 	public function incAcao($id_campanha, $acao) {
 		if(!isset($_SESSION['acoes'][$id_campanha][$acao])) {
 			$_SESSION['acoes'][$id_campanha][$acao] = 1;
	 		$where = 'id = '.$id_campanha;
	 		$data = array($acao => new Zend_Db_Expr($acao.' + 1'));
	 		$table = $this->getTable();
	 		$table->update($data, $where);
 		}
 	}
 	
 	//Busca campanha pelo id da oferta
 	public function getCampanhas($id_oferta) {
 		$table = $this->getTable();
 		$select = $table->select()->where('id_oferta = ?', $id_oferta);
 	
 		return $table->fetchAll($select)->toArray();
 	}
 	
 	//Computa o voto (curtir/nao curtir) em uma campanha
 	public function computarVoto($id_campanha, $voto) {
 		$where = 'id = '.$id_campanha;
 		if($voto == 1) {
 			//CURTIR
 			$data = array('curtiram' => new Zend_Db_Expr('curtiram + 1'));
 		} else {//NAO CURTIR
 			//  			$sql = "UPDATE 'enquetes' SET nao = (nao+1) WHERE id = ?";
 			$data = array('nao_curtiram' => new Zend_Db_Expr('nao_curtiram + 1'));
 		}
 		$table = $this->getTable();
 		$table->update($data, $where);
 	}
 	
 	//Alterar status da campanha
 	public function setStatusCampanha($id_campanha, $status) {
 		$where = 'id = '.$id_campanha;
 		$data = array('ativo' => $status);
 		$table = $this->getTable();
 		$table->update($data, $where);
 	}
 	
 	//Alterar numero maximo de creditos da campanha
 	public function setCreditos($id_campanha, $creditos) {
 		$where = 'id = '.$id_campanha;
 		$data = array('maximo' => $creditos);
 		$table = $this->getTable();
 		$table->update($data, $where);
 	}

 }