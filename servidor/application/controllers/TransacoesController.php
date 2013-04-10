<?php
class TransacoesController extends Zend_Controller_Action
{
	public function  indexAction() {
		$model_usuario = $this->_getModelUsuarios();
		$model_usuario->loadUsuarioLogado();
		$user_profile = $model_usuario->getUserProfile();
		$usuario = $model_usuario->getUsuario();
		
		$id_usuario = $usuario['id'];
		$this->view->nomeUsuario = $user_profile['name'];
		$this->view->outroUsuario = '<script>var outroUsuario;</script>';
		if($usuario['tipo'] == 3) {
			$request = $this->getRequest();
			//Verifica se foi enviado via GET
			if($this->getRequest()->isGet()) {
				$data = $request->getQuery('id_usuario');
				if($data) {
					$id_usuario = $data;
					$this->view->outroUsuario = '<script>outroUsuario = '.$id_usuario.';</script>';
					$usuarioFb = $model_usuario->getFieldById($id_usuario, 'id_facebook');
					
					$face = Zend_Registry::get('facebook');
					$facebook = new Facebook($face);
						
					try {
						$profile = $facebook->api('/'.$usuarioFb,'GET');
					} catch (Exception $e) {
						$profile['name'] = "Usuário";
					}
					
					$this->view->nomeUsuario = $profile['name'];
					
				}
			}
		}
		
		$model_logCreditos = $this->_getModelLogCreditos();
		$logRemetente = $model_logCreditos->getLogRemetente($id_usuario);
		$logDestinatario = $model_logCreditos->getLogDestinatario($id_usuario);
		
		$this->view->envios = "";
		foreach($logRemetente as $value) {
			$destinatario_fb = $model_usuario->getFieldById($value['id_destinatario'], 'id_facebook');
			$this->view->envios .= '<tr><td class="tdUsuario td'.$destinatario_fb.'">'.$destinatario_fb.'</td><td>'.$value['quantidade'].'</td><td>'.$value['timestamp'].'</td></tr>';
		}
		
		$this->view->recebimentos = "";
		foreach($logDestinatario as $value) {
			$remetente_fb = $model_usuario->getFieldById($value['id_remetente'], 'id_facebook');
			$this->view->recebimentos .= '<tr><td class="tdUsuario td'.$remetente_fb.'">'.$remetente_fb.'</td><td>'.$value['quantidade'].'</td><td>'.$value['timestamp'].'</td></tr>';
		}

	}
	
	public function init(){
		$this->view->headScript()->appendFile('js/transacoes.js');
	}
	
	public function preDispatch() {
		
	}
	
	
	protected function _getModelUsuarios() {
		require_once APPLICATION_PATH . '/models/Usuarios.php';
		$this->_model = new Model_Usuarios();
	
		return $this->_model;
	}
	
	protected function _getModelLogCreditos() {
		require_once APPLICATION_PATH . '/models/LogCreditos.php';
		$this->_model = new Model_LogCreditos();
	
		return $this->_model;
	}
	
	protected function creditosdisponiveisAction() {
		$model_usuario = $this->_getModelUsuarios();
		$usuario = $model_usuario->loadUsuarioLogado();
		$user = $usuario['id_facebook'];
		$request = $this->getRequest();
		//Verifica se foi enviado via GET
		if($this->getRequest()->isGet()) {
			$creditos = $usuario['creditos'];
			if($usuario['tipo'] == 3) {
				$data = $request->getQuery('id_usuario');
				if($data) {
					$id_usuario = $data;
					$creditos = $model_usuario->getFieldById($id_usuario, 'creditos');
				}
			}
			
	
			$msg['creditos'] = $creditos;
				
			$msg[] = $msg;
			$this->_helper->json($msg);
		}
	}

	
	
}