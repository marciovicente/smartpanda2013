<?php
class PublicoController extends Zend_Controller_Action
{
	public function  indexAction() {
		

	}
	
	public function init(){
// 		$this->view->headScript()->appendFile('../js/statusoferta.js');
		$this->view->headLink()->appendStylesheet('../style.css');
	}
	
	
	protected function _getModelUsuarios() {
		require_once APPLICATION_PATH . '/models/Usuarios.php';
		$this->_model = new Model_Usuarios();
	
		return $this->_model;
	}
	
	protected function _getModelOfertas() {
		require_once APPLICATION_PATH . '/models/Ofertas.php';
		$this->_model = new Model_Ofertas();
	
		return $this->_model;
	}
	
	protected function _getModelCampanhasConfigs() {
		require_once APPLICATION_PATH . '/models/CampanhasConfigs.php';
		$this->_model = new Model_CampanhasConfigs();
	
		return $this->_model;
	}
	
	protected function _getModelCampanhas() {
		require_once APPLICATION_PATH . '/models/Campanhas.php';
		$this->_model = new Model_Campanhas();
	
		return $this->_model;
	}
	
	protected function _getModelEstabelecimentos() {
		require_once APPLICATION_PATH . '/models/Estabelecimentos.php';
		$this->_model = new Model_Estabelecimentos();
	
		return $this->_model;
	}
	
	protected function _getModelLogCampanhas() {
		require_once APPLICATION_PATH . '/models/LogCampanhas.php';
		$this->_model = new Model_LogCampanhas();
	
		return $this->_model;
	}
	
	protected function _getModelAssinaturas() {
		require_once APPLICATION_PATH . '/models/Assinaturas.php';
		$this->_model = new Model_Assinaturas();
	
		return $this->_model;
	}
	
	protected function _getModelPlanos() {
		require_once APPLICATION_PATH . '/models/Planos.php';
		$this->_model = new Model_Planos();
	
		return $this->_model;
	}
	
	protected function _getModelLogCampanhasUsuarios() {
		require_once APPLICATION_PATH . '/models/LogCampanhasUsuarios.php';
		$this->_model = new Model_LogCampanhasUsuarios();
	
		return $this->_model;
	}
	
	protected function anuncioAction() {
		$this->_helper->layout->setLayout('anuncio');
		$this->view->doctype('XHTML1_RDFA');
		$this->view->headMeta()->setProperty('fb:app_id', '225275740933146');
		$this->view->headMeta()->setProperty('og:type', 'website');
		
		$request = $this->getRequest();
		$model_usuario = $this->_getModelUsuarios();
		$model_estabelecimento = $this->_getModelEstabelecimentos();
		$model_logCampanhaUsuario = $this->_getModelLogCampanhasUsuarios();
		
		//Verifica se foi enviado via GET
		if($this->getRequest()->isGet()) {
			$data = $request->getQuery();
			$oferta_id = $data['id'];
			$model_campanhas = $this->_getModelCampanhas();
			$model_ofertas = $this->_getModelOfertas();
		
			$oferta = $model_ofertas->fetchEntry($oferta_id);
				
			$oferta_lojista = $model_usuario->fetchEntry($oferta['id_usuario']);
			$estabelecimento_lojista = $model_estabelecimento->getByUsuario($oferta_lojista['id']);
			if((isset($estabelecimento_lojista['id_shopping'])) and ($estabelecimento_lojista['id_shopping'] !=""))
				$shopping = $model_estabelecimento->fetchEntry($estabelecimento_lojista['id_shopping']);
				
			$campanha_e_oferta = array();
			$campanha_da_oferta = $model_campanhas->getCampanhas($oferta['id']);
			$campanha_da_oferta = $campanha_da_oferta[0];
		
			if($campanha_da_oferta['ativo']) {
				$model_campanhas->incAcao($campanha_da_oferta['id'], 'entregues');
		
				$webapp = Zend_Registry::get('configuration')->webapp;
				$servidor = Zend_Registry::get('configuration')->servidor;
		
				$this->view->id_oferta = $oferta['id'];
				$this->view->titulo = $oferta['titulo'];
				$this->view->imagem = '../images/ofertas/'.$oferta['imagem'];
				if((isset($estabelecimento_lojista['imagem'])) and ($estabelecimento_lojista['imagem'] != "")) {
					$banner = '../images/estabelecimentos/banners/'.$estabelecimento_lojista['imagem'];
					$this->view->lojistaBanner = '<img style="float:none;width:230px" src="'.$banner.'" alt="Banner do lojista">';
				}
				
				$this->view->headMeta()->setProperty('og:url', $servidor.'/publico/anuncio?id='.$oferta['id']);
				$this->view->headMeta()->setProperty('og:title', $estabelecimento_lojista['nome_fantasia']);
				$this->view->headMeta()->setProperty('og:description', $oferta['titulo']);
				$this->view->headMeta()->appendName('description', $oferta['titulo']);
				$this->view->headMeta()->setProperty('og:image', $servidor.'/images/ofertas/'.$oferta['imagem']);
				
// 				$this->view->texto = $oferta['texto'];
				$this->view->webapp = $webapp."/detalhes?id=".$oferta['id'];
				$this->view->lojista = $estabelecimento_lojista['nome_fantasia'];
				if(isset($shopping))
					$this->view->shopping = '('.$shopping['nome_fantasia'].')';
		
				$model_configs = $this->_getModelCampanhasConfigs();
				$configs = $model_configs->fetchEntry($campanha_da_oferta['id_config']);
		
				if($configs['idade_min'] > 0) $this->view->idade_min = $configs['idade_min']." anos";
				else $this->view->idade_min = "Sem Limite";
				if($configs['idade_min'] > 0) $this->view->idade_max = $configs['idade_max']." anos";
				else $this->view->idade_max = "Sem Limite";
		
				$this->view->data_min = "N/D";
				$this->view->data_max = "N/D";
				if($configs['data_min']) $this->view->data_min = date('d/m/Y',strtotime($configs['data_min']));
				if($configs['data_max']) $this->view->data_max = date('d/m/Y',strtotime($configs['data_max']));
		
			} else {
				$this->view->nome = "Anúncio inexistente ou desativado.";
			}
		
		
		} else {
			$this->view->nome = "Oferta inexistente";
		}
	}
	
}