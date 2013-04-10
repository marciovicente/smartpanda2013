<?php
 class Model_Ofertas {
 	//Model_Table_Guestbook
 	protected $_table;
 	
 	public function getTable() {
 		if(null === $this->_table) {
	 		require_once APPLICATION_PATH . '/models/DbTable/Ofertas.php';
	 		$this->_table = new Model_DbTable_Ofertas;
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
 		$select = $table->select()->where('id IN (select id_oferta from campanhas where ativo = 1)');
 	
 		return $table->fetchAll($select)->toArray();
 	}
 	
 	//Busca ofertas pelo id do usuario
 	public function getOfertas($id_usuario) {
 		$table = $this->getTable();
 		$select = $table->select()->where('id_usuario = ?', $id_usuario);
 	
 		return $table->fetchAll($select)->toArray();
 	}
 	
 	//Busca ofertas pelo id do estabelecimento
 	public function getOfertasByEstabelecimento($id_estabelecimento) {
 		$table = $this->getTable();
 		$select = $table->select()->where('id_estabelecimento = ?', $id_estabelecimento);
 	
 		return $table->fetchAll($select)->toArray();
 	}
 	
 	public function getQtdOfertas($id_estabelecimento, $profile = false) {
 		require_once APPLICATION_PATH . '/models/Campanhas.php';
		$model_campanhas = new Model_Campanhas();
		require_once APPLICATION_PATH . '/models/CampanhasConfigs.php';
		$model_campanhasconfigs = new Model_CampanhasConfigs();
 		
 		$table = $this->getTable();
 		$select = $table->select()->where('id_estabelecimento = '.$id_estabelecimento);
 		$ofertas = $table->fetchAll($select)->toArray();
 		$nrCampanhas = 0;
 		foreach($ofertas as $value) {
 			$campanha_da_oferta = $model_campanhas->getCampanhas($value['id']);
 			$campanha_da_oferta = $campanha_da_oferta[0];
 			if($campanha_da_oferta['ativo'] == 1) {
 				if($profile) {
 					$id_config = $campanha_da_oferta['id_config'];
 					if($model_campanhasconfigs->checkConfig($id_config, $profile))
 						$nrCampanhas++;
 				} else
 					$nrCampanhas++;
 			}
 		}
 		
 		return $nrCampanhas;
 	}
 	
 	//Seta o nome da imagem
 	public function setImagem($id, $nome) {
 		$where = 'id = '.$id;
 		$data = array('imagem' => $nome);
 	
 		$table = $this->getTable();
 		$table->update($data, $where);
 	}
 	
 	//Alterar estabelecimento da oferta
 	public function setEstabelecimento($id_oferta, $id_estabelecimento) {
 		$where = 'id = '.$id_oferta;
 		$data = array('id_estabelecimento' => $id_estabelecimento);
 		$table = $this->getTable();
 		$table->update($data, $where);
 	}

 }