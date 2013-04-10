<?php
class StatusofertaController extends Zend_Controller_Action
{
	public function  indexAction() {
		$request = $this->getRequest();
		$model_usuario = $this->_getModelUsuarios();
		$model_estabelecimento = $this->_getModelEstabelecimentos();
		$model_logCampanhaUsuario = $this->_getModelLogCampanhasUsuarios();
		
		$model_usuario->loadUsuarioLogado();
		$user_profile = $model_usuario->getUserProfile();
		$usuario = $model_usuario->loadUsuarioLogado();
		$user = $usuario['id_facebook'];
		
		//Verifica se foi enviado via GET
		if($this->getRequest()->isGet()) {
			$data = $request->getQuery();
			$oferta_id = $data['id'];
			$model_campanhas = $this->_getModelCampanhas();
			$model_ofertas = $this->_getModelOfertas();
		
			$oferta = $model_ofertas->fetchEntry($oferta_id);
			
			$oferta_lojista = $model_usuario->fetchEntry($oferta['id_usuario']);
			$estabelecimento_lojista = $model_estabelecimento->getByUsuario($oferta_lojista['id']);

			if(($usuario['tipo'] == 3) or ($oferta['id_usuario'] == $usuario['id']) or ($model_usuario->pertenceAoShopping($oferta_lojista['id'], $usuario['id']))) {
				$campanha_e_oferta = array();
				$campanha_da_oferta = $model_campanhas->getCampanhas($oferta['id']);
				$campanha_da_oferta = $campanha_da_oferta[0];
	
				$status = "";
				$status_img = "";
				switch ($campanha_da_oferta['ativo']) {
					case '1':
						$status = 'Rodando';
						$status_img = "on.png";
						$botoes = '<a href="" onclick="event.preventDefault();enviarPausarOferta('.$oferta['id'].');" class="btn btn-success bt-avancar">Pausar</a>';
						break;
					case '0':
						$status = 'Em Pausa';
						$status_img = "off.png";
						$botoes = '<a href="" onclick="event.preventDefault();enviarAtivarOferta('.$oferta['id'].');" class="btn btn-success bt-avancar">Ativar</a>';
						break;
					default:
						$status = "Desativada";
						$status_img = "off.png";
				}
				
				$botoes .= ' <a href="" onclick="event.preventDefault();desativarOferta('.$oferta['id'].');" class="btn btn-success bt-avancar">Remover</a>';
				
				$webapp = Zend_Registry::get('configuration')->webapp;
				
				$totalVisitantes = $model_logCampanhaUsuario->getTotalDistinctUser($campanha_da_oferta['id'], 'visualizada');
				$totalUsuariosReceberam = $model_logCampanhaUsuario->getTotalDistinctUser($campanha_da_oferta['id'], 'entregue');
// 				$totalVisualizacoes = $model_logCampanhaUsuario->getTotalAcao($campanha_da_oferta['id'], 'visualizada');
				
				$this->view->id_oferta = $oferta['id'];
				$this->view->nome = $oferta['nome'];
				$this->view->titulo = $oferta['titulo'];
				$this->view->imagem = 'images/ofertas/'.$oferta['imagem'];
				$this->view->texto = $oferta['texto'];
				$this->view->status = $status;
				$this->view->status_img = $status_img;
				$this->view->botoes = $botoes;
				$this->view->curtiram = $campanha_da_oferta['curtiram'];
				$this->view->nao_curtiram = $campanha_da_oferta['nao_curtiram'];
				$this->view->entregues = $totalUsuariosReceberam;
				$this->view->entregas = $campanha_da_oferta['entregues'];
				$this->view->maximo = $campanha_da_oferta['maximo'];
				$this->view->nao_curtiram = $campanha_da_oferta['nao_curtiram'];
				$this->view->visualizadas = $totalVisitantes;
				$this->view->visualizacoes = $campanha_da_oferta['visualizadas'];
				$this->view->creditosDisponiveis = $usuario['creditos'];				
				$this->view->webapp = $webapp."/detalhes?id=".$oferta['id']."&fb_lojista=".$oferta['id_facebook'];
				$this->view->lojista = $estabelecimento_lojista['nome_fantasia'];
				
				$model_configs = $this->_getModelCampanhasConfigs();
				$configs = $model_configs->fetchEntry($campanha_da_oferta['id_config']);
				
				switch ($configs['genero']) {
					case 'm': $this->view->genero = "Masculino";
					break;
					case 'f': $this->view->genero = "Feminino";
					break;
					default: $this->view->genero = "Ambos";
					break;
				}
				if($configs['idade_min'] > 0) $this->view->idade_min = $configs['idade_min']." anos";
				else $this->view->idade_min = "Sem Limite";
				if($configs['idade_min'] > 0) $this->view->idade_max = $configs['idade_max']." anos";
				else $this->view->idade_max = "Sem Limite";
				
				$this->view->data_min = "N/D";
				$this->view->data_max = "N/D";
				if($configs['data_min']) $this->view->data_min = date('d/m/Y',strtotime($configs['data_min']));
				if($configs['data_max']) $this->view->data_max = date('d/m/Y',strtotime($configs['data_max']));
				
			} else {
				$this->view->nome = "Acesso Negado.";
			}

		
		} else {
			$this->view->nome = "Oferta inexistente";
		}

	}
	
	public function init(){
		$this->view->headScript()->appendFile('js/statusoferta.js');
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
	
	protected function getofertaAction() {
		$request = $this->getRequest();
		//Verifica se foi enviado via GET
		if($this->getRequest()->isGet()) {
			$data = $request->getQuery();
			$oferta_id = $data['id'];
			$model_usuario = $this->_getModelUsuarios();
			$model_campanhas = $this->_getModelCampanhas();
			$model_ofertas = $this->_getModelOfertas();
	
			$oferta = $model_ofertas->fetchEntry($oferta_id);
	
			require_once APPLICATION_PATH . '/models/Campanha.php';
	
			$dados = array();
			$campanha_e_oferta = array();
			$campanha_da_oferta = $model_campanhas->getCampanhas($oferta['id']);
			$campanha_da_oferta = $campanha_da_oferta[0];
			$campanha = new Campanha();
			$campanha->ativo = $campanha_da_oferta['ativo'];
			$campanha->curtiram = $campanha_da_oferta['curtiram'];
			$campanha->entregues = $campanha_da_oferta['entregues'];
			$campanha->id = $campanha_da_oferta['id'];
			$campanha->id_config = $campanha_da_oferta['id_config'];
			$campanha->id_oferta = $campanha_da_oferta['id_oferta'];
			$campanha->maximo = $campanha_da_oferta['maximo'];
			$campanha->nao_curtiram = $campanha_da_oferta['nao_curtiram'];
			$campanha->visualizadas = $campanha_da_oferta['visualizadas'];

			$campanha_e_oferta[0] = $oferta;
			$campanha_e_oferta[1] = $campanha;
			$dados[] = $campanha_e_oferta;
	
			$this->_helper->json($dados);
	
		}
	}
	
	protected function ativarcampanhaAction() {
		$model_usuario = $this->_getModelUsuarios();
		$model_estabelecimento = $this->_getModelEstabelecimentos();
		$model_assinatura = $this->_getModelAssinaturas();
		$model_plano = $this->_getModelPlanos();
		$model_oferta = $this->_getModelOfertas();
		
		$usuario = $model_usuario->loadUsuarioLogado();
		$user = $usuario['id_facebook'];
		
		$request = $this->getRequest();
		//Verifica se foi enviado via GET
		if($this->getRequest()->isGet()) {
			$data = $request->getQuery();
			$id_oferta = $data['id_oferta'];
// 			$creditos = $data['creditos'];

// 			If(($creditos > 0) and ($creditos <= $usuario['creditos'])) {
// 				$this->setStatusCampanha($id_oferta, 1, $creditos);
// 			} else {
// 				$msg['mensagem'] = "Quantidade de créditos inválida.";
// 			}

			if(!$model_estabelecimento->temEstabelecimentoContratado($usuario['id'])) {
				$msg['mensagem'] = "Complete suas informações antes de ativar um anúncio.";
				$msg[] = $msg;
				$this->_helper->json($msg);
			}
			
			$estabelecimento = $model_estabelecimento->getByUsuario($usuario['id']);
			$assinaturas = $model_assinatura->getAssinaturasByEstabelecimento($estabelecimento['id']);
			$maxAnuncios = 0;
			if($assinaturas) {
				foreach($assinaturas as $value) {
					if($value['id_plano'] != 4) { //se nao for o plano do Smartpanda TV
						$plano = $model_plano->fetchEntry($value['id_plano']);
						if($plano['max_anuncios'] > $maxAnuncios) $maxAnuncios = $plano['max_anuncios'];
					}
				}
			}
			$anunciosAtivos = $model_oferta->getQtdOfertas($estabelecimento['id']);
	
			if($anunciosAtivos >= $maxAnuncios) {
				$msg['mensagem'] = "Número máximo de anúncios atingido.";
				$msg[] = $msg;
				$this->_helper->json($msg);
			}
			
			$this->setStatusCampanha($id_oferta, 1, 0);
			
			
// 			$this->_response->setRedirect("../ofertascadastradas")->sendResponse();
		}
		
		
	}
	
	protected function pausarcampanhaAction() {
		$request = $this->getRequest();
		//Verifica se foi enviado via GET
		if($this->getRequest()->isGet()) {
			$data = $request->getQuery();
			$id_oferta = $data['id_oferta'];
			
			$this->setStatusCampanha($id_oferta, 0, 0);
		}
	
	}
	
	protected function desativarcampanhaAction() {
		$request = $this->getRequest();
		//Verifica se foi enviado via GET
		if($this->getRequest()->isGet()) {
			$data = $request->getQuery();
			$id_oferta = $data['id_oferta'];
			
			$this->setStatusCampanha($id_oferta, -1, 0);
		}
	
	}
	
	protected function setStatusCampanha($id_oferta, $status, $creditos) {
		$model_usuario = $this->_getModelUsuarios();
		$model_estabelecimento = $this->_getModelEstabelecimentos();
		$model_campanhas = $this->_getModelCampanhas();
		$model_ofertas = $this->_getModelOfertas();
		$model_logcampanha = $this->_getModelLogCampanhas();
	
		$usuario = $model_usuario->loadUsuarioLogado();
		$oferta = $model_ofertas->fetchEntry($id_oferta);
	
		if($oferta['id_usuario'] == $usuario['id']) {
			$campanha_da_oferta = $model_campanhas->getCampanhas($oferta['id']);
			$campanha_da_oferta = $campanha_da_oferta[0];
			
			if((!isset($oferta['id_estabelecimento'])) or ($oferta['id_estabelecimento'] == "")) {
				$estabelecimento = $model_estabelecimento->getByUsuario($usuario['id']);
				$model_ofertas->setEstabelecimento($oferta['id'], $estabelecimento['id']);
			}
			
			$model_campanhas->setStatusCampanha($campanha_da_oferta['id'], $status);
			if($status == 1)
				$model_logcampanha->startCampanha($campanha_da_oferta['id'], $usuario['id']);
			elseif (($status == 0) or ($status == -1))
				$model_logcampanha->endCampanha($campanha_da_oferta['id'], $usuario['id']);
			
			if($creditos > 0) $model_campanhas->setCreditos($campanha_da_oferta['id'], $creditos);
			$msg['sucesso'] = true;
			$msg['mensagem'] = "Status alterado com sucesso.";
		} else {
			$msg['mensagem'] = "Acesso negado.";
		}
				
		$msg[] = $msg;
		$this->_helper->json($msg);
// 		$this->_response->setRedirect("../ofertascadastradas")->sendResponse();

	}
	
}