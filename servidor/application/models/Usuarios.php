<?php
 class Model_Usuarios {
 	//Model_Table_Guestbook
 	protected $_table;
 	public $id_facebook;
 	public $id_usuario;
 	
 	public function getTable() {
 		if(null === $this->_table) {
	 		require_once APPLICATION_PATH . '/models/DbTable/Usuarios.php';
	 		$this->_table = new Model_DbTable_Usuarios;
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
 	
 	//Busca um usuario pelo login
 	public function fetchLogin($login) {
 		$table = $this->getTable();
 		$select = $table->select()->where('login = ?', $login);
 		$rowset = $table->fetchRow($select);
 		if(count($rowset)>0) {
 			return $rowset->toArray();
 		} else return false;
 	}
 	
 	//Busca um campo especifico de uma linha especifica
 	public function getFieldById($id, $field) {
 		$entrada = $this->fetchEntry($id);
 		return $entrada[$field];
 	}
 	
 	//Configura o id_facebook a partir do usuario logado
 	public function loadUsuarioLogado() {
 		if(isset($_SESSION['usuariologinSession']['login'])) {
 			$usuario = $this->fetchLogin($_SESSION['usuariologinSession']['login']);
 			$this->id_usuario = $usuario['id'];
 		} else {
	 		if(isset($_SESSION['facebook'])) $facebook = $_SESSION['facebook'];
	 		else {
	 			$face = Zend_Registry::get('facebook');
	 			$facebook = new Facebook($face);
	 		} 
	 		
	 		$this->id_facebook = $facebook->getUser();
// 	 		if($this->id_facebook == "") $this->id_facebook = $face['appId']; // SOMENTE PARA TESTES
 		}
 		
 		return $this->getUsuario();
 	}
 	
 	//Configura o id_facebook a partir do usuario logado via token
 	public function loadUsuarioLogadoToken($sentToken) {
 		$face = Zend_Registry::get('facebook');
 		$facebook = new Facebook($face);
 		$facebook->setAccessToken($sentToken);
 		$this->id_facebook = $facebook->getUser();
//  		if($this->id_facebook == "") $this->id_facebook = $face['appId']; // SOMENTE PARA TESTES
 		$_SESSION['facebook'] = $facebook;	
 		return $this->getUsuario();
 	}
 	
 	//Retorna um usuario a partir do ID_FACEBOOK
 	public function getUsuario() {
 		$table = $this->getTable();
 		if(isset($this->id_usuario))
 			$select = $table->select()->where('id = ?', $this->id_usuario);
 		else
 			$select = $table->select()->where('id_facebook = ?', $this->id_facebook);
 		$rowset = $table->fetchRow($select);
 		if(count($rowset)>0) {
 			$entrada = $rowset->toArray();
 		} else {
 			//caso nao exista o usuario na base de dados (primeiro acesso)
 			if(isset($this->id_usuario))
 				$data = array('id' => $this->id_usuario);
 			else
 				$data = array('id_facebook' => $this->id_facebook);
 			$this->save($data);
 			$select = $table->select()->where('id_facebook = ?', $this->id_facebook);
 			$rowset = $table->fetchRow($select);
 			$entrada = $rowset->toArray();
 		}
 		
 		return $entrada;
 	}
 	
 	public function getNomeFace($id_facebook) {
 		$user = $this->getUsuarioByIDfb($id_facebook);
 		if($user['nome'])
 			return $user['nome'];
 		else {
 			$face = Zend_Registry::get('facebook');
 			$facebook = new Facebook($face);
 			
 			try {
 				$profile = $facebook->api('/'.$id_facebook,'GET');
 				
 				$where = 'id_facebook = '.$id_facebook;
 				$data = array('nome' => $profile['name']);
 				$table = $this->getTable();
 				$table->update($data, $where);
 			} catch (Exception $e) {
 				$profile['name'] = "Usuário";
 				$profile['link'] = "http://www.facebook.com";
 			}
 			return $profile['name'];
 		}
 	}
 	
 	public function setNome($id_usuario, $nome) {
 		try {
 			$where = 'id = '.$id_usuario;
 			$data = array('nome' => $nome);
 			$table = $this->getTable();
 			$table->update($data, $where);
 			
 			return true;
 		} catch (Exception $e) {
 			return false;
 		}
 	}
 	
 	public function getNome($id_usuario) {
 		$usuario = $this->fetchEntry($id_usuario);
 		
 		return $usuario['nome'];
 	}
 	
 	public function getUserProfile() {
 		if(isset($_SESSION['facebook'])) $facebook = $_SESSION['facebook'];
 		else {
 			$face = Zend_Registry::get('facebook');
 			$facebook = new Facebook($face);
 		} 
 		
 		try {
 			$params = array('req_perms'=>'publish_actions,user_birthday');
 			$profile = $facebook->api('/me','GET');
 			$profile['idade'] = $this->calcularIdade($profile['birthday']);
 		} catch (Exception $e) {
 			$profile['name'] = "Usuário";
 			$profile['gender'] = "male";
 			$profile['idade'] = 0;
 		}
 		
 		return $profile;
 	}
 	
	function calcularIdade($birthday) {
		list($month,$day,$year) = explode("/",$birthday);
		$year_diff  = date("Y") - $year;
		$month_diff = date("m") - $month;
		$day_diff   = date("d") - $day;
		if ($month_diff < 0) $year_diff--;
		elseif (($month_diff==0) && ($day_diff < 0)) $year_diff--;
		return $year_diff;
	}
 	
 	public function getLojistasByCEP($cep) {
 		$table = $this->getTable();
 		$select = $table->select()->where('cep = '.$cep.' AND tipo = 2 AND ativo = 1');
 		
 		return $table->fetchAll($select)->toArray();
 	}
 	
 	public function getShoppingsByCEP($cep) {
 		$table = $this->getTable();
 		$select = $table->select()->where('cep = '.$cep.' AND tipo = 4 AND ativo = 1');
 			
 		return $table->fetchAll($select)->toArray();
 	}
 	
 	//Nao esta 100%
 	public function getShoppingsByGeolocation($userLat, $userLong) {
 		$table = $this->getTable();
 		$db = $table->getAdapter();
 		
 		$sql = 'SELECT (((ACOS(SIN('.$userLat.' * PI() / 180) * SIN(`latitude` * PI() / 180) + COS('.$userLat.' * PI() / 180) * COS(`latitude` * PI() / 180) * COS(('.$userLong.' - `longitude`) * PI() / 180)) * 180 / PI()) * 60 * 1.1515))*1.609344 AS distance FROM `usuarios` HAVING distance<=0.5 ORDER BY distance ASC';
 		$stmt = new Zend_Db_Statement_Mysqli($db, $sql);
 		$stmt->execute();
 		
 		return $stmt->fetchAll($select)->toArray();
 	}
 	
 	public function getLojistasByShopping($id_shopping) {
 		$table = $this->getTable();
 		$select = $table->select()->where('id_shopping = '.$id_shopping.' AND tipo = 2 AND ativo = 1');
 			
 		return $table->fetchAll($select)->toArray();
 	}
 	
 	public function setLocalidade($latitude, $longitude) {
 		$where = 'id_facebook = '.$this->id_facebook;
 		$data = array('latitude' => $latitude, 'longitude' => $longitude);
 		
 		$table = $this->getTable();
 		$table->update($data, $where);
 	}
 	
 	public function setUsuarioTipo($id, $tipo) {
 		$where = 'id = '.$id;
 		$data = array('tipo' => $tipo);
 	
 		$table = $this->getTable();
 		$table->update($data, $where);
 	}
 	
 	public function setUsuarioAtivo($id, $ativo) {
 		$where = 'id = '.$id;
 		$data = array('ativo' => $ativo);
 			
 		$table = $this->getTable();
 		$table->update($data, $where);
 	}
 	
 	public function getUsuarioByIDfb($id_facebook) {
 		$table = $this->getTable();
 		$select = $table->select()->where('id_facebook = ?', $id_facebook);
 			
 		return $table->fetchRow($select)->toArray();
 	}
 	
 	public function getUsuariosByAtivo($ativo) {
 		$table = $this->getTable();
 		$select = $table->select()->where('ativo = '.$ativo);
 			
 		return $table->fetchAll($select)->toArray();
 	}
 	
 	public function getUsuariosAtivosByTipo($tipo) {
 		$table = $this->getTable();
 		$select = $table->select()->where('ativo = 1 AND tipo = '.$tipo);
 	
 		return $table->fetchAll($select)->toArray();
 	}
 	
 	public function incCreditos($id_usuario, $creditos) {
 		$where = 'id = '.$id_usuario;
 		$data = array('creditos' => new Zend_Db_Expr('creditos + '.$creditos));
 		$table = $this->getTable();
 		$table->update($data, $where);
 		
 		return true;
 	}
 	
 	public function decCreditos($id_usuario, $creditos) {
 		$creditos_atuais = $this->getFieldById($id_usuario, 'creditos');
 		
 		if($creditos_atuais >= $creditos) {
	 		$where = 'id = '.$id_usuario;
	 		$data = array('creditos' => new Zend_Db_Expr('creditos - '.$creditos));
	 		$table = $this->getTable();
	 		$table->update($data, $where);
	 		
	 		return true;
 		} else {
 			return false;
 		}
 	}
 	
 	public function pertenceAoShopping($id_lojista, $id_shopping) {
 		$table = $this->getTable();
 		$select = $table->select()->where('id = '.$id_lojista.' AND id_shopping = '.$id_shopping);
 		$linha = $table->fetchAll($select)->toArray();
 		if(isset($linha[0])) {
 			return TRUE;
 		} else {
 			return FALSE;
 		}
 	}
 	
 	public function entrarNoShopping($id_lojista, $id_shopping) {
 		$where = 'id = '.$id_lojista;
 		$data = array('id_shopping' => $id_shopping);
 			
 		$table = $this->getTable();
 		$table->update($data, $where);
 	}
 	
 	public function zerarShopping($id_lojista) {
 		$where = 'id = '.$id_lojista;
 		$data = array('id_shopping' => new Zend_Db_Expr('NULL'));
 	
 		$table = $this->getTable();
 		$table->update($data, $where);
 	}
 	
 	public function criarLoginSenha($id_usuario, $login, $senha) {
 		$hash = $this->codificarSenha($login, $senha);
 		
 		try {
 			$where = 'id = '.$id_usuario;
 			$data = array('login' => $login, 'senha' => $hash);
 				
 			$table = $this->getTable();
 			$table->update($data, $where);
 			
 			return true;
 		} catch (Exception $e) {
 			return false;
 		}
 	}
 	
 	public function cadastrar($login, $senha, $data) {
 		if(!$this->fetchLogin($login)) {
	 		$hash = $this->codificarSenha($login, $senha);
	 		
	 		$data['login'] = $login;
	 		$data['senha'] = $hash;
	 		
	 		return $this->save($data);
 		} else return false;
 	}
 	
 	public function checkLogin($login, $senha) {
 		$usuario = $this->fetchLogin($login);
 		
 		$salt = substr($usuario['senha'], 0, 64);
 		$hash = $salt . $senha;
 		for ( $i = 0; $i < 100000; $i ++ ) {
 			$hash = hash('sha256', $hash);
 		}
 		$hash = $salt . $hash;
 		
 		if ( $hash == $usuario['senha'] ) return true;
 		else return false;
 	}
 	
 	public function temLoginSenha($id_usuario) {
 		$usuario = $this->fetchEntry($id_usuario);
 		if(($usuario['login'] != "") and (($usuario['senha'] != "")))
 			return true;
 		else
 			return false;
 	}
 	
 	public function mudarSenha($login, $senhaAntiga, $senhaNova) {
 		if(($this->checkLogin($login, $senhaAntiga)) and ($senhaNova != "")) {
 			try {
 				$hash = $this->codificarSenha($login, $senhaNova);
 				
 				$where = 'login = \''.$login.'\'';
 				$data = array('senha' => $hash);
 					
 				$table = $this->getTable();
 				$table->update($data, $where);
 			} catch (Exception $e) {
 				return "Erro ao alterar senha";
 			}
 			return "Senha alterada com sucesso";
 		} else return "Senha antiga inválida";
 	}
 	
 	public function codificarSenha($login, $senha) {
 		$salt = hash('sha256', uniqid(mt_rand(), true) . 'vicenteehdemais' . strtolower($login));
 		$hash = $salt . $senha;
 		for ( $i = 0; $i < 100000; $i ++ ) {
 			$hash = hash('sha256', $hash);
 		}
 		$hash = $salt . $hash;
 		
 		return $hash;
 	}
 	
 	function resetarSenha($login) {
 		$senhaNova = $this->randomPassword();
 		
 		try {
 			$hash = $this->codificarSenha($login, $senhaNova);
 				
 			$where = 'login = \''.$login.'\'';
 			$data = array('senha' => $hash);
 		
 			$table = $this->getTable();
 			$table->update($data, $where);
 		} catch (Exception $e) {
 			return false;
 		}
 		return $senhaNova;
 	}
 	
 	function randomPassword() {
 		$alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
 		$pass = array(); //remember to declare $pass as an array
 		$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
 		for ($i = 0; $i < 8; $i++) {
 			$n = rand(0, $alphaLength);
 			$pass[] = $alphabet[$n];
 		}
 		return implode($pass); //turn the array into a string
 	}

 }