<?php
class FullscreenController extends Zend_Controller_Action
{
	protected $_model;
	
	public function  indexAction()
	{	
		
	}
	
	public function preDispatch() {
		
	
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
	
	protected function _getModelCampanhas() {
		require_once APPLICATION_PATH . '/models/Campanhas.php';
		$this->_model = new Model_Campanhas();
	
		return $this->_model;
	}
	
	protected function _getModelCampanhasVotos() {
		require_once APPLICATION_PATH . '/models/CampanhasVotos.php';
		$this->_model = new Model_CampanhasVotos();
	
		return $this->_model;
	}
	
	protected function _getModelCampanhasConfigs() {
		require_once APPLICATION_PATH . '/models/CampanhasConfigs.php';
		$this->_model = new Model_CampanhasConfigs();
	
		return $this->_model;
	}
	
	//Retorna todas as ofertas ativas cadastradas por um usuario. Se esse for shopping, retorna dos seus lojistas tambem
	protected function getofertasbyidAction() {
		$model_usuario = $this->_getModelUsuarios();
		$model_ofertas = $this->_getModelOfertas();
		$model_configs = $this->_getModelCampanhasConfigs();
		$request = $this->getRequest();
		//Verifica se foi enviado via GET
		if($this->getRequest()->isGet()) {
			$data = $request->getQuery();
			$id_shopping = $data['id'];
			$dados = array();


			//Pega as ofertas criadas pelo proprio shopping
			$shopping = $model_usuario->fetchEntry($id_shopping);
			
			if($shopping['ativo'] != 1) {
				$this->_helper->json($dados);
			}
			$ofertasShopping = $model_ofertas->getOfertas($shopping['id']);
			
			foreach($ofertasShopping as $value) {
				$campanha_e_oferta = $this->loadCampanhaEoferta($value);
				$campanha = $campanha_e_oferta['campanha'];
				
				if($model_configs->checkConfigPublico($campanha->id_config)) {
					$campanha_e_oferta['oferta']['lojista'] = $model_usuario->getNome($campanha_e_oferta['oferta']['id_usuario']);
					$campanha_e_oferta['shopping'] = $model_usuario->getNome($shopping['id']);

					$configs = $model_configs->fetchEntry($campanha->id_config);
					if($configs['validade_visivel']) {
						$validade['data_min'] = $configs['data_min'];
						$validade['data_max'] = $configs['data_max'];
						if($configs['data_min']) $validade['data_min'] = date('d/m/Y',strtotime($validade['data_min']));
						if($configs['data_max']) $validade['data_max'] = date('d/m/Y',strtotime($validade['data_max']));
						$campanha_e_oferta['validade'] = $validade;
					} else {
						$validade['data_min'] = null;
						$validade['data_max'] = null;
						$campanha_e_oferta['validade'] = $validade;
					}
					
					if($campanha->ativo == 1)
						$dados[] = $campanha_e_oferta;
				}
			}
			
			
			//Pega as ofertas dos lojistas do shopping	
			$lojistas = $model_usuario->getLojistasByShopping($id_shopping);		
			
			foreach ($lojistas as $lojista) {
				$ofertas = $model_ofertas->getOfertas($lojista['id']);
				foreach($ofertas as $value) {
					$campanha_e_oferta = $this->loadCampanhaEoferta($value);
					$campanha = $campanha_e_oferta['campanha'];
					if($model_configs->checkConfigPublico($campanha->id_config)) {
						$campanha_e_oferta['oferta']['lojista'] = $model_usuario->getNome($campanha_e_oferta['oferta']['id_usuario']);
						$campanha_e_oferta['shopping'] = $model_usuario->getNome($shopping['id']);
						
						$configs = $model_configs->fetchEntry($campanha->id_config);
						if($configs['validade_visivel']) {
							$validade['data_min'] = $configs['data_min'];
							$validade['data_max'] = $configs['data_max'];
							if($configs['data_min']) $validade['data_min'] = date('d/m/Y',strtotime($validade['data_min']));
							if($configs['data_max']) $validade['data_max'] = date('d/m/Y',strtotime($validade['data_max']));
							$campanha_e_oferta['validade'] = $validade;
						} else {
							$validade['data_min'] = null;
							$validade['data_max'] = null;
							$campanha_e_oferta['validade'] = $validade;
						}
						
						if($campanha->ativo == 1)
							$dados[] = $campanha_e_oferta;
					}
				}
			}
				
			$this->_helper->json($dados);
		}
	}
	
	//Funcao auxiliar para montar o resultado de oferta+campanha
	protected function loadCampanhaEoferta($value) {
		require_once APPLICATION_PATH . '/models/Campanha.php';
	
		$model_campanhas = $this->_getModelCampanhas();
		$campanha_e_oferta = array();
	
		$campanha_da_oferta = $model_campanhas->getCampanhas($value['id']);
		$campanha_da_oferta = $campanha_da_oferta[0];
		$campanha = new Campanha();
		$campanha->ativo = $campanha_da_oferta['ativo'];
		$campanha->curtiram = $campanha_da_oferta['curtiram'];
// 		$campanha->entregues = $campanha_da_oferta['entregues'];
		$campanha->id = $campanha_da_oferta['id'];
		$campanha->id_config = $campanha_da_oferta['id_config'];
		$campanha->id_oferta = $campanha_da_oferta['id_oferta'];
// 		$campanha->maximo = $campanha_da_oferta['maximo'];
// 		$campanha->nao_curtiram = $campanha_da_oferta['nao_curtiram'];
// 		$campanha->visualizadas = $campanha_da_oferta['visualizadas'];
	
		$campanha_e_oferta['oferta'] = $value;
		$imagem = $campanha_e_oferta['oferta']['imagem'];
		$campanha_e_oferta['oferta']['imagem'] = 'images/ofertas/'.$imagem;
		$campanha_e_oferta['oferta']['thumb'] = 'images/ofertas/thumbs/'.$imagem;
		$campanha_e_oferta['campanha'] = $campanha;
	
		return $campanha_e_oferta;
	}
	
	
	//##########################

	
	
}