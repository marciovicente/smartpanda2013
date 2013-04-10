<?php
class SistemaController extends Zend_Controller_Action
{
	protected $_model;
	
	public function  indexAction()
	{	
		
	}
	
	public function preDispatch() {
		
	
	}
	
	protected function _getModelUsuarios() {
		require_once APPLICATION_PATH . '/models/Usuarios.php';
		$this->_model = new Model_Usuarios();
	
		return $this->_model;
	}
	
	protected function _getModelOfertas() {
		require_once APPLICATION_PATH . '/models/Ofertas.php';
		$this->_model = new Model_Ofertas();
	
		return $this->_model;
	}
	
	protected function _getModelCampanhas() {
		require_once APPLICATION_PATH . '/models/Campanhas.php';
		$this->_model = new Model_Campanhas();
	
		return $this->_model;
	}
	
	protected function _getModelCampanhasVotos() {
		require_once APPLICATION_PATH . '/models/CampanhasVotos.php';
		$this->_model = new Model_CampanhasVotos();
	
		return $this->_model;
	}
	
	protected function _getModelCampanhasConfigs() {
		require_once APPLICATION_PATH . '/models/CampanhasConfigs.php';
		$this->_model = new Model_CampanhasConfigs();
	
		return $this->_model;
	}
	
	protected function _getModelCategorias() {
		require_once APPLICATION_PATH . '/models/Categorias.php';
		$this->_model = new Model_Categorias();
	
		return $this->_model;
	}
	
	protected function _getModelEstabelecimentos() {
		require_once APPLICATION_PATH . '/models/Estabelecimentos.php';
		$this->_model = new Model_Estabelecimentos();
	
		return $this->_model;
	}
	
	protected function _getModelEstabelecimentos_Categorias() {
		require_once APPLICATION_PATH . '/models/Estabelecimentos_Categorias.php';
		$this->_model = new Model_Estabelecimentos_Categorias();
	
		return $this->_model;
	}
	
	protected function _getModelCidades() {
		require_once APPLICATION_PATH . '/models/Cidades.php';
		$this->_model = new Model_Cidades();
	
		return $this->_model;
	}
	
	protected function _getModelEstados() {
		require_once APPLICATION_PATH . '/models/Estados.php';
		$this->_model = new Model_Estados();
	
		return $this->_model;
	}
	
	protected function _getModelLogAcessos() {
		require_once APPLICATION_PATH . '/models/LogAcessos.php';
		$this->_model = new Model_LogAcessos();
	
		return $this->_model;
	}
	
	protected function _getModelLogCampanhasUsuarios() {
		require_once APPLICATION_PATH . '/models/LogCampanhasUsuarios.php';
		$this->_model = new Model_LogCampanhasUsuarios();
	
		return $this->_model;
	}
	
	protected function _getModelTelefones() {
		require_once APPLICATION_PATH . '/models/Telefones.php';
		$this->_model = new Model_Telefones();
	
		return $this->_model;
	}
	
	protected function getusuariologadoAction() {
		$model_usuario = $this->_getModelUsuarios();
		$usuario = $model_usuario->loadUsuarioLogado();
		$user = $usuario['id_facebook'];
		$profile = $model_usuario->getUserProfile();

		
		$request = $this->getRequest();
		//Verifica se foi enviado via GET
		if($this->getRequest()->isGet()) {
			$dados = array();
			$dados[] = $profile;
			
			$this->_helper->json($dados);
		}
	}
	
	protected function loginAction() {
// 		$this->_helper->layout->disableLayout();
// 		$this->_helper->viewRenderer->setNoRender(true);
		$model_logacesso = $this->_getModelLogAcessos();
		$face = Zend_Registry::get('facebook');
		$facebook = new Facebook($face);
		$request = $this->getRequest();
		//Verifica se foi enviado via GET
		if($this->getRequest()->isGet()) {
			$data = $request->getQuery();
			$access_token = $data['t'];
			$_SESSION['access_token'] = $access_token;
			$facebook->destroySession();
// 			$facebook->setAccessToken($access_token);
			$model_usuario = $this->_getModelUsuarios();
			$usuario = $model_usuario->loadUsuarioLogadoToken($access_token);
			
			$token = $facebook->getAccessToken();
			$dados['token'] = $token;
			$dados['usuario_logado'] = $usuario['id_facebook'];
			$model_logacesso->log($usuario['id'],'app');
			$this->_helper->json($dados);
		}
	}
	
	protected function logoutAction() {
		$face = Zend_Registry::get('facebook');
		$facebook = new Facebook($face);
		$request = $this->getRequest();
		//Verifica se foi enviado via GET
		if($this->getRequest()->isGet()) {
			$data = $request->getQuery();
			$facebook->destroySession();
			$facebook->setAccessToken('0');

			$token = $facebook->getAccessToken();
			$dados['token'] = $token;
			$dados['msg'] = "Sessao destruida";
			$this->_helper->json($dados);
		}
	}
	
	protected function getshoppingsAction() {
		$model_usuario = $this->_getModelUsuarios();
		$usuario = $model_usuario->loadUsuarioLogado();
		$user = $usuario['id_facebook'];
		$profile = $model_usuario->getUserProfile();
		
		$request = $this->getRequest();
		//Verifica se foi enviado via GET
		if($this->getRequest()->isGet()) {
			$data = $request->getQuery();
			$id_cidade = null;
			if(isset($data['id_cidade'])) $id_cidade = $data['id_cidade'];
			if(isset($data['p'])) $pagina = $data['p']; else $pagina = 0;;
			if(isset($data['latitude'])) $latitude = $data['latitude']; else $latitude = 0;
			if(isset($data['longitude'])) $longitude = $data['longitude']; else $longitude = 0;
			
			if(($latitude != 0) and ($longitude != 0)) {
				if(!((($usuario['tipo'] == 2) or ($usuario['tipo'] == 4)) and (($usuario['latitude']) or ($usuario['longitude']))))
					$model_usuario->setLocalidade($latitude, $longitude);
			}
			
			if(($id_cidade) or (($latitude !=0) and ($longitude != 0)))
				$dados = $this->getshoppings($id_cidade, $latitude, $longitude, $pagina, $profile);
			else {
				$msg['mensagem'] = "Deve informar id_cidade ou (latidude e longitude).";
				$dados[] = $msg;
			}
			
			$this->_helper->json($dados);
		}
	}
	
	protected function paginador($array, $pagina, $limitePorPagina) {
		if($pagina > 0) {
			$itemInicial = ($pagina-1)*$limitePorPagina;
			if(count($array) <= $itemInicial) {
				$array = array();
				return $array;
			}
			//$itemFinal = ($itemInicial + $limitePorPagina)-1;
			$array = array_slice($array,$itemInicial,$limitePorPagina);
		}
		return $array;
	}
	
	protected function getshoppingscomofertasAction() {
		$model_usuario = $this->_getModelUsuarios();
		$usuario = $model_usuario->loadUsuarioLogado();
		$user = $usuario['id_facebook'];
		$profile = $model_usuario->getUserProfile();
	
		$request = $this->getRequest();
		//Verifica se foi enviado via GET
		if($this->getRequest()->isGet()) {
			$data = $request->getQuery();
			$id_cidade = null;
			if(isset($data['id_cidade'])) $id_cidade = $data['id_cidade'];
			if(isset($data['p'])) $pagina = $data['p']; else $pagina = 0;
			if(isset($data['latitude'])) $latitude = $data['latitude']; else $latitude = 0;
			if(isset($data['longitude'])) $longitude = $data['longitude']; else $longitude = 0;
			
			if(($latitude != 0) and ($longitude != 0)) {
				if(!((($usuario['tipo'] == 2) or ($usuario['tipo'] == 4)) and (($usuario['latitude']) or ($usuario['longitude']))))
					$model_usuario->setLocalidade($latitude, $longitude);
			}
				
			if(($id_cidade) or (($latitude !=0) and ($longitude != 0))) {
				$shoppings = $this->getshoppings($id_cidade, $latitude, $longitude, 0, $profile);
				$dados = array();
				
				
				foreach ($shoppings as $value) {
					if($value->nr_ofertas > 0)
						$dados[] = $value;
				}
				
				$dados = $this->paginador($dados, $pagina, 5);
			} else {
				$msg['mensagem'] = "Deve informar id_cidade ou (latidude e longitude).";
				$dados[] = $msg;
			}
			
			$this->_helper->json($dados);
		}
	}
	
	protected function getshoppingssemofertasAction() {
		$model_usuario = $this->_getModelUsuarios();
		$usuario = $model_usuario->loadUsuarioLogado();
		$user = $usuario['id_facebook'];
	
		$request = $this->getRequest();
		//Verifica se foi enviado via GET
		if($this->getRequest()->isGet()) {
			$data = $request->getQuery();
			$id_cidade = null;
			if(isset($data['id_cidade'])) $id_cidade = $data['id_cidade'];
			if(isset($data['p'])) $pagina = $data['p']; else $pagina = 0;
			if(isset($data['latitude'])) $latitude = $data['latitude']; else $latitude = 0;
			if(isset($data['longitude'])) $longitude = $data['longitude']; else $longitude = 0;
			
			if(($latitude != 0) and ($longitude != 0)) {
				if(!((($usuario['tipo'] == 2) or ($usuario['tipo'] == 4)) and (($usuario['latitude']) or ($usuario['longitude']))))
					$model_usuario->setLocalidade($latitude, $longitude);
			}
	
			if(($id_cidade) or (($latitude !=0) and ($longitude != 0))) {
				$shoppings = $this->getshoppings($id_cidade, $latitude, $longitude, $pagina);
				$dados = array();
				foreach ($shoppings as $value) {
					if($value->nr_ofertas == 0)
					$dados[] = $value;
				}
					
				$dados = $this->paginador($dados, $pagina, 5);
			} else {
				$msg['mensagem'] = "Deve informar id_cidade ou (latidude e longitude).";
				$dados[] = $msg;
			}
			
			$this->_helper->json($dados);
		}
	}
	
	protected function getlojasAction() {
		$request = $this->getRequest();
		//Verifica se foi enviado via GET
		if($this->getRequest()->isGet()) {
			$data = $request->getQuery();
			$id_cidade = null;
			$id_shopping = $data['id_shopping'];
				
			$dados = $this->getlojistas($id_shopping);
	
			$this->_helper->json($dados);
		}
	}
	
	protected function getlojascomofertasAction() {
		$request = $this->getRequest();
		//Verifica se foi enviado via GET
		if($this->getRequest()->isGet()) {
			$data = $request->getQuery();
			$id_shopping = $data['id_shopping'];
			if(isset($data['p'])) $pagina = $data['p']; else $pagina = 0;
	
			$lojas = $this->getlojistas($id_shopping, $pagina);
			$dados = array();
			foreach ($lojas as $value) {
				if($value->nr_ofertas > 0)
				$dados[] = $value;
			}
	
			$this->_helper->json($dados);
		}
	}
	
	protected function getlojassemofertasAction() {
		$request = $this->getRequest();
		//Verifica se foi enviado via GET
		if($this->getRequest()->isGet()) {
			$data = $request->getQuery();
			$id_shopping = $data['id_shopping'];
			if(isset($data['p'])) $pagina = $data['p']; else $pagina = 0;
	
			$lojas = $this->getlojistas($id_shopping, $pagina);
			$dados = array();
			foreach ($lojas as $value) {
				if($value->nr_ofertas == 0)
				$dados[] = $value;
			}
	
			$this->_helper->json($dados);
		}
	}
	
	//Retorna todas as ofertas ativas cadastradas por um usuario. Se esse for shopping, retorna dos seus lojistas tambem
	protected function getofertasbyidAction() {
		$model_usuario = $this->_getModelUsuarios();
		$model_estabelecimento = $this->_getModelEstabelecimentos();
		$usuario = $model_usuario->loadUsuarioLogado();
		$user = $usuario['id_facebook'];
		$profile = $model_usuario->getUserProfile();
		$request = $this->getRequest();
		//Verifica se foi enviado via GET
		if($this->getRequest()->isGet()) {
			$data = $request->getQuery();
			$id_shopping = $data['id'];
				
			$model_ofertas = $this->_getModelOfertas();
			$model_campanhasconfigs = $this->_getModelCampanhasConfigs();
			
			$dados = array();
			//Pega as ofertas criadas pelo proprio shopping
// 			$shopping = $model_estabelecimento->fetchEntry($id_shopping);
			$ofertasShopping = $model_ofertas->getOfertasByEstabelecimento($id_shopping);
			
			$dados = array();
			
			foreach($ofertasShopping as $value) {
				$campanha_e_oferta = $this->loadCampanhaEoferta($value);
				$campanha = $campanha_e_oferta['campanha'];
				$configs = $model_campanhasconfigs->fetchEntry($campanha->id_config);
				if($model_campanhasconfigs->checkConfig($campanha->id_config, $profile)) {
					$campanha_e_oferta['oferta']['texto'] = "";
					$campanha_e_oferta['oferta']['lojista'] = $model_estabelecimento->getNome($campanha_e_oferta['oferta']['id_estabelecimento']);
					
					$imagem = $model_estabelecimento->getFieldById($campanha_e_oferta['oferta']['id_estabelecimento'], 'imagem');
					if(($imagem) and ($imagem != "")) {
						$campanha_e_oferta['oferta']['lojista_imagem'] = 'images/estabelecimentos/'.$imagem;
						$campanha_e_oferta['oferta']['lojista_thumb'] = 'images/estabelecimentos/thumbs/'.$imagem;
						$campanha_e_oferta['oferta']['lojista_banner'] = 'images/estabelecimentos/banners/'.$imagem;
					}
					
					$campanha_e_oferta['shopping'] = $model_estabelecimento->getNome($id_shopping);
					$campanha_e_oferta['categoria'] = $configs['categoria'];
					if($campanha->ativo == 1) {
						$this->logCampanhaAcao($campanha->id, $usuario['id'], 'entregue');
						$dados[] = $campanha_e_oferta;
					}
				}
			}
			
			
			//Pega as ofertas dos lojistas do shopping	
			$lojistas = $model_estabelecimento->getLojistasByShopping($id_shopping);		
			
			foreach ($lojistas as $lojista) {
				$ofertas = $model_ofertas->getOfertasByEstabelecimento($lojista['id']);
				foreach($ofertas as $value) {
					$campanha_e_oferta = $this->loadCampanhaEoferta($value);
					$campanha = $campanha_e_oferta['campanha'];
					$configs = $model_campanhasconfigs->fetchEntry($campanha->id_config);
					if($model_campanhasconfigs->checkConfig($campanha->id_config, $profile)) {
						$campanha_e_oferta['oferta']['texto'] = "";
						$campanha_e_oferta['oferta']['lojista'] = $model_estabelecimento->getNome($campanha_e_oferta['oferta']['id_estabelecimento']);
						
						$imagem = $model_estabelecimento->getFieldById($campanha_e_oferta['oferta']['id_estabelecimento'], 'imagem');
						if(($imagem) and ($imagem != "")) {
							$campanha_e_oferta['oferta']['lojista_imagem'] = 'images/estabelecimentos/'.$imagem;
							$campanha_e_oferta['oferta']['lojista_thumb'] = 'images/estabelecimentos/thumbs/'.$imagem;
							$campanha_e_oferta['oferta']['lojista_banner'] = 'images/estabelecimentos/banners/'.$imagem;
						}
						
						$campanha_e_oferta['shopping'] = $model_estabelecimento->getNome($id_shopping);
						$campanha_e_oferta['categoria'] = $configs['categoria'];
						if($campanha->ativo == 1) {
							$this->logCampanhaAcao($campanha->id, $usuario['id'], 'entregue');
							$dados[] = $campanha_e_oferta;
						}
					}
				}
			}
				
			$this->_helper->json($dados);
		}
	}
	
	//Conta quantas ofertas tem um estabelecimento (incluindo as dos lojistas se for um shopping)
	protected function getQtdOfertas($estabelecimento, $profile = false) {
		$model_estabelecimento = $this->_getModelEstabelecimentos();
		$model_ofertas = $this->_getModelOfertas();
		
		$nr_ofertas = $model_ofertas->getQtdOfertas($estabelecimento['id'], $profile);
		
		if($estabelecimento['tipo'] == 4) { //Se for Shopping
			$lojistas = $model_estabelecimento->getLojistasByShopping($estabelecimento['id']);
			foreach ($lojistas as $lojista) {
				$nr_ofertas = $nr_ofertas + $model_ofertas->getQtdOfertas($lojista['id'], $profile);
			}
		}
		
		return $nr_ofertas;
	}
	
	//Retornar informacoes de um lojista/shopping
	protected function getlojistaAction() {
		$model_estabelecimento = $this->_getModelEstabelecimentos();
		$request = $this->getRequest();
		//Verifica se foi enviado via GET
		if($this->getRequest()->isGet()) {
			$data = $request->getQuery();
			$id_lojista = $data['id'];
			
			$lojista_user = $model_estabelecimento->fetchEntry($id_lojista);
			require_once APPLICATION_PATH . '/models/Estabelecimento.php';
			$dados = array();

			$lojista = new Estabelecimento();
		
			$lojista->ativo = $lojista_user['ativo'];
			$lojista->id = $lojista_user['id'];
			$lojista->id_facebook = $lojista_user['id_facebook'];
			$lojista->nome_fantasia = $lojista_user['nome_fantasia'];
			$lojista->latitude = $lojista_user['latitude'];
			$lojista->longitude = $lojista_user['longitude'];
			$lojista->tipo = $lojista_user['tipo'];
		
			$dados[] = $lojista;
			
			$this->_helper->json($dados);
			
		}
	}
	
	//Retornar informacoes de um estabelecimento
	protected function getestabelecimentoAction() {
		$model_estabelecimento = $this->_getModelEstabelecimentos();
		$model_telefone = $this->_getModelTelefones();
		$model_cidade = $this->_getModelCidades();
		$model_estado = $this->_getModelEstados();
		$model_usuario = $this->_getModelUsuarios();
		
		$usuario = $model_usuario->loadUsuarioLogado();
		$profile = $model_usuario->getUserProfile();
		
		$request = $this->getRequest();
		//Verifica se foi enviado via GET
		if($this->getRequest()->isGet()) {
			$data = $request->getQuery();
			$id_estabelecimento = $data['id'];
				
			require_once APPLICATION_PATH . '/models/Estabelecimento.php';
			$estabelecimento_user = $model_estabelecimento->fetchEntry($id_estabelecimento);
			$dados = array();
	
			$estabelecimento = new Estabelecimento();
	
			$estabelecimento->ativo = $estabelecimento_user['ativo'];
			$estabelecimento->id = $estabelecimento_user['id'];
			$estabelecimento->id_facebook = $estabelecimento_user['id_facebook'];
			$estabelecimento->id_shopping = $estabelecimento_user['id_shopping'];
			$estabelecimento->nome_fantasia = $estabelecimento_user['nome_fantasia'];
			$estabelecimento->latitude = $estabelecimento_user['latitude'];
			$estabelecimento->longitude = $estabelecimento_user['longitude'];
			$estabelecimento->tipo = $estabelecimento_user['tipo'];
			$estabelecimento->endereco = $estabelecimento_user['endereco'];
			$estabelecimento->nr = $estabelecimento_user['nr'];
			$estabelecimento->complemento = $estabelecimento_user['complemento'];
			$estabelecimento->id_cidade = $estabelecimento_user['id_cidade'];
			$estabelecimento->nr_ofertas = $this->getQtdOfertas($estabelecimento_user, $profile);
			
			$cidade = $model_cidade->fetchEntry($estabelecimento_user['id_cidade']);
			$estabelecimento->cidade = $cidade['nome'];
			$estado = $model_estado->fetchEntry($cidade['id_estado']);
			$estabelecimento->estado = $estado['sigla'];
			
			$imagem = $estabelecimento_user['imagem'];
			if(($imagem) and ($imagem != "")) {
				$estabelecimento->imagem = 'images/estabelecimentos/'.$imagem;
				$estabelecimento->thumb = 'images/estabelecimentos/thumbs/'.$imagem;
				$estabelecimento->banner = 'images/estabelecimentos/banners/'.$imagem;
			}
			
			$estabelecimento->telefone = '';
			$telefones = $model_telefone->getTelefonesByEstabelecimento($estabelecimento->id);
			foreach ($telefones as $telefone) {
				$estabelecimento->telefone .= $telefone['numero'].' ';
			}
	
			$dados[] = $estabelecimento;
				
			$this->_helper->json($dados);
				
		}
	}
	
	//Retorna estabelecimentos (shoppings) por cidade
	protected function getshoppingsativosAction() {
		$model_estabelecimento = $this->_getModelEstabelecimentos();
		$request = $this->getRequest();
		//Verifica se foi enviado via GET
		if($this->getRequest()->isGet()) {
			$data = $request->getQuery();
			$dados = $this->getshoppings($data['id_cidade']);
	
			$this->_helper->json($dados);
	
		}
	}
	
	protected function getshoppings($id_cidade, $lat = 0, $long = 0, $pagina = 0, $profile = false) {
		$model_estabelecimento = $this->_getModelEstabelecimentos();
		$model_cidade = $this->_getModelCidades();
		$model_estado = $this->_getModelEstados();
		
		if((isset($id_cidade)) and ($id_cidade != ""))  {
			$shoppings = $model_estabelecimento->getShoppingsAtivosByCidade($id_cidade,$pagina);
		} else {
			$shoppings = $model_estabelecimento->getEstabelecimentosProximosByTipo(4,$lat,$long,$pagina);
		}
		
		require_once APPLICATION_PATH . '/models/Estabelecimento.php';
		$dados = array();
		
		foreach($shoppings as $value) {
			$cidade = $model_cidade->fetchEntry($value['id_cidade']);
			$estado = $model_estado->fetchEntry($cidade['id_estado']);
			
			$shopping = new Estabelecimento();
		
			$shopping->ativo = $value['ativo'];
			$shopping->id = $value['id'];
			$shopping->nome_fantasia = $value['nome_fantasia'];
			$shopping->latitude = $value['latitude'];
			$shopping->longitude = $value['longitude'];
			$shopping->id_cidade = $value['id_cidade'];
			$shopping->nr_ofertas = $this->getQtdOfertas($value, $profile);
			if(isset($value['distancia'])) $shopping->distancia = $value['distancia'];
			$shopping->cidade = $cidade['nome'];
			$shopping->estado = $estado['sigla'];
			
			$imagem = $value['imagem'];
			if(($imagem) and ($imagem != "")) {
				$shopping->imagem = 'images/estabelecimentos/'.$imagem;
				$shopping->thumb = 'images/estabelecimentos/thumbs/'.$imagem;
				$shopping->banner = 'images/estabelecimentos/banners/'.$imagem;
			}
		
			$dados[] = $shopping;
		}
		return $dados;
	}
	
	protected function getlojistas($id_shopping, $pagina = 0) {
		$model_estabelecimento = $this->_getModelEstabelecimentos();
		$lojistas = $model_estabelecimento->getLojistasByShopping($id_shopping, $pagina);	
	
		require_once APPLICATION_PATH . '/models/Estabelecimento.php';
		$dados = array();
	
		foreach($lojistas as $value) {
			$lojista = new Estabelecimento();
	
			$lojista->ativo = $value['ativo'];
			$lojista->id = $value['id'];
			$lojista->nome_fantasia = $value['nome_fantasia'];
			$lojista->latitude = $value['latitude'];
			$lojista->longitude = $value['longitude'];
			$lojista->id_cidade = $value['id_cidade'];
			$lojista->nr_ofertas = $this->getQtdOfertas($value);
	
			$dados[] = $lojista;
		}
		return $dados;
	}
	
	//Retorna estabelecimentos (lojas) por cidade
	protected function getlojasativasAction() {
		$model_estabelecimento = $this->_getModelEstabelecimentos();
		$request = $this->getRequest();
		//Verifica se foi enviado via GET
		if($this->getRequest()->isGet()) {
			$data = $request->getQuery();
			if(isset($data['id_cidade']))  {
				$id_cidade = $data['id_cidade'];
				$lojas = $model_estabelecimento->getLojasAtivasByCidade($id_cidade);
			} else {
				$lojas = $model_estabelecimento->getEstabelecimentosAtivosByTipo(2);
			}
	
			require_once APPLICATION_PATH . '/models/Estabelecimento.php';
			$dados = array();
	
			foreach($lojas as $value) {
				$loja = new Estabelecimento();
	
				$loja->ativo = $value['ativo'];
				$loja->id = $value['id'];
				$loja->id_shopping = $value['id_shopping'];
				$loja->nome_fantasia = $value['nome_fantasia'];
				$loja->latitude = $value['latitude'];
				$loja->longitude = $value['longitude'];
				$loja->id_cidade = $value['id_cidade'];
	
				if(!$value['contratado'])
					$dados[] = $loja;
			}
	
			$this->_helper->json($dados);
	
		}
	}
	
	//Retorna estabelecimentos (lojas) por shopping
	protected function getlojasprecadastradasAction() {
		$model_estabelecimento = $this->_getModelEstabelecimentos();
		$request = $this->getRequest();
		//Verifica se foi enviado via GET
		if($this->getRequest()->isGet()) {
			$data = $request->getQuery();
			$id_shopping = $data['id_shopping'];
			$lojas = $model_estabelecimento->getLojistasByShopping($id_shopping);
	
			require_once APPLICATION_PATH . '/models/Estabelecimento.php';
			$dados = array();
	
			foreach($lojas as $value) {
				$loja = new Estabelecimento();
	
				$loja->ativo = $value['ativo'];
				$loja->id = $value['id'];
				$loja->id_shopping = $value['id_shopping'];
				$loja->nome_fantasia = $value['nome_fantasia'];
				$loja->latitude = $value['latitude'];
				$loja->longitude = $value['longitude'];
				$loja->id_cidade = $value['id_cidade'];
	
				if(!$value['contratado'])
				$dados[] = $loja;
			}
	
			$this->_helper->json($dados);
	
		}
	}
	
	//Retorna cidades que tenham shoppings cadastrados
	protected function getcidadescomshoppingsAction() {
		$model_estabelecimento = $this->_getModelEstabelecimentos();
		$model_cidades = $this->_getModelCidades();
		$model_estados = $this->_getModelEstados();
		$request = $this->getRequest();
		//Verifica se foi enviado via GET
		if($this->getRequest()->isGet()) {
			$cidades_com_shoppings = $model_estabelecimento->getCidadesComShoppings();
			$dados = array();
			foreach ($cidades_com_shoppings as $value) {
				$cidade_shopping = $model_cidades->fetchEntry($value['id_cidade']);
				$cidade['id'] = $cidade_shopping['id'];
				$cidade['nome'] = $cidade_shopping['nome'];
				$cidade['id_estado'] = $cidade_shopping['id_estado'];
				$cidade['estado'] = $model_estados->getFieldById($cidade['id_estado'], 'sigla');
				 
				$dados[] = $cidade;
			}
			
			$this->_helper->json($dados);
		}
	}
	
	//Retorna cidades cadastradas
	protected function getcidadescadastradasAction() {
		$model_estabelecimento = $this->_getModelEstabelecimentos();
		$model_cidades = $this->_getModelCidades();
		$model_estados = $this->_getModelEstados();
		$request = $this->getRequest();
		//Verifica se foi enviado via GET
		if($this->getRequest()->isGet()) {
			$cidades = $model_cidades->getCidades();
			$dados = array();
			foreach ($cidades as $value) {
				$cidade_shopping = $value;
				$cidade['id'] = $cidade_shopping['id'];
				$cidade['nome'] = $cidade_shopping['nome'];
				$cidade['id_estado'] = $cidade_shopping['id_estado'];
				$cidade['estado'] = $model_estados->getFieldById($cidade['id_estado'], 'sigla');
					
				$dados[] = $cidade;
			}
				
			$this->_helper->json($dados);
		}
	}
	
	//Retorna estados que tenham shoppings cadastrados
	protected function getestadoscomshoppingsAction() {
		$model_estabelecimento = $this->_getModelEstabelecimentos();
		$model_cidades = $this->_getModelCidades();
		$model_estados = $this->_getModelEstados();
		$request = $this->getRequest();
		//Verifica se foi enviado via GET
		if($this->getRequest()->isGet()) {
			$cidades_com_shoppings = $model_estabelecimento->getCidadesComShoppings();
			$dados = array();
			$estados_nomes = array();
			foreach ($cidades_com_shoppings as $value) {
				$cidade_shopping = $model_cidades->fetchEntry($value['id_cidade']);
				$estado = $model_estados->fetchEntry($cidade_shopping['id_estado']);

				if(!in_array($estado['nome'], $estados_nomes))
					$dados[] = $estado;
				
				$estados_nomes[] = $estado['nome'];
			}
				
			$this->_helper->json($dados);
		}
	}
	
	//Retorna estados com cidades cadastradas
	protected function getestadoscomcidadeAction() {
		$model_estabelecimento = $this->_getModelEstabelecimentos();
		$model_cidades = $this->_getModelCidades();
		$model_estados = $this->_getModelEstados();
		$request = $this->getRequest();
		//Verifica se foi enviado via GET
		if($this->getRequest()->isGet()) {
			$cidades = $model_cidades->getCidades();
			$dados = array();
			$estados_nomes = array();
			foreach ($cidades as $value) {
				$estado = $model_estados->fetchEntry($value['id_estado']);
	
				if(!in_array($estado['nome'], $estados_nomes))
				$dados[] = $estado;
	
				$estados_nomes[] = $estado['nome'];
			}
	
			$this->_helper->json($dados);
		}
	}
	
	//Retorna estados cadastrados
	protected function getestadoscadastradosAction() {
	$model_estabelecimento = $this->_getModelEstabelecimentos();
		$model_cidades = $this->_getModelCidades();
		$model_estados = $this->_getModelEstados();
		$request = $this->getRequest();
		//Verifica se foi enviado via GET
		if($this->getRequest()->isGet()) {
			$estados = $model_estados->getEstados();
			$dados = $estados;
				
			$this->_helper->json($dados);
		}
	}
	
	//Retornar informacoes completas de uma oferta/campanha a partir do id da oferta
	protected function getofertaAction() {
		$model_usuario = $this->_getModelUsuarios();
		$model_estabelecimento = $this->_getModelEstabelecimentos();
		
		$usuario = $model_usuario->loadUsuarioLogado();
		$user = $usuario['id_facebook'];
		$request = $this->getRequest();
		//Verifica se foi enviado via GET
		if($this->getRequest()->isGet()) {
			$data = $request->getQuery();
			$id_oferta = $data['id'];
	
			$model_ofertas = $this->_getModelOfertas();
			$model_configs = $this->_getModelCampanhasConfigs();
				
			$dados = array();
				
			$value = $model_ofertas->fetchEntry($id_oferta);
			$campanha_e_oferta = $this->loadCampanhaEoferta($value);
			$campanha_e_oferta['oferta']['lojista'] = $model_estabelecimento->getNome($campanha_e_oferta['oferta']['id_estabelecimento']);
			
			$imagem = $model_estabelecimento->getFieldById($campanha_e_oferta['oferta']['id_estabelecimento'], 'imagem');
			if(($imagem) and ($imagem != "")) {
				$campanha_e_oferta['oferta']['lojista_imagem'] = 'images/estabelecimentos/'.$imagem;
				$campanha_e_oferta['oferta']['lojista_thumb'] = 'images/estabelecimentos/thumbs/'.$imagem;
				$campanha_e_oferta['oferta']['lojista_banner'] = 'images/estabelecimentos/banners/'.$imagem;
			}
			
			$campanha = $campanha_e_oferta['campanha'];
			$oferta = $campanha_e_oferta['oferta'];
			
			$configs = $model_configs->fetchEntry($campanha->id_config);
			if($configs['validade_visivel']) {
				$validade['data_min'] = $configs['data_min'];
				$validade['data_max'] = $configs['data_max'];
				if($configs['data_min']) $validade['data_min'] = date('d/m/Y',strtotime($validade['data_min']));
				if($configs['data_max']) $validade['data_max'] = date('d/m/Y',strtotime($validade['data_max']));
				$campanha_e_oferta['validade'] = $validade;
			} else {
				$validade['data_min'] = null;
				$validade['data_max'] = null;
				$campanha_e_oferta['validade'] = $validade;
			} 
			
			$campanha_e_oferta['categoria'] = $configs['categoria'];
			
			if(($campanha->ativo == 1) or ($usuario['id'] == $oferta['id_usuario'])) {
				$this->logCampanhaAcao($campanha->id, $usuario['id'], 'visualizada');
				
				$dados[] = $campanha_e_oferta;
			}
			else {
				$msg = "Oferta não disponível";
				$dados[] = $msg;
			}

			
			$this->_helper->json($dados);
		}
	}
	
	protected function logCampanhaAcao($id_campanha, $id_usuario, $acao) {
		$model_campanha = $this->_getModelCampanhas();
		$model_logCampanhaUsuario = $this->_getModelLogCampanhasUsuarios();
		
		switch ($acao) {
			//Caso o plural nao seja somente um S adicional. ex.: acao / acoes
// 			case 'visualizada':
// 				$acoes = 'visualizadas';
// 			break;
			
			default:
				$acoes= $acao.'s';
			break;
		}

		//Incrementa o nr total da acao
		$model_campanha->incAcao($id_campanha, $acoes);
		//Registra no log essa execucao da acao
		$model_logCampanhaUsuario->setAcao($id_campanha, $id_usuario, $acao);
	}
	
	//Funcao auxiliar para montar o resultado de oferta+campanha
	protected function loadCampanhaEoferta($value) {
		require_once APPLICATION_PATH . '/models/Campanha.php';
	
		$model_campanhas = $this->_getModelCampanhas();
		$campanha_e_oferta = array();
	
		$campanha_da_oferta = $model_campanhas->getCampanhas($value['id']);
		$campanha_da_oferta = $campanha_da_oferta[0];
		$campanha = new Campanha();
		$campanha->ativo = $campanha_da_oferta['ativo'];
		$campanha->curtiram = $campanha_da_oferta['curtiram'];
// 		$campanha->entregues = $campanha_da_oferta['entregues'];
		$campanha->id = $campanha_da_oferta['id'];
		$campanha->id_config = $campanha_da_oferta['id_config'];
		$campanha->id_oferta = $campanha_da_oferta['id_oferta'];
// 		$campanha->maximo = $campanha_da_oferta['maximo'];
// 		$campanha->nao_curtiram = $campanha_da_oferta['nao_curtiram'];
// 		$campanha->visualizadas = $campanha_da_oferta['visualizadas'];
	
		$campanha_e_oferta['oferta'] = $value;
		$imagem = $campanha_e_oferta['oferta']['imagem'];
		$campanha_e_oferta['oferta']['imagem'] = 'images/ofertas/'.$imagem;
		$campanha_e_oferta['oferta']['thumb'] = 'images/ofertas/thumbs/'.$imagem;
		$campanha_e_oferta['oferta']['banner'] = 'images/ofertas/banners/'.$imagem;
		$campanha_e_oferta['campanha'] = $campanha;
	
		return $campanha_e_oferta;
	}
	
	//curtir(curtir=1) ou não curtir(curtir=0) uma oferta pelo id da campanha referente
	protected function curtirAction() {
		$model_usuario = $this->_getModelUsuarios();
		$usuario = $model_usuario->loadUsuarioLogado();
		$user = $usuario['id_facebook'];
		$user_profile = $model_usuario->getUserProfile();
	
		if((isset($user)) and ($user != "")) {
			$request = $this->getRequest();
			//Verifica se foi enviado via GET
			if($this->getRequest()->isGet()) {
				$data = $request->getQuery();
				$model = $this->_getModelCampanhasVotos();
				$jaVotou = $model->jaVotou($data['id_campanha'], $user);
				if($jaVotou == FALSE){
					$model->save($data);
		
					$model2 = $this->_getModelCampanhas();
					$voto = intval($data['curtir']);
					$model2->computarVoto($data['id_campanha'], $voto);
		
					if($voto == 1) {
						$msg['mensagem'] = "Você gostou da oferta.";
						$msg['voto'] = 1;
					} else {
						$msg['mensagem'] = "Você não gostou da oferta.";
					}
					$msg[] = $msg;
					$this->_helper->json($msg);
				} else {
					if($model->curtiu($data['id_campanha'], $user)) {
						$curtiu = "Gostou";
						$msg['voto'] = 1;
					} else {
						$curtiu = "Não Gostou";
					}
					
					$msg['mensagem'] = "Você já classificou essa oferta: ".$curtiu.".";
					$msg[] = $msg;
					$this->_helper->json($msg);
				}
			}
		} else {
			$msg['mensagem'] = "Para classificar uma oferta você precisa ter um login Facebook associado à sua conta do Smartpanda.";
			$msg[] = $msg;
			$this->_helper->json($msg);
		}
	
	}
	
	protected function getcategoriasAction() {
		$model_categorias = $this->_getModelCategorias();
		
		$categorias = $model_categorias->getCategoriasAtivas();
		
		$msg['categorias'] = $categorias;
		$this->_helper->json($msg);
	}
	
	protected function criarloginAction() {
		$request = $this->getRequest();
		//Verifica se foi enviado via POST
		if($this->getRequest()->isPost()) {
			$data = $request->getPost();
			if(isset($data['login'])) $login = $data['login'];
			if(isset($data['senha'])) $senha = $data['senha'];
				
			if((isset($login)) and (isset($senha))) {
				$model_usuario = $this->_getModelUsuarios();
				$usuario = $model_usuario->loadUsuarioLogado();
				$id_usuario = $usuario['id'];
		
				if(!$model_usuario->fetchLogin($login)) {
					if(!$model_usuario->temLoginSenha($id_usuario)) {
						if($model_usuario->criarLoginSenha($id_usuario, $login, $senha)) {
							$msg['sucesso'] = true;
							$msg['mensagem'] = 'Conta criada com sucesso.';
						} else
						$msg['mensagem'] = 'Erro ao criar conta.';
					} else $msg['mensagem'] = 'Você já tem uma conta criada.';
					
				} else {
					$msg['mensagem'] = 'Este login já está sendo usado.';
				}
				$msg[] = $msg;
				$this->_helper->json($msg);
			}
			$msg['mensagem'] = 'Verifique o nome de usuário e senha';
			$msg[] = $msg;
			$this->_helper->json($msg);
				
		}
	}
	
	protected function alterarsenhaAction() {
		$request = $this->getRequest();
		//Verifica se foi enviado via POST
		if($this->getRequest()->isPost()) {
			$data = $request->getPost();
			if(isset($data['senhaAntiga'])) $senhaAntiga = $data['senhaAntiga'];
			if(isset($data['senhaNova'])) $senhaNova = $data['senhaNova'];
	
			if((isset($senhaAntiga)) and (isset($senhaNova))) {
				$model_usuario = $this->_getModelUsuarios();
				$usuario = $model_usuario->loadUsuarioLogado();
				$id_usuario = $usuario['id'];
				$login = $usuario['login'];
	
				if(isset($login)) {
					$msg['mensagem'] = $model_usuario->mudarSenha($login, $senhaAntiga, $senhaNova);
					if($msg['mensagem'] == "Senha alterada com sucesso") $msg['sucesso'] = true;
				} else {
					$msg['mensagem'] = "Conta não cadastrada.";
				}
				$msg[] = $msg;
				$this->_helper->json($msg);
			}
			$msg['mensagem'] = 'Verifique os campos de senha';
			$msg[] = $msg;
			$this->_helper->json($msg);
	
		}
	}
	
	//##########################

	
	
}