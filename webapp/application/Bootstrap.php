<?php
class Bootstrap {
	public function __construct($self) {
		defined('APPLICATION_PATH')
			or define('APPLICATION_PATH' , dirname(__FILE__));
		defined('APPLICATION_ENVIRONMENT')
			or define('APPLICATION_ENVIRONMENT', 'testing');
		
		//Facebook Connection
		require_once 'facebook/facebook.php';
		$appapikey = '225275740933146';
		$appsecret = 'c734a622c41cfe3b1a020c74d4518708';
		$appcallbackurl = 'http://smartpanda.com.br/webapp/';
		
		$facebook = array(
		'appId' => $appapikey,
		'secret' => $appsecret,
		);

		//Outras classes
		require_once 'Mobile-Detect/Mobile_Detect.php';
		
		include 'Zend/Loader/Autoloader.php';
	
		$autoloader = Zend_Loader_Autoloader::getInstance();
		
		//Zend_Loader::loadClass('Zend_Controller_Front');
		$frontController = Zend_Controller_Front::getInstance();
		$frontController->setControllerDirectory(APPLICATION_PATH . '/controllers');
		$frontController->setParam('env' , APPLICATION_ENVIRONMENT);
		
		//Plugins
		$plugin = Zend_Controller_Front::getInstance();
		$loader = new Zend_Loader_PluginLoader();
		$path = APPLICATION_PATH . '/controllers/plugin';
		$loader->addPrefixPath('plugin', $path);
		
		$loader->load('FbAuth');
		$plugin->registerPlugin(new Plugin_FbAuth());
		
		//Zend_Loader::loadClass('Zend_Layout');
		Zend_Layout::startMvc(APPLICATION_PATH . '/layouts/scripts');
		$view = Zend_Layout::getMvcInstance()->getView();
		//TIPO DO DOCUMENTO:
		$view->doctype('HTML5');
		
		//Zend_Loader::loadClass('Zend_Config_Ini');
		$configuration = new Zend_Config_Ini(
			APPLICATION_PATH . '/config/app.ini',
			APPLICATION_ENVIRONMENT
		);
		
		//Zend_Loader::loadClass('Zend_Db');
		//Zend_Loader::loadClass('Zend_Db_Table_Abstract');
		$dbAdapter = Zend_Db::factory($configuration->database);
		Zend_Db_Table_Abstract::setDefaultAdapter($dbAdapter);
		
		$registry = Zend_Registry::getInstance();
		$registry->configuration = $configuration;
		$registry->dbAdapter = $dbAdapter;
		$registry->set('facebook',$facebook);
		
		Zend_Controller_Front::getInstance()->dispatch();
		
		unset($frontController, $view, $configuration, $registry, $dbAdapter);
	}
}
