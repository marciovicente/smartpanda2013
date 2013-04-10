<?php
class LoginController extends Zend_Controller_Action
{
	protected $_model;
	
	public function  indexAction()
	{	
		
	}
	
	public function preDispatch() {
		$request = $this->getRequest();
		//Verifica se foi enviado via POST
		if($this->getRequest()->isPost()) {
			$data = $request->getPost();
			if(isset($data['login'])) $login = $data['login'];
			if(isset($data['senha'])) $senha = $data['senha'];
			
			if((isset($login)) and (isset($senha))) {
				$model_usuario = $this->_getModelUsuarios();
				$model_logacesso = $this->_getModelLogAcessos();
				
				if($model_usuario->checkLogin($login, $senha)) {
					$_SESSION['usuariologinSession']['login'] = $login;
					$usuario = $model_usuario->fetchLogin($login);
					if($usuario['ativo'] > 0) {
						$model_logacesso->log($usuario['id']);
						$msg['sucesso'] = true;
						$msg['mensagem'] = 'Login OK. Aguarde...';
					} else {
						$msg['mensagem'] = 'Acesso Negado';
					}
					$msg[] = $msg;
					$this->_helper->json($msg);
				}
			}
			$msg['mensagem'] = 'Verifique seu nome de usuário e senha';
			$msg[] = $msg;
			$this->_helper->json($msg);
			
		}
	
	}
	
	protected function _getModelUsuarios() {
		require_once APPLICATION_PATH . '/models/Usuarios.php';
		$this->_model = new Model_Usuarios();
	
		return $this->_model;
	}
	
	protected function _getModelLogAcessos() {
		require_once APPLICATION_PATH . '/models/LogAcessos.php';
		$this->_model = new Model_LogAcessos();
	
		return $this->_model;
	}
	
	
}