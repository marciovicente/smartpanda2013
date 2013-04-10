<?php
class ShoppingsController extends Zend_Controller_Action
{
	protected $_model;
	
	public function  indexAction()
	{	
		$model_usuario = $this->_getModelUsuarios();
// 		$usuario = $model_usuario->loadUsuarioLogado();

// 		$this->view->debug = $usuario['id_facebook'];

		
// 		$servidor = Zend_Registry::get('configuration')->servidor;
		
		$request = $this->getRequest();
		//Verifica se foi enviado via GET
		if($this->getRequest()->isGet()) {
			$data = $request->getQuery();
			$this->view->scripts = 'var id_cidade;';
			if($data) {
				foreach($data as $key=>$value) {
					$this->view->scripts .= $key.' = '.$value.';';
				}
			}
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