<?php
 class Model_Assinaturas {
 	protected $_table;
 	
 	public function getTable() {
 		if(null === $this->_table) {
	 		require_once APPLICATION_PATH . '/models/DbTable/Assinaturas.php';
	 		$this->_table = new Model_DbTable_Assinaturas;
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
 	
 	//Atualiza uma entrada
 	public function update(array $data, $id) {
 		$table = $this->getTable();
 		$fields = $table->info(Zend_Db_Table_Abstract::COLS);
 		foreach ($data as $field => $value) {
 			if(!in_array($field, $fields)) {
 				unset($data[$fields]);
 			}
 		}
 		$where = 'id = '.$id;
 		return $table->update($data, $where);
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
 	
 	//Retorna as assinaturas por usuario
 	public function getAssinaturasByUsuario($id_usuario) {
 		$table = $this->getTable();
 		$select = $table->select()->where('id_usuario = ?', $id_usuario);
 		$rowset = $table->fetchAll($select);
 		if(count($rowset)>0) {
 			return $rowset->toArray();
 		} else {
 			return false;
 		}
 	}
 	
 	//Retorna as assinaturas por estabelecimento
 	public function getAssinaturasByEstabelecimento($id_estabelecimento) {
 		$table = $this->getTable();
 		$select = $table->select()->where('id_estabelecimento = ?', $id_estabelecimento);
 		$rowset = $table->fetchAll($select);
 		if(count($rowset)>0) {
 			return $rowset->toArray();
 		} else {
 			return false;
 		}
 	}
 	
 	//Assina um plano
 	public function assinar($assinatura) {
 		$assinaturas = $this->getAssinaturasByEstabelecimento($assinatura['id_estabelecimento']);
 		$planos_assinados = array();
 		if($assinaturas) {
	 		foreach ($assinaturas as $dado) {
	 			$planos_assinados[] = $dado['id_plano'];
	 		}
 		}
 		if((!in_array($assinatura['id_plano'], $planos_assinados))) {
	 		$data_atual = new DateTime();
	 		$assinatura['inicio'] = date("Y-m-d H:i:s");
	 		if($assinatura['id_plano'] == 4) { //Se for Smartpanda TV
	 			if(in_array(2, $planos_assinados)) { //Se for assinante do plano Professional
	 				$assinatura['desconto'] = $assinatura['preco'] * 0.7; //70% de desconto
	 			}
	 			if(in_array(3, $planos_assinados)) { //Se for assinante do plano Premium
	 				$assinatura['desconto'] = $assinatura['preco']; //100% de desconto
	 			}
	 		}
	 		
	 		return $this->save($assinatura);
 		}
 	}
 	
 	//Configura a assinatura como paga
 	public function setPaga($id_assinatura) {
 		$data_atual = new DateTime();
 		$data = $data_atual->format('Y-m-d H:i:s');
 		
 		try {
 			$where = 'id = '.$id_assinatura;
 			$data = array('pago' => $data, 'ativo' => '1');
 			$table = $this->getTable();
 			$table->update($data, $where);
 				
 			return true;
 		} catch (Exception $e) {
 			return false;
 		}
 	}
 	

 }