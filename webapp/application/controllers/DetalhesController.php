<?php
class DetalhesController extends Zend_Controller_Action
{
	protected $_model;
	
	public function  indexAction()
	{	
// 		$model_usuario = $this->_getModelUsuarios();
// 		$usuario = $model_usuario->loadUsuarioLogado();

// 		$this->view->debug = $usuario['id_facebook'];

		$request = $this->getRequest();
		//Verifica se foi enviado via GET
		if($this->getRequest()->isGet()) {
			$data = $request->getQuery();
// 			$fb_lojista = $data['fb_lojista'];
			$id_oferta = $data['id'];
				
// 			$face = Zend_Registry::get('facebook');
// 			$facebook = new Facebook($face);
				
// 			try {
// 				$profile = $facebook->api('/'.$fb_lojista,'GET');
// 			} catch (Exception $e) {
// 				$profile['name'] = "Loja";
// 				$profile['link'] = "http://www.facebook.com";
// 			}
			
// 			$this->view->lojistaNome = $lojista['nome'];
			$this->view->ofertaID = $id_oferta;
		}
	}
	
// 	public function init(){
// 		$this->view->headScript()->appendFile('js/detalhes.js');
// 	}

	
	protected function _getModelUsuarios() {
		require_once APPLICATION_PATH . '/models/Usuarios.php';
		$this->_model = new Model_Usuarios();
	
		return $this->_model;
	}
	
	
}