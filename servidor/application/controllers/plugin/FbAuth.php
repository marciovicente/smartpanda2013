<?php
class Plugin_FbAuth extends Zend_Controller_Plugin_Abstract {
	
	private $_whitelist;
	
	public function __construct()
	{
		$this->_whitelist = array(
	            'index/index',
	            'acessonegado/index',
	            'sistema/login',
		    'sistema/getshoppingsativos',
		    'sistema/getlojasativas',
	 	    'sistema/getcidadescomshoppings',
		    'sistema/getestadoscomshoppings',
		    'sistema/getlojasprecadastradas',
	            'fullscreen/getofertasbyid',
	            'login/index',
		    'cadastro/cadastrar',
		    'loginfb/index',
		    'pagamentos/notificacao',
		    'publico/anuncio'
		);
	}
	
	public function preDispatch(Zend_Controller_Request_Abstract $request) {
		$controller = strtolower($request->getControllerName());
		$action = strtolower($request->getActionName());
		$route = $controller . '/' . $action;
		if ((in_array($route, $this->_whitelist)) or (APPLICATION_ENVIRONMENT == 'development')) {
			return;
		}
		
		$model_usuario = $this->_getModelUsuarios();
		
		if(isset($_SESSION['usuariologinSession']['login'])) {
			$login = $_SESSION['usuariologinSession']['login'];
			$usuario = $model_usuario->fetchLogin($login);
			if ($usuario['ativo'] > 0) {
				if((($usuario['tipo'] == 2) or ($usuario['tipo'] == 4)) and (($route != 'cadastro/confirmarplano') and ($route != 'cadastro/assinar') and ($route != 'pagamentos/gerarpagamento'))) {
					$model_assinatura = $this->_getModelAssinaturas();
					$assinaturas = $model_assinatura->getAssinaturasByUsuario($usuario['id']);
					if($assinaturas) {
						$semPlano = true;
						foreach ($assinaturas as $value) {
							if($value['ativo'] == 1) {
								$semPlano = false;
							}
						}
						if($semPlano) {
							//Usuario se cadastrou e escolheu o plano, agora precisa confirmar e realizar o pagamento
							return $this->_response->setRedirect("cadastro/confirmarplano")->sendResponse();
						}
					} else {
						//Usuario nao tem um plano escolhido
						return $this->_response->setRedirect("cadastro/assinar")->sendResponse();
					}
				}
				
				
				return;
			} else {
				return $this->_response->setRedirect("acessonegado")->sendResponse();
			}
			
		} else {
			$face = Zend_Registry::get('facebook');
			$facebook = new Facebook($face);
			$user = $facebook->getUser();
			$model_usuario->id_facebook = $user;
			$usuario = $model_usuario->getUsuario();
			if ($user) {
				if ($usuario['ativo'] > 0) {
					//if(($usuario['tipo'] > 1) and ($controller != 'sistema') and ($route != 'migrarfb/index'))
					//	return $this->_response->setRedirect("migrarfb")->sendResponse();
					//else
						return;
				} else {
					return $this->_response->setRedirect("acessonegado")->sendResponse();
				}
			}
		}
		
		return $this->_response->setRedirect("index")->sendResponse();
	}
	
	protected function _getModelUsuarios() {
		require_once APPLICATION_PATH . '/models/Usuarios.php';
		$this->_model = new Model_Usuarios();
	
		return $this->_model;
	}

	protected function _getModelAssinaturas() {
		require_once APPLICATION_PATH . '/models/Assinaturas.php';
		$this->_model = new Model_Assinaturas();
	
		return $this->_model;
	}
}
