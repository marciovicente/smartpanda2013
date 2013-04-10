<?php
class LogoutController extends Zend_Controller_Action
{
	protected $_model;
	
	public function  indexAction()
	{	
		
	}
	
	public function preDispatch() {
		if(isset($_SESSION['usuariologinSession']['login'])) $loginProprio = true;
		$face = Zend_Registry::get('facebook');
		$facebook = new Facebook($face);
		$params = array( 'next' => 'http://smartpanda.com.br/servidor/' );
		$logoutLink = $facebook->getLogoutUrl();
		$facebook->destroySession();
		$facebook->setAccessToken('0');
		
		$_SESSION = array();
		if (isset($_COOKIE[session_name()])) {
			setcookie(session_name(), '', time()-42000, '/');
		}
		session_destroy();
		
// 		if($loginProprio)
			$this->_response->setRedirect('index')->sendResponse();
// 		else
// 			$this->_response->setRedirect($logoutLink)->sendResponse();
	
	}
	
	
}