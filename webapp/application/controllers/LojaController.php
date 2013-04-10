<?php
class LojaController extends Zend_Controller_Action
{
	protected $_model;
	
	public function  indexAction()
	{	
		$model_usuario = $this->_getModelUsuarios();
		
		$request = $this->getRequest();
		//Verifica se foi enviado via GET
		if($this->getRequest()->isGet()) {
			$data = $request->getQuery();
			if($data) {
				foreach($data as $key=>$value) {
					$this->view->scripts .= $key.' = '.$value.';';
				}
			}
		}
		
		
	}

	
	protected function _getModelUsuarios() {
		require_once APPLICATION_PATH . '/models/Usuarios.php';
		$this->_model = new Model_Usuarios();
	
		return $this->_model;
	}
	
	
}