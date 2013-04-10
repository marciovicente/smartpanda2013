<?php
class NovaofertaController extends Zend_Controller_Action
{
	public function  indexAction() {
		$model_categorias = $this->_getModelCategorias();
		$categorias = $model_categorias->getCategoriasAtivas();
		
		$html = '';
		foreach($categorias as $categoria) {
			if($categoria['id'] == 17)
				$html .= '<option value="'.$categoria['id'].'" selected="selected">'.$categoria['nome'].'</option>';
			else
				$html .= '<option value="'.$categoria['id'].'">'.$categoria['nome'].'</option>';
		}
		
		$this->view->categorias = $html;
	}
	
	public function init(){
		$this->view->headScript()->appendFile('js/novaoferta.js');
	}
	
	public function preDispatch() {
		$model_usuario = $this->_getModelUsuarios();
		$model_estabelecimento = $this->_getModelEstabelecimentos();
		$model_assinatura = $this->_getModelAssinaturas();
		$model_plano = $this->_getModelPlanos();
		$model_oferta = $this->_getModelOfertas();
		
		$usuario = $model_usuario->loadUsuarioLogado();
		
		if(!$model_estabelecimento->temEstabelecimentoContratado($usuario['id'])) {
			return $this->_response->setRedirect('ofertascadastradas')->sendResponse();
		}
		
// 		$estabelecimento = $model_estabelecimento->getByUsuario($usuario['id']);
// 		$assinaturas = $model_assinatura->getAssinaturasByEstabelecimento($estabelecimento['id']);
		
// 		$maxAnuncios = 0;
// 		if($assinaturas) {
// 			foreach($assinaturas as $value) {
// 				if($value['id_plano'] != 4) { //se nao for o plano do Smartpanda TV
// 					$plano = $model_plano->fetchEntry($value['id_plano']);
// 					if($plano['max_anuncios'] > $maxAnuncios) $maxAnuncios = $plano['max_anuncios'];
// 				}
// 			}
// 		}
// 		$anunciosAtivos = $model_oferta->getQtdOfertas($estabelecimento['id']);
	
// 		if($anunciosAtivos >= $maxAnuncios) {
// 			return $this->_response->setRedirect('ofertascadastradas')->sendResponse();
// 		}
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
	
	protected function _getModelCategorias() {
		require_once APPLICATION_PATH . '/models/Categorias.php';
		$this->_model = new Model_Categorias();
	
		return $this->_model;
	}
	
	protected function _getModelEstabelecimentos() {
		require_once APPLICATION_PATH . '/models/Estabelecimentos.php';
		$this->_model = new Model_Estabelecimentos();
	
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
	
	protected function salvarofertaAction() {
		$model_usuario = $this->_getModelUsuarios();
		$model_estabelecimento = $this->_getModelEstabelecimentos();
		$usuario = $model_usuario->loadUsuarioLogado();
		$user = $usuario['id_facebook'];	
		$model_ofertas = $this->_getModelOfertas();
		$model_campanhasConfigs = $this->_getModelCampanhasConfigs();
		$model_campanhas = $this->_getModelCampanhas();
	
		$request = $this->getRequest();
		//Verifica se foi enviado via POST
		if($this->getRequest()->isPost()) {
			$data = $request->getPost();

			$data['id_facebook'] = $user;
			$data['id_usuario'] = $usuario['id'];
			$estabelecimento = $model_estabelecimento->getByUsuario($usuario['id']);
			$data['id_estabelecimento'] = $estabelecimento['id'];
			unset($data['MAX_FILE_SIZE']);


			if(($data['titulo'] == "") or ($data['nome'] == "") or ($data['texto']) == "") {
				$msg['mensagem'] = "Oferta não cadastrada (Pelo menos um campo obrigatório está vazio).";
				$msg[] = $msg;
				$this->_helper->json($msg);
			}
			
			
			$data['imagem'] = "imagemTmp";
			
			if($data['from'] != "") {
				try {
					$data_min = new DateTime(str_replace('/','-',$data['from']));
					$data_min = $data_min->format('Y-m-d');
				} catch (Exception $e) {
					$data_min = null;
				}
			} else {$data_min = null;}
			
			if($data['to'] != "") {
				try {
					$data_max = new DateTime(str_replace('/','-',$data['to']));
					$data_max = $data_max->format('Y-m-d');
				} catch (Exception $e) {
					$data_max = null;
				}
			} else {$data_max = null;}
			
			if(isset($data['validadeVisivel'])) {
				$campanhaConfig['validade_visivel'] = 1;
				unset($data['validadeVisivel']);
			} else {
				$campanhaConfig['validade_visivel'] = 0;
			}
			
			if(isset($data['maior_idade'])) {
				$campanhaConfig['maior_idade'] = 1;
				unset($data['maior_idade']);
			} else {
				$campanhaConfig['maior_idade'] = 0;
			}
			
			$campanhaConfig['genero'] = $data['genero'];
			$campanhaConfig['idade_max'] = $data['idade_max'];
			$campanhaConfig['idade_min'] = $data['idade_min'];
			$campanhaConfig['data_min'] = $data_min;
			$campanhaConfig['data_max'] = $data_max;
			$campanhaConfig['categoria'] = $data['categoria'];
			$id_campanhaConfig_nova = $model_campanhasConfigs->save($campanhaConfig);
			unset($data['genero']);
			unset($data['idade_max']);
			unset($data['idade_min']);
			unset($data['from']);
			unset($data['to']);
			unset($data['categoria']);

			
			$id_oferta_nova = $model_ofertas->save($data);
			
			$campanha['id_config'] = $id_campanhaConfig_nova;
			$campanha['id_oferta'] = $id_oferta_nova;
			$model_campanhas->save($campanha);
			
			
			$upload = new Zend_File_Transfer_Adapter_Http();
			$upload->setDestination(APPLICATION_PATH.'/../images/ofertas/temp');
			
// 			$file = $upload->getFileInfo();

				
			if($upload->isUploaded()){
				$arquivosPermitidos = array("jpg", "jpeg", "png");
				$filename = strtolower($upload->getFileName(null,FALSE));
				$exts = split("[/\\.]", $filename) ;
				$n = count($exts)-1;
				$arquivoTipo = $exts[$n];
				$upload->setOptions(array('useByteString' => false));
				$arquivoTamanho = $upload->getFileSize();
				
				if((in_array($arquivoTipo,$arquivosPermitidos)) and ($arquivoTamanho <= 5242880)) {
					$upload->addFilter('Rename', APPLICATION_PATH.'/../images/ofertas/temp/'.$id_oferta_nova.'.jpg');
					$upload->receive();
					$arquivoNome = $upload->getFileName(null,FALSE);
					$model_ofertas->setImagem($id_oferta_nova, $arquivoNome);

					WideImage::load(APPLICATION_PATH.'/../images/ofertas/temp/'.$id_oferta_nova.'.jpg')->resize(150, 150)->crop('center','center',75,75)->saveToFile(APPLICATION_PATH.'/../images/ofertas/thumbs/'.$id_oferta_nova.'.jpg',75);
					WideImage::load(APPLICATION_PATH.'/../images/ofertas/temp/'.$id_oferta_nova.'.jpg')->resize(675, null)->crop('center','center',670,210)->saveToFile(APPLICATION_PATH.'/../images/ofertas/banners/'.$id_oferta_nova.'.jpg',75);
					WideImage::load(APPLICATION_PATH.'/../images/ofertas/temp/'.$id_oferta_nova.'.jpg')->resizeDown(1500, 1500)->saveToFile(APPLICATION_PATH.'/../images/ofertas/'.$id_oferta_nova.'.jpg',75);
					unlink(APPLICATION_PATH.'/../images/ofertas/temp/'.$id_oferta_nova.'.jpg');
				}
			}
			
			
			$this->_response->setRedirect("../ofertascadastradas")->sendResponse();
			
// 			$msg['mensagem'] = "Oferta cadastrada com sucesso.";
// 			$msg[] = $msg;
// 			$this->_helper->json($msg);
			
			
		}
	
	}
	
}