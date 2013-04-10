<?php
class ShoppingController extends Zend_Controller_Action
{
	public function  indexAction() {
		$model_usuario = $this->_getModelUsuarios();
		$model_usuario->loadUsuarioLogado();
		$usuario = $model_usuario->getUsuario();
		
		if($usuario['tipo'] != 4) {
			$this->_response->setRedirect("acessonegado")->sendResponse();
		}

	}
	
	public function init(){
		$this->view->headScript()->appendFile('js/shopping.js');
	}
	
	public function preDispatch() {
		$model_usuario = $this->_getModelUsuarios();
		$model_usuario->loadUsuarioLogado();
		$user_profile = $model_usuario->getUserProfile();
		$usuario = $model_usuario->getUsuario();
		
		if(($usuario['tipo'] != 4) and ($usuario['tipo'] != 3)) {
			$this->_response->setRedirect("acessonegado")->sendResponse();
		}
	}
	
	
	protected function _getModelUsuarios() {
		require_once APPLICATION_PATH . '/models/Usuarios.php';
		$this->_model = new Model_Usuarios();
	
		return $this->_model;
	}
	
	protected function _getModelConvites() {
		require_once APPLICATION_PATH . '/models/Convites.php';
		$this->_model = new Model_Convites();
	
		return $this->_model;
	}
	
	protected function _getModelLogCreditos() {
		require_once APPLICATION_PATH . '/models/LogCreditos.php';
		$this->_model = new Model_LogCreditos();
	
		return $this->_model;
	}
	
	protected function getlojistasAction() {
		$model_usuario = $this->_getModelUsuarios();
		$usuario = $model_usuario->loadUsuarioLogado();
		$user = $usuario['id_facebook'];
		$request = $this->getRequest();
		//Verifica se foi enviado via GET
		if($this->getRequest()->isGet()) {
			$id_facebook = $user;
			$id_shopping = $usuario['id'];
	
			$usuarios = $model_usuario->getLojistasByShopping($id_shopping);
	
			require_once APPLICATION_PATH . '/models/Usuario.php';
	
			$dados = array();
			foreach($usuarios as $value) {

				
				$usuario = new Usuario();
				$usuario->ativo = $value['ativo'];
				$usuario->id = $value['id'];
				$usuario->id_facebook = $value['id_facebook'];
				$usuario->nome = $value['nome'];
				$usuario->latitude = $value['latitude'];
				$usuario->longitude = $value['longitude'];
				$usuario->tipo = $value['tipo'];
				$usuario->creditos = $value['creditos'];
				
				
				
				$dados[] = $usuario;
			}
	
			$this->_helper->json($dados);
	
		}
	}
	
	protected function inccreditosAction() {
		$model_usuario = $this->_getModelUsuarios();
		$usuario = $model_usuario->loadUsuarioLogado();
		$user = $usuario['id_facebook'];
		$request = $this->getRequest();
		//Verifica se foi enviado via GET
		if($this->getRequest()->isGet()) {
			$data = $request->getQuery();
			$creditos = $data['creditos'];
			$id_lojista = $data['id'];
			$id_shopping = $usuario['id'];
			$model_logCreditos = $this->_getModelLogCreditos();
			
			if(($model_usuario->pertenceAoShopping($id_lojista, $id_shopping)) or ($usuario['tipo'] == 3)) {
				if($model_usuario->decCreditos($id_shopping, $creditos)) {
					$model_usuario->incCreditos($id_lojista, $creditos);
					$model_logCreditos->log($id_shopping, $id_lojista, $creditos);
					$msg['mensagem'] = "Usuário creditado com sucesso.";
				} else {
					$msg['mensagem'] = "Erro ao creditar usuário.";
				}
			} else {
				$msg['mensagem'] = "Lojista inválido.";
			}
			
			$msg[] = $msg;
			$this->_helper->json($msg);
		}
	}
	
	protected function deccreditosAction() {
		$model_usuario = $this->_getModelUsuarios();
		$usuario = $model_usuario->loadUsuarioLogado();
		$user = $usuario['id_facebook'];
		$request = $this->getRequest();
		//Verifica se foi enviado via GET
		if($this->getRequest()->isGet()) {
			$data = $request->getQuery();
			$creditos = $data['creditos'];
			$id_lojista = $data['id'];
			$id_shopping = $usuario['id'];
			$model_logCreditos = $this->_getModelLogCreditos();

			if(($model_usuario->pertenceAoShopping($id_lojista, $id_shopping)) or ($usuario['tipo'] == 3)) {
				if($model_usuario->decCreditos($id_lojista, $creditos)) {
					$model_usuario->incCreditos($id_shopping, $creditos);
					$model_logCreditos->log($id_lojista, $id_shopping, $creditos);
					$msg['mensagem'] = "Usuário descreditado com sucesso.";
				} else {
					$msg['mensagem'] = "Erro ao descreditar usuário";
				}
			} else {
				$msg['mensagem'] = "Lojista inválido.";
			}
				
			$msg[] = $msg;
			$this->_helper->json($msg);
		}
	}
	
	protected function creditosdisponiveisAction() {
		$model_usuario = $this->_getModelUsuarios();
		$usuario = $model_usuario->loadUsuarioLogado();
		$user = $usuario['id_facebook'];
		$request = $this->getRequest();
		//Verifica se foi enviado via GET
		if($this->getRequest()->isGet()) {
			$creditos = $usuario['creditos'];
	
			$msg['creditos'] = $creditos;
			
			$msg[] = $msg;
			$this->_helper->json($msg);
		}
	}
	
	protected function gerarconviteAction() {
		$model_usuario = $this->_getModelUsuarios();
		$usuario = $model_usuario->loadUsuarioLogado();
		$user = $usuario['id_facebook'];
		$request = $this->getRequest();
		//Verifica se foi enviado via GET
		if($this->getRequest()->isGet()) {
			$model_convite = $this->_getModelConvites();
			$id_shopping = $usuario['id'];
			$codigoConvite = $model_convite->gerarConvite($id_shopping);
			
			$msg['codigo'] = $codigoConvite;
				
			$msg[] = $msg;
// 			$this->_helper->json($msg);
			$this->_response->setRedirect("../shopping")->sendResponse();
		}
	}
	
	protected function removerconviteAction() {
		$model_usuario = $this->_getModelUsuarios();
		$usuario = $model_usuario->loadUsuarioLogado();
		$user = $usuario['id_facebook'];
		$request = $this->getRequest();
		//Verifica se foi enviado via GET
		if($this->getRequest()->isGet()) {
			$data = $request->getQuery();
			
			$model_convite = $this->_getModelConvites();
			$id_shopping = $usuario['id'];
			$id_convite = $data['id_convite'];
			
			$convite = $model_convite->fetchEntry($id_convite);
			
			if($id_shopping == $convite['id_shopping']) {
				if($model_convite->removerConvite($id_convite)) {
					$msg['mensagem'] = 'Convite Removido.';
				} else {
					$msg['mensagem'] = 'Erro ao remover convite.';
				}
				
			} else {
				$msg['mensagem'] = 'O convite não foi criado por esse usuário.';
			}
				
	
			$msg[] = $msg;
			$this->_helper->json($msg);
		}
	}
	
	protected function getconvitesAction() {
		$model_usuario = $this->_getModelUsuarios();
		$usuario = $model_usuario->loadUsuarioLogado();
		$user = $usuario['id_facebook'];
		$request = $this->getRequest();
		//Verifica se foi enviado via GET
		if($this->getRequest()->isGet()) {
			$model_convite = $this->_getModelConvites();
			$id_shopping = $usuario['id'];
	
			$convites = $model_convite->getConvites($id_shopping);
	
			require_once APPLICATION_PATH . '/models/Convite.php';
	
			$dados = array();
			foreach($convites as $value) {
	
	
				$convite = new Convite();
				$convite->codigo = $value['codigo'];
				$convite->id = $value['id'];
				$convite->id_lojista = $value['id_lojista'];
				$convite->id_shopping = $value['id_shopping'];
	
	
	
				$dados[] = $convite;
			}
	
			$this->_helper->json($dados);
	
		}
	}
	
}