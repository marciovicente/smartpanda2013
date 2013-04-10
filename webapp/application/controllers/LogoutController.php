<?php
class LogoutController extends Zend_Controller_Action
{
	protected $_model;
	
	public function  indexAction()
	{	
		
	}
	
	public function preDispatch() {
		$face = Zend_Registry::get('facebook');
		$facebook = new Facebook($face);
		$params = array( 'next' => 'http://bambooss.com/panda-m' );
		$logoutLink = $facebook->getLogoutUrl($params);
		$facebook->destroySession();
		
		$this->_response->setRedirect($logoutLink)->sendResponse();
	
	}
	
	
}