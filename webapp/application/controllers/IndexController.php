<?php
class IndexController extends Zend_Controller_Action
{
	protected $_model;
	
	public function  indexAction()
	{	
		$this->_helper->layout->setLayout('index');
// 		$model_usuario = $this->_getModelUsuarios();
// 		$usuario = $model_usuario->loadUsuarioLogado();

// 		$this->view->debug = $usuario['id_facebook'];
		$detect = new Mobile_Detect();
		if ($detect->is('AndroidOS')) {
			$this->view->app = '<li><a href="https://play.google.com/store/apps/details?id=com.bambooss.smartpanda" data-icon="star" data-icon-pos="top" data-mini="true">Instalar Aplicativo</a></li>' ;
		}
	}
	
	public function init(){
// 		$this->view->headScript()->appendFile('js/index.js');
	}
	
	public function preDispatch() {
		$face = Zend_Registry::get('facebook');
		$facebook = new Facebook($face);
		$user = $facebook->getUser();
		if ($user) {
			if(isset($_SESSION['informacoes']['redirect_link'])) {
				$link = $_SESSION['informacoes']['redirect_link'];
				unset($_SESSION['informacoes']['redirect_link']);
				return $this->_response->setRedirect($link)->sendResponse();
			}
			else
				return $this->_response->setRedirect("shoppings")->sendResponse();
		}
	
	}
	
	protected function _getModelUsuarios() {
		require_once APPLICATION_PATH . '/models/Usuarios.php';
		$this->_model = new Model_Usuarios();
	
		return $this->_model;
	}
	
	protected function getusuariologadoAction() {
		$model_usuario = $this->_getModelUsuarios();
		$usuario = $model_usuario->loadUsuarioLogado();
		$user = $usuario['id_facebook'];
	
		$request = $this->getRequest();
		//Verifica se foi enviado via GET
		if($this->getRequest()->isGet()) {
			$dados = array();
			$dados[] = $usuario;
				
			$this->_helper->json($dados);
		}
	}
	
	
}