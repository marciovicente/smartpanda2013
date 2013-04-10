<?php
 class Model_Estabelecimentos {
 	protected $_table;
 	
 	public function getTable() {
 		if(null === $this->_table) {
	 		require_once APPLICATION_PATH . '/models/DbTable/Estabelecimentos.php';
	 		$this->_table = new Model_DbTable_Estabelecimentos;
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
 	
 	//Deleta uma entrada
 	public function delete($id) {
 		$where = 'id = '.$id;
 		$table = $this->getTable();
 		$table->delete($where);
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
 	
 	public function getNome($id_estabelecimento) {
 		$usuario = $this->fetchEntry($id_estabelecimento);
 			
 		return $usuario['nome_fantasia'];
 	}
 	
 	public function setNome($id_estabelecimento, $nome_fantasia) {
 		try {
 			$where = 'id = '.$id_estabelecimento;
 			$data = array('nome_fantasia' => $nome_fantasia);
 			$table = $this->getTable();
 			$table->update($data, $where);
 	
 			return true;
 		} catch (Exception $e) {
 			return false;
 		}
 	}
 	
 	//Busca uma entrada específica
 	public function getByUsuario($id_usuario) {
 		$table = $this->getTable();
 		$select = $table->select()->where('id_usuario = ?', $id_usuario);
 	
 		return $table->fetchRow($select)->toArray();
 	}
 	
 	//Verifica se um usuario ja tem um estabelecimento cadastrado
 	public function temEstabelecimento($id_usuario) {
 		$table = $this->getTable();
 		$select = $table->select()->where('id_usuario = ?', $id_usuario);
 		$rowset = $table->fetchAll($select);
 		if(count($rowset)>0) {
 			$estabelecimento = $rowset->toArray();
 			return $estabelecimento[0]['id'];
 		} else return false;
 	}
 	
 	//Verifica se um usuario ja tem um estabelecimento cadastrado com contrato
 	public function temEstabelecimentoContratado($id_usuario) {
 		$table = $this->getTable();
 		$select = $table->select()->where('id_usuario = '.$id_usuario.' and contratado = 1');
 		$rowset = $table->fetchAll($select);
 		if(count($rowset)>0) {
 			$estabelecimento = $rowset->toArray();
 			return $estabelecimento[0]['id'];
 		} else return false;
 	}
 	
 	//Retorna os resultados ativos (ativo == 1)
 	public function getAtivos() {
 		$table = $this->getTable();
 		$select = $table->select()->where('ativo = 1');
 	
 		return $table->fetchAll($select)->toArray();
 	}
 	
 	//Retorna os resultados ativos por tipo
 	public function getEstabelecimentosAtivosByTipo($tipo, $pagina = 0) {
 		$table = $this->getTable();
 		$select = $table->select()->where('ativo = 1 AND tipo = '.$tipo)->order(array('id_shopping', 'nome_fantasia'));
 		if($pagina > 0) $select = $select->limitPage($pagina, '10');
 	
 		return $table->fetchAll($select)->toArray();
 	}
 	
 	//Retorna os estabelecimentos por ordem de proximidade
 	public function getEstabelecimentosProximosByTipo($tipo, $lat, $long,$pagina = 0) {
//  		require_once APPLICATION_PATH . '/models/LogSistemas.php';
//  		$model_log = new Model_LogSistemas();
 		$table = $this->getTable();
 		$select = $table->select()->from(array('e' => 'estabelecimentos'),array('*','distancia' => '( 6371 * acos( cos( radians('.$lat.') ) * cos( radians( e.latitude ) ) * cos( radians( e.longitude ) - radians('.$long.') ) + sin( radians('.$lat.') ) * sin( radians( e.latitude ) ) ) )'))->where('ativo = 1 AND tipo = '.$tipo)->order(array('distancia','id_shopping', 'nome_fantasia'));
 		if($pagina > 0) $select = $select->limitPage($pagina, '10');
//  		$model_log->log(7, $select->__toString());
 		return $table->fetchAll($select)->toArray();
 	}
 	
 	//Retorna os shoppings ativos por cidade
 	public function getShoppingsAtivosByCidade($id_cidade, $pagina = 0) {
 		$table = $this->getTable();
 		$select = $table->select()->where('ativo = 1 AND tipo = 4 AND id_cidade = '.$id_cidade)->order(array('nome_fantasia'));
 		if($pagina > 0) $select = $select->limitPage($pagina, '10');
 	
 		return $table->fetchAll($select)->toArray();
 	}
 	
 	//Retorna as lojas ativas por cidade
 	public function getLojasAtivasByCidade($id_cidade) {
 		$table = $this->getTable();
 		$select = $table->select()->where('ativo = 1 AND tipo = 2 AND id_cidade = '.$id_cidade)->order(array('nome_fantasia'));
 	
 		return $table->fetchAll($select)->toArray();
 	}
 	
 	//Retorna estabelecimento a partir do nome da cidade
 	public function getEstabelecimentoByNomeCidade($nome_cidade) {
 		$table = $this->getTable();
 		$select = $table->select()->where('cidade = '.$nome_cidade)->order(array('nome_fantasia'));
 		
 		return $table->fetchAll($select)->toArray();
 	}
 	
 	//Retorna id_cidade(s) que contenham  shoppings ativos
 	public function getCidadesComShoppings() {
 		$table = $this->getTable();
 		$select = $table->select()->where('ativo = 1 and tipo = 4')->group(array('id_cidade'));
 			
 		return $table->fetchAll($select)->toArray();
 	}
 	
 	public function getLojistasByShopping($id_shopping, $pagina = 0) {
 		$table = $this->getTable();
 		$select = $table->select()->where('id_shopping = '.$id_shopping.' AND tipo = 2 AND ativo = 1')->order('nome_fantasia');
 		if($pagina > 0) $select = $select->limitPage($pagina, '10');
 	
 		return $table->fetchAll($select)->toArray();
 	}
 	
 	public function getQtdLojistas($id_shopping) {
 		$table = $this->getTable();
 		$select = $table->select()->where('id_shopping = '.$id_shopping.' AND tipo = 2 AND ativo = 1');
		$rowset = $table->fetchAll($select);
 		return count($rowset);
 	}
 	
 	//Seta o nome da imagem
 	public function setImagem($id, $nome) {
 		$where = 'id = '.$id;
 		$data = array('imagem' => $nome);
 	
 		$table = $this->getTable();
 		$table->update($data, $where);
 	}

 }