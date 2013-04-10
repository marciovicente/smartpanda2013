<?php
class LoginfbController extends Zend_Controller_Action
{
	protected $_model;
	
	public function  indexAction()
	{	
		$this->_helper->layout->setLayout('index');

	}
	
	public function init(){
		$this->view->headScript()->appendFile('js/loginfb.js');
	}
	
	public function preDispatch() {
		$model_usuario = $this->_getModelUsuarios();
		if(isset($_SESSION['usuariologinSession']['login'])) {
			$login = $_SESSION['usuariologinSession']['login'];
			$usuario = $model_usuario->fetchLogin($login);
			$webapp = Zend_Registry::get('configuration')->webapp;
			if($usuario['tipo'] == 1)
				return $this->_response->setRedirect($webapp)->sendResponse();
			else
				return $this->_response->setRedirect("ofertascadastradas")->sendResponse();
				
		} else {
			$face = Zend_Registry::get('facebook');
			$facebook = new Facebook($face);
			$user = $facebook->getUser();
			$model_usuario->id_facebook = $user;
			$usuario = $model_usuario->getUsuario();
			if ($user) {
				$webapp = Zend_Registry::get('configuration')->webapp;
				if($usuario['tipo'] == 1)
					return $this->_response->setRedirect($webapp)->sendResponse();
				else
					return $this->_response->setRedirect("migrarfb")->sendResponse();
			}
		}
	
	}
	
	protected function _getModelUsuarios() {
		require_once APPLICATION_PATH . '/models/Usuarios.php';
		$this->_model = new Model_Usuarios();
	
		return $this->_model;
	}
	
	
}