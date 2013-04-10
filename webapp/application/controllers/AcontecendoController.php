<?php
class AcontecendoController extends Zend_Controller_Action
{
	protected $_model;
	
	public function  indexAction()
	{	
		$model_usuario = $this->_getModelUsuarios();
// 		$usuario = $model_usuario->loadUsuarioLogado();
		$user_profile = $model_usuario->getUserProfile();

		$this->view->usuarioNome = $user_profile['first_name'];
		
		if($user_profile['gender'] == "female") $this->view->bemvindo = "bem-vinda";
		else $this->view->bemvindo = "bem-vindo";

		
// 		$servidor = Zend_Registry::get('configuration')->servidor;
		
		$request = $this->getRequest();
		//Verifica se foi enviado via GET
		if($this->getRequest()->isGet()) {
			$data = $request->getQuery();
// 			$fb_shopping = $data['fb_shopping'];
			$id_shopping = $data['id'];
			
// 			$face = Zend_Registry::get('facebook');
// 			$facebook = new Facebook($face);
			
// 			try {
// 				$profile = $facebook->api('/'.$fb_shopping,'GET');
// 			} catch (Exception $e) {
// 				$profile['name'] = "Shopping";
// 				$profile['link'] = "http://www.facebook.com";
// 			}
			
// 			$this->view->shoppingNome = $profile['name'];
			$this->view->shoppingID = $id_shopping;
		}
		
		
	}
	
// 	public function init(){
// 		$this->view->headScript()->appendFile('js/acontecendo.js');
// 	}

	
	protected function _getModelUsuarios() {
		require_once APPLICATION_PATH . '/models/Usuarios.php';
		$this->_model = new Model_Usuarios();
	
		return $this->_model;
	}
	
	
}