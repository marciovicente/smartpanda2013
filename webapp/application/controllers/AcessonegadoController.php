<?php
class AcessonegadoController extends Zend_Controller_Action
{
	public function  indexAction() {
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

	protected function _getModelUsuarios() {
		require_once APPLICATION_PATH . '/models/Usuarios.php';
		$this->_model = new Model_Usuarios();
	
		return $this->_model;
	}
	
	
}