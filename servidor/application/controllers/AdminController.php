<?php
class AdminController extends Zend_Controller_Action
{
	public function  indexAction() {
		$this->view->headScript()->appendFile('js/admin.js');

	}
	
	public function init(){
		
	}
	
	public function preDispatch() {
		$model_usuario = $this->_getModelUsuarios();
		$model_usuario->loadUsuarioLogado();
		$user_profile = $model_usuario->getUserProfile();
		$usuario = $model_usuario->getUsuario();
		
		if($usuario['tipo'] != 3) {
			$this->_response->setRedirect("acessonegado")->sendResponse();
		}
	}
	
	
	protected function _getModelUsuarios() {
		require_once APPLICATION_PATH . '/models/Usuarios.php';
		$this->_model = new Model_Usuarios();
	
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
	
	protected function _getModelTelefones() {
		require_once APPLICATION_PATH . '/models/Telefones.php';
		$this->_model = new Model_Telefones();
	
		return $this->_model;
	}
	
	protected function _getModelCidades() {
		require_once APPLICATION_PATH . '/models/Cidades.php';
		$this->_model = new Model_Cidades();
	
		return $this->_model;
	}
	
	protected function _getModelAssinaturas() {
		require_once APPLICATION_PATH . '/models/Assinaturas.php';
		$this->_model = new Model_Assinaturas();
	
		return $this->_model;
	}
	
	protected function _getModelPlanos() {
		require_once APPLICATION_PATH . '/models/Planos.php';
		$this->_model = new Model_Planos();
	
		return $this->_model;
	}
	
	protected function _getModelLogSistemas() {
		require_once APPLICATION_PATH . '/models/LogSistemas.php';
		$this->_model = new Model_LogSistemas();
	
		return $this->_model;
	}
	
	protected function estabelecimentosAction() {
		$this->view->headScript()->appendFile('../js/adminestabelecimentos.js');
	}
	
	protected function getusuariosinativosAction() {
		$this->getUsuariosByAtivo(0);
	}
	
	protected function getusuariosativosAction() {
		$this->getUsuariosByAtivo(1);
	}
	
	protected function getUsuariosByAtivo($ativo) {
		$model_usuario = $this->_getModelUsuarios();
		$usuario = $model_usuario->loadUsuarioLogado();
		$user = $usuario['id_facebook'];
		$request = $this->getRequest();
		//Verifica se foi enviado via GET
		if($this->getRequest()->isGet()) {
			$id_facebook = $user;
	
			$usuarios = $model_usuario->getUsuariosByAtivo($ativo);
	
			$dados = $this->carregarUsuario($usuarios);
	
			$this->_helper->json($dados);
	
		}
	}
	
	protected function getusuariosfinaisativosAction() {
		$this->getUsuariosAtivosByTipo(1);
	}
	
	protected function getlojistasativosAction() {
		$this->getUsuariosAtivosByTipo(2);
	}
	
	protected function getalllojistasativosAction() {
		$this->getEstabelecimentosAtivos(2);
	}
	
	protected function getadminsativosAction() {
		$this->getUsuariosAtivosByTipo(3);
	}
	
	protected function getshoppingsativosAction() {
		$this->getUsuariosAtivosByTipo(4);
	}
	
	protected function getallshoppingsativosAction() {
		$this->getEstabelecimentosAtivos(4);
	}
	
	protected function getUsuariosAtivosByTipo($tipo) {
		$model_usuario = $this->_getModelUsuarios();
		$usuario = $model_usuario->loadUsuarioLogado();
		$user = $usuario['id_facebook'];
		$request = $this->getRequest();
		//Verifica se foi enviado via GET
		if($this->getRequest()->isGet()) {
			$id_facebook = $user;
	
			$usuarios = $model_usuario->getUsuariosAtivosByTipo($tipo);
	
			$dados = $this->carregarUsuario($usuarios);
	
			$this->_helper->json($dados);
	
		}
	}
	
	protected function getEstabelecimentosAtivos($tipo) {
		$model_usuario = $this->_getModelUsuarios();
		$model_estabelecimento = $this->_getModelEstabelecimentos();
		$request = $this->getRequest();
		//Verifica se foi enviado via GET
		if($this->getRequest()->isGet()) {
// 			$usuarios = $model_usuario->getUsuariosAtivosByTipo($tipo);
// 			$dados = $this->carregarUsuario($usuarios);
			$estabelecimentos = $model_estabelecimento->getEstabelecimentosAtivosByTipo($tipo);
			$dados = $this->carregarEstabelecimento($estabelecimentos);
			
			$this->_helper->json($dados);
	
		}
	}
	
	protected function getlojistasbyshoppingAction() {
		$model_estabelecimento = $this->_getModelEstabelecimentos();
		$request = $this->getRequest();
		//Verifica se foi enviado via GET
		if($this->getRequest()->isGet()) {
			$data = $request->getQuery();
			$id_shopping = $data['id_shopping'];
			$estabelecimentos = $model_estabelecimento->getLojistasByShopping($id_shopping);
			$dados = $this->carregarEstabelecimento($estabelecimentos);
				
			$this->_helper->json($dados);
	
		}
	}
	
	protected function getcadastroslojistasAction() {
		$model_estabelecimento = $this->_getModelEstabelecimentos();
		$model_estabelecimento_categoria = $this->_getModelEstabelecimentos_Categorias();
		$model_telefone = $this->_getModelTelefones();
		
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
				$loja->razao_social = $value['razao_social'];
				$loja->categoria = $value['categoria'];
				$loja->email = $value['email'];
				$loja->latitude = $value['latitude'];
				$loja->longitude = $value['longitude'];
	
				$estabelecimento['loja'] = $loja;
				$categoria = $model_estabelecimento_categoria->fetchEntry($loja->categoria);
				$estabelecimento['categoria'] = $categoria['nome'];
				$estabelecimento['telefone'] = '';
				$telefones = $model_telefone->getTelefonesByEstabelecimento($loja->id);
				foreach ($telefones as $telefone) {
					$estabelecimento['telefone'] .= $telefone['numero'].' ';
				}
				
				if($value['contratado'])
					$dados[] = $estabelecimento;
			}
	
			$this->_helper->json($dados);
	
		}
	}
	
	protected function getassinaturasbyestabelecimentoAction() {
		$model_assinatura = $this->_getModelAssinaturas();
		
		$request = $this->getRequest();
		//Verifica se foi enviado via GET
		if($this->getRequest()->isGet()) {
			$data = $request->getQuery();
			
			$id_estabelecimento = $data['id'];
			$dados = array();
			$assinaturas = $model_assinatura->getAssinaturasByEstabelecimento($id_estabelecimento);
			if($assinaturas) {
				foreach($assinaturas as $value) {
					$dados[] = $value;
				}
			}
			
			$this->_helper->json($dados);
		}
	}
	
	protected function getestabelecimentoscategoriasAction() {
		$model_usuario = $this->_getModelUsuarios();
		$model_estabelecimento_categoria = $this->_getModelEstabelecimentos_Categorias();
		$request = $this->getRequest();
		//Verifica se foi enviado via GET
		if($this->getRequest()->isGet()) {
			$categorias = $model_estabelecimento_categoria->getCategoriasAtivas();
			$dados = $categorias;
				
			$this->_helper->json($dados);
	
		}
	}
	
	protected function getplanosAction() {
		$model_plano = $this->_getModelPlanos();
		$request = $this->getRequest();
		//Verifica se foi enviado via GET
		if($this->getRequest()->isGet()) {
			$planos = $model_plano->getAtivos();
			$dados = $planos;
	
			$this->_helper->json($dados);
	
		}
	}
	
	protected function carregarEstabelecimento($estabelecimentos) {
		require_once APPLICATION_PATH . '/models/Estabelecimento.php';
		$model_estabelecimento = $this->_getModelEstabelecimentos();
		$model_estabelecimento_categoria = $this->_getModelEstabelecimentos_Categorias();
		$model_telefone = $this->_getModelTelefones();
		$dados = array();
		foreach($estabelecimentos as $value) {
			$estabelecimento = new Estabelecimento();
			$estabelecimento->ativo = $value['ativo'];
			$estabelecimento->id = $value['id'];
			$estabelecimento->id_usuario = $value['id_usuario'];
			$estabelecimento->id_facebook = $value['id_facebook'];
			$estabelecimento->id_shopping = $value['id_shopping'];
			$estabelecimento->nome_fantasia = $value['nome_fantasia'];
			$estabelecimento->cnpj = $value['cnpj'];
			$estabelecimento->endereco = $value['endereco'];
			$estabelecimento->nr = $value['nr'];
			$estabelecimento->complemento = $value['complemento'];
			$estabelecimento->cep = $value['cep'];
			$estabelecimento->email = $value['email'];
			$estabelecimento->latitude = $value['latitude'];
			$estabelecimento->longitude = $value['longitude'];
			$estabelecimento->tipo = $value['tipo'];
			$estabelecimento->creditos = $value['creditos'];
			$estabelecimento->contratado = $value['contratado'];
			$estabelecimento->categoria = $value['categoria'];
	
			switch ($value['tipo']) {
				case 1:
					$estabelecimento->tipo = "Usuário Final";
					break;
				case 2:
					$estabelecimento->tipo = "Lojista";
					break;
				case 3:
					$estabelecimento->tipo = "Administrador";
					break;
				case 4:
					$estabelecimento->tipo = "Shopping";
					break;
			}
			if($estabelecimento->tipo == "Lojista") {
				if(isset($estabelecimento->id_shopping)) {
					$nome_shopping = $model_estabelecimento->getFieldById($estabelecimento->id_shopping, 'nome_fantasia');
					$estabelecimento_info['nome_shopping'] = $nome_shopping;
				} else {
					$estabelecimento_info['nome_shopping'] = "Sem shopping";
				}
			} else {
				$estabelecimento_info['nome_shopping'] = "Não é lojista";
				$estabelecimento_info['qtd_lojistas'] = $model_estabelecimento->getQtdLojistas($estabelecimento->id);
			}
			$estabelecimento_info['estabelecimento'] = $estabelecimento;
			$estabelecimento_info['categoria'] = $model_estabelecimento_categoria->getFieldById($estabelecimento->categoria, 'nome');
			$estabelecimento_info['telefone'] = $model_telefone->getTelefonesByEstabelecimento($estabelecimento->id);
// 			if(isset($telefones)) $estabelecimento_info['telefone'] = $telefones[0]['numero']; 
	
			$dados[] = $estabelecimento_info;
	}
	return $dados;
	}
	
	protected function carregarUsuario($usuarios) {
		require_once APPLICATION_PATH . '/models/Usuario.php';
		$model_usuario = $this->_getModelUsuarios();
		$dados = array();
		foreach($usuarios as $value) {
// 			$face = Zend_Registry::get('facebook');
// 			$facebook = new Facebook($face);
				
// 			try {
// 				$profile = $facebook->api('/'.$value['id_facebook'],'GET');
// 			} catch (Exception $e) {
// 				$profile['name'] = "Usuário";
// 				$profile['link'] = "http://www.facebook.com";
// 			}
		
			$usuario = new Usuario();
			$usuario->ativo = $value['ativo'];
			$usuario->id = $value['id'];
			$usuario->id_facebook = $value['id_facebook'];
			$usuario->id_shopping = $value['id_shopping'];
			$usuario->nome = $value['nome'];
			$usuario->login = $value['login'];
			
			//converte o id_shopping para o id_facebook do shopping
			if($usuario->id_shopping)
				$usuario->id_shopping = $model_usuario->getFieldById($usuario->id_shopping, 'id_facebook');
			
			$usuario->latitude = $value['latitude'];
			$usuario->longitude = $value['longitude'];
			$usuario->tipo = $value['tipo'];
			$usuario->creditos = $value['creditos'];
// 			$usuario->nome = $profile['name'];
// 			$usuario->link = $profile['link'];
		
			switch ($value['tipo']) {
				case 1:
					$usuario->tipo = "Usuário Final";
					break;
				case 2:
					$usuario->tipo = "Lojista";
					break;
				case 3:
					$usuario->tipo = "Administrador";
					break;
				case 4:
					$usuario->tipo = "Shopping";
					break;
			}
		
		
			$dados[] = $usuario;
		}
		return $dados;
	}
	
	protected function ativarusuariofinalAction() {
		$this->ativarUsuario(1);
	}
	
	protected function ativarlojistaAction() {
		$this->ativarUsuario(2);
	}
	
	protected function ativaradminAction() {
		$this->ativarUsuario(3);
	}
	
	protected function ativarshoppingAction() {
		$this->ativarUsuario(4);
	}
	
	protected function desativarusuarioAction() {
		$model_usuario = $this->_getModelUsuarios();
		
		$request = $this->getRequest();
		//Verifica se foi enviado via GET
		if($this->getRequest()->isGet()) {
			$data = $request->getQuery();
				
			$id = $data['id'];
				
			$model_usuario->setUsuarioAtivo($id, 0);
				
			$msg['mensagem'] = "Usuário desativado com sucesso.";
			$msg[] = $msg;
			// 			$this->_helper->json($msg);
			$this->_response->setRedirect("../admin")->sendResponse();
		}
	}
	
	protected function ativarUsuario($tipo) {
		$model_usuario = $this->_getModelUsuarios();
		
		$request = $this->getRequest();
		//Verifica se foi enviado via GET
		if($this->getRequest()->isGet()) {
			$data = $request->getQuery();
			
			$id = $data['id'];
			
			$model_usuario->setUsuarioAtivo($id, 1);
			$model_usuario->setUsuarioTipo($id, $tipo);
			
			$msg['mensagem'] = "Usuário ativado com sucesso.";
			$msg[] = $msg;
// 			$this->_helper->json($msg);
			$this->_response->setRedirect("../admin")->sendResponse();
		}
	}
	
	protected function setshoppingAction() {
		$model_usuario = $this->_getModelUsuarios();
		$usuario = $model_usuario->loadUsuarioLogado();
		$user = $usuario['id_facebook'];
		$request = $this->getRequest();
		//Verifica se foi enviado via GET
		if($this->getRequest()->isGet()) {
			$data = $request->getQuery();
			if($data['id_shopping'] == 0) {
				$model_usuario->zerarShopping($data['id_lojista']);
				$msg['resultado'] = true;
			} else {
				$lojista = $model_usuario->fetchEntry($data['id_lojista']);
				$shopping = $model_usuario->fetchEntry($data['id_shopping']);
				
				if(($lojista['tipo'] == 2) and ($shopping['tipo'] == 4)) {
					$model_usuario->entrarNoShopping($lojista['id'], $shopping['id']);
					$msg['resultado'] = true;
				} else {
					$msg['resultado'] = false;
				}
			}
			$msg[] = $msg;
			$this->_helper->json($msg);
		}
	}
	
	protected function resetarsenhaAction() {
		$model_usuario = $this->_getModelUsuarios();
		$request = $this->getRequest();
		//Verifica se foi enviado via GET
		if($this->getRequest()->isGet()) {
			$data = $request->getQuery();
			$id_usuario = $data['id_usuario'];
			$usuario = $model_usuario->fetchEntry($id_usuario);
			$login = $usuario['login'];
			
			if((isset($login)) and ($model_usuario->fetchLogin($login))) {
				$novaSenha = $model_usuario->resetarSenha($login);
				if($novaSenha) {
					$msg['sucesso'] = true;
					$msg['mensagem'] = 'Senha resetada para: '.$novaSenha;
				} else {
					$msg['mensagem'] = "Erro ao resetar a senha";
				}
			} else {
				$msg['mensagem'] = "Não existe uma conta com esse login";
			}
			
			$msg[] = $msg;
			$this->_helper->json($msg);
		}
	}
	
	protected function createthumbAction() {
		$request = $this->getRequest();
		//Verifica se foi enviado via GET
		if($this->getRequest()->isGet()) {
			$data = $request->getQuery();
			$id_oferta_nova = $data['id'];
			
			WideImage::load(APPLICATION_PATH.'/../images/ofertas/'.$id_oferta_nova.'.jpg')->resize(150, 150)->crop('center','center',75,75)->saveToFile(APPLICATION_PATH.'/../images/ofertas/thumbs/'.$id_oferta_nova.'.jpg',75);
			WideImage::load(APPLICATION_PATH.'/../images/ofertas/'.$id_oferta_nova.'.jpg')->resizeDown(1500, 1500)->saveToFile(APPLICATION_PATH.'/../images/ofertas/'.$id_oferta_nova.'.jpg',75);
			$msg[] = "Imagem: ".$id_oferta_nova.".jpg Convertida";
			$this->_helper->json($msg);
		}
	}
	
	protected function createbannerAction() {
		$request = $this->getRequest();
		//Verifica se foi enviado via GET
		if($this->getRequest()->isGet()) {
			$data = $request->getQuery();
			$id_oferta_nova = $data['id'];
				
			WideImage::load(APPLICATION_PATH.'/../images/ofertas/'.$id_oferta_nova.'.jpg')->resize(675, null)->crop('center','center',670,210)->saveToFile(APPLICATION_PATH.'/../images/ofertas/banners/'.$id_oferta_nova.'.jpg',75);
			$msg[] = "Imagem: ".$id_oferta_nova.".jpg Convertida";
			$this->_helper->json($msg);
		}
	}
	
	protected function cadastrocidadeAction() {
		$model_cidade = $this->_getModelCidades();
		$request = $this->getRequest();
		//Verifica se foi enviado via POST
		if($this->getRequest()->isPost()) {
			$data = $request->getPost();
			$id_estado = $data['id_estado'];
			$cidade = $data['cidade'];
			
			$campoVazio = false;
				
			if((!isset($data['id_estado'])) or (!isset($data['cidade']))) $campoVazio = true;
				
			if(!$campoVazio) {
				if(!$model_cidade->temCidade($id_estado, $cidade)) {
					try {
							$cidade_nova['id_estado'] = $id_estado;
							$cidade_nova['nome'] = $cidade;
							$model_cidade->save($cidade_nova);
							$msg['sucesso'] = true;
							$msg['mensagem'] = 'Cidade cadastrada com sucesso.';
					} catch (Exception $e) {
						$msg['mensagem'] = 'Erro ao cadastrar cidade: '.$e;
					}
				} else {
					$msg['mensagem'] = 'Cidade já cadastrada nesse estado.';
				}
	
			} else {
				$msg['mensagem'] = 'Um ou mais campos obrigatórios não foram preenchidos.';
			}
	
			$msg[] = $msg;
			$this->_helper->json($msg);
		}
	}
	
	protected function precadastroAction() {
		$model_usuario = $this->_getModelUsuarios();

		$request = $this->getRequest();
		//Verifica se foi enviado via POST
		if($this->getRequest()->isPost()) {
			$data = $request->getPost();
			$campoVazio = false;
			
			if((!isset($data['nome_fantasia'])) or (!isset($data['tipo']))) $campoVazio = true;
			if(($data['tipo'] == 2) and (!isset($data['id_shopping']))) $campoVazio = true;
			
			if(!$campoVazio) {
				$model_estabelecimento = $this->_getModelEstabelecimentos();
				if(isset($data['id_shopping'])) $estabelecimento['id_shopping'] = $data['id_shopping'];
				$estabelecimento['nome_fantasia'] = $data['nome_fantasia'];
				if($data['tipo'] == 2) $estabelecimento['categoria'] = $data['categoria'];
				$estabelecimento['endereco'] = $data['endereco'];
				$estabelecimento['nr'] = $data['nr'];
				$estabelecimento['complemento'] = $data['complemento'];
				$estabelecimento['tipo'] = $data['tipo'];
				$estabelecimento['ativo'] = 1;
				$estabelecimento['contratado'] = 0;

				try {
					$id_estabelecimento = $model_estabelecimento->save($estabelecimento);
					
					if(isset($data['telefone'])) {
						try {
							$model_telefone = $this->_getModelTelefones();
							$telefone['id_estabelecimento'] = $id_estabelecimento;
							$telefone['numero'] = $data['telefone'];
							$model_telefone->save($telefone);
								
							$msg['sucesso'] = true;
							$msg['mensagem'] = 'Informações cadastradas com sucesso.';
						} catch (Exception $e) {
							$msg['mensagem'] = 'Erro ao cadastrar o telefone do estabelecimento.';
						}
					}
					
					$msg['sucesso'] = true;
					$msg['mensagem'] = $estabelecimento['nome_fantasia'].' cadastrado com sucesso.';
				} catch (Exception $e) {
					$msg['mensagem'] = 'Erro ao cadastrar estabelecimento: '.$e;
				}

			} else {
				$msg['mensagem'] = 'Um ou mais campos obrigatórios não foram preenchidos.';
			}
				
			$msg[] = $msg;
			$this->_helper->json($msg);
		}
	}
	
	protected function removerprecadastroAction() {
		$model_estabelecimento = $this->_getModelEstabelecimentos();
	
		$request = $this->getRequest();
		//Verifica se foi enviado via GET
		if($this->getRequest()->isGet()) {
			$data = $request->getQuery();
			$id = $data['id'];
	
			try {
				$model_estabelecimento->delete($id);
				$msg['sucesso'] = true;
				$msg['mensagem'] = "Pré-cadastro removido com sucesso.";
			} catch (Exception $e) {
				$msg['mensagem'] = "Erro ao remover pré-cadastro";
			}
			
			$msg[] = $msg;
			$this->_helper->json($msg);
		}
	}
	
	protected function salvarassinaturaAction() {
		$model_assinatura = $this->_getModelAssinaturas();
		$model_usuario = $this->_getModelUsuarios();
		$model_logSistema = $this->_getModelLogSistemas();
		
		$usuario = $model_usuario->loadUsuarioLogado();
		
		$request = $this->getRequest();
		//Verifica se foi enviado via GET
		if($this->getRequest()->isGet()) {
			$data = $request->getQuery();
			
			$assinatura['id_plano'] = $data['plano'];
			$assinatura['ativo'] = $data['ativo'];
			$assinatura['preco'] = $data['preco'];
			$assinatura['desconto'] = $data['desconto'];
// 			if(isset($data['inicio'])) $assinatura['inicio'] = $data['inicio'];
			if(isset($data['fim'])) $assinatura['fim'] = $data['fim'];
			
			try {
				$model_assinatura->update($assinatura, $data['id_assinatura']);
				$msg['sucesso'] = true;
				$msg['mensagem'] = "Assinatura alterada com sucesso.";
				$model_logSistema->log('6', 'Assinatura id='.$data['id_assinatura'].' alterada por id_usuario='.$usuario['id']);
			} catch (Exception $e) {
				$msg['mensagem'] = "Erro ao alterar assinatura.";
				$model_logSistema->log('3', 'Erro ao alterar assinatura id='.$data['id_assinatura'].' pelo id_usuario='.$usuario['id'].'. Error: '.$e);
			}
			
			$msg[] = $msg;
			$this->_helper->json($msg);
		}
	}
	
}