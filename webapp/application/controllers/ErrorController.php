<?php

class ErrorController extends Zend_Controller_Action
{

	public function errorAction()
	{
// 		$this->_helper->layout->setLayout('layout-erro');
		
		$this->_helper->viewRenderer->setViewSuffix('phtml');
		$errors = $this->_getParam('error_handler');
		
		switch ($errors->type) {
			case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
			case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
				$this->getResponse()->setHttpResponseCode(404);
				$this->view->message = 'Página não encontrada O.o (404)';
			break;
			
			default:
				$this->getResponse()->setHttpResponseCode(500);
				$this->view->message = 'Erro da Aplicação O_O (500)';
			break;
		}
		
		$this->view->env = $this->getInvokeArg('env');
		$this->view->exception = $errors->exception;
		$this->view->request = $errors->request;
	}
}
?>