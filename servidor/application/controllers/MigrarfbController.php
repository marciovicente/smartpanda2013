<?php
class MigrarfbController extends Zend_Controller_Action
{
	public function  indexAction() {
		$model_usuario = $this->_getModelUsuarios();
		$usuario = $model_usuario->loadUsuarioLogado();
// 		$user_profile = $model_usuario->getUserProfile();
		
		
		if(!$model_usuario->temLoginSenha($usuario['id'])) {
			$this->view->script .= '$("#modallogin").modal("show")';
		} else {
			$model_estabelecimento = $this->_getModelEstabelecimentos();
			if((!$model_estabelecimento->temEstabelecimentoContratado($usuario['id'])) and (($usuario['tipo'] == 2) or ($usuario['tipo'] == 4))) {
				$this->view->nome_fantasia = $usuario['nome'];
				if(isset($usuario['email'])) $this->view->email = $usuario['email'];
				$this->view->botao .= ' <a href="#modalcompletarcadastro" class="btn btn-success bt-avancar" data-toggle="modal">Completar Cadastro</a>';
				$this->view->script .= '$("#modalcompletarcadastro").modal("show")';
			} else {
				return $this->_response->setRedirect('logout')->sendResponse();
			}
		}

	}
	
	public function init(){
		$this->view->headScript()->appendFile('js/migrarfb.js');
	}
	
	public function preDispatch() {
		$model_usuario = $this->_getModelUsuarios();
		$usuario = $model_usuario->loadUsuarioLogado();
	
		if($usuario['tipo'] < 2) {
			$webapp = Zend_Registry::get('configuration')->webapp;
			return $this->_response->setRedirect($webapp)->sendResponse();
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

	
}
