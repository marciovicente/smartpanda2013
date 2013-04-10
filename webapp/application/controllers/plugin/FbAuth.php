<?php
class Plugin_FbAuth extends Zend_Controller_Plugin_Abstract {
	
	private $_whitelist;
	
	public function __construct()
	{
		$this->_whitelist = array(
	            'index/index',
	            'acessonegado/index'
		);
	}
	
	public function preDispatch(Zend_Controller_Request_Abstract $request) {
		$controller = strtolower($request->getControllerName());
		$action = strtolower($request->getActionName());
		$route = $controller . '/' . $action;
		if ((in_array($route, $this->_whitelist)) or (APPLICATION_ENVIRONMENT == 'development')) {
			return;
		}
		
		$model_usuario = $this->_getModelUsuarios();
		$face = Zend_Registry::get('facebook');
		$facebook = new Facebook($face);
		$user = $facebook->getUser();
		$model_usuario->id_facebook = $user;
		if ($user) {
			return;
// 			$usuario = $model_usuario->getUsuario();
// 			if ($usuario['ativo'] > 0) {
// 				return;
// 			} else {
// 				return $this->_response->setRedirect("acessonegado")->sendResponse();
// 			}
		}
		$_SESSION['informacoes']['redirect_link'] = $this->getRequest()->getScheme() . '://' . $this->getRequest()->getHttpHost() . $this->getRequest()->getRequestUri();
		return $this->_response->setRedirect("index")->sendResponse();
	}
	
	protected function _getModelUsuarios() {
		require_once APPLICATION_PATH . '/models/Usuarios.php';
		$this->_model = new Model_Usuarios();
	
		return $this->_model;
	}
}
