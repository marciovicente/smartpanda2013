<?php
 class Model_Promocoes {
 	protected $_table;
 	
 	public function getTable() {
 		if(null === $this->_table) {
	 		require_once APPLICATION_PATH . '/models/DbTable/Promocoes.php';
	 		$this->_table = new Model_DbTable_Promocoes;
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
 	
 	//verifica se uma promocao ainda eh valida
 	public function checkPromocao($id_promocao) {
 		require_once APPLICATION_PATH . '/models/LogPromocoes.php';
 		$model_logPromocao = new Model_LogPromocoes();
 		
 		$promocao = $this->fetchEntry($id_promocao);
 		
 		$qtd_assinantes = $model_logPromocao->getQtdAssinantes($id_promocao);
 		$max_assinantes = $promocao['max_assinantes'];
 		
 		if($qtd_assinantes >= $max_assinantes) {
 			$resultado['valid'] = false;
 			$resultado['mensagem'] = 'Essa promoção já atingiu o número máximo de participantes.';
 			return $resultado;
 		}
 		
 		$data_atual = new DateTime();
 		if($promocao['inicio']) {
 			$data_min = new DateTime($promocao['inicio']);
 			if($data_atual < $data_min) {
 				$resultado['valid'] = false;
 				$resultado['mensagem'] = 'Essa promoção não está ativa ainda.';
 				return $resultado;
 			}
 		}
 			
 		if($promocao['fim']) {
 			$data_max = new DateTime($promocao['fim']);
 			if($data_atual > $data_max) {
 				$resultado['valid'] = false;
 				$resultado['mensagem'] = 'Essa promoção já expirou.';
 				return $resultado;
 			}
 		}
 		
 		$resultado['valid'] = true;
 		$resultado['mensagem'] = 'Promoção válida.';
 		return $resultado;
 	}

 }