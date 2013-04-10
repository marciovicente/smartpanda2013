<?php
class EditarController extends Zend_Controller_Action
{
	public function  indexAction() {
		$request = $this->getRequest();
		$model_usuario = $this->_getModelUsuarios();
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
				
			$oferta_lojista = $model_usuario->getUsuarioByIDfb($oferta['id_facebook']);
		
			if(($oferta['id_facebook'] == $user) or ($model_usuario->pertenceAoShopping($oferta_lojista['id'], $usuario['id']))) {
				$campanha_e_oferta = array();
				$campanha_da_oferta = $model_campanhas->getCampanhas($oferta['id']);
				$campanha_da_oferta = $campanha_da_oferta[0];
		
				
				$model_categorias = $this->_getModelCategorias();
				$categorias = $model_categorias->getCategoriasAtivas();
				$model_configs = $this->_getModelCampanhasConfigs();
				$configs = $model_configs->fetchEntry($campanha_da_oferta['id_config']);
				
				$html = '';
				foreach($categorias as $categoria) {
					if($categoria['id'] == $configs['categoria'])
					$html .= '<option value="'.$categoria['id'].'" selected="selected">'.$categoria['nome'].'</option>';
					else
					$html .= '<option value="'.$categoria['id'].'">'.$categoria['nome'].'</option>';
				}
				
				$this->view->categorias = $html;
		
				$this->view->id_oferta = $oferta['id'];
				$this->view->nome = $oferta['nome'];
				$this->view->titulo = $oferta['titulo'];
				$this->view->imagem = 'images/ofertas/'.$oferta['imagem'];
				$this->view->texto = $oferta['texto'];
		
		
				switch ($configs['genero']) {
					case 'm': $this->view->genero = "Masculino";
					break;
					case 'f': $this->view->genero = "Feminino";
					break;
					default: $this->view->genero = "Ambos";
					break;
				}
				if($configs['idade_min'] > 0) $this->view->idade_min = $configs['idade_min'];
				else $this->view->idade_min = "";
				if($configs['idade_min'] > 0) $this->view->idade_max = $configs['idade_max'];
				else $this->view->idade_max = "";
		
				$this->view->data_min = "";
				$this->view->data_max = "";
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
		$this->view->headScript()->appendFile('js/novaoferta.js');
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
	
	protected function salvarofertaAction() {
		$model_usuario = $this->_getModelUsuarios();
		$usuario = $model_usuario->loadUsuarioLogado();
		$user = $usuario['id_facebook'];	
		$model_ofertas = $this->_getModelOfertas();
		$model_campanhasConfigs = $this->_getModelCampanhasConfigs();
		$model_campanhas = $this->_getModelCampanhas();
	
		$request = $this->getRequest();
		//Verifica se foi enviado via GET
		if($this->getRequest()->isPost()) {
			$data = $request->getPost();

			$data['id_facebook'] = $user;
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
			$upload->setDestination(APPLICATION_PATH.'/../images/ofertas');
			
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
					$upload->addFilter('Rename', APPLICATION_PATH.'/../images/ofertas/'.$id_oferta_nova.'.jpg');
					$upload->receive();
					$arquivoNome = $upload->getFileName(null,FALSE);
					$model_ofertas->setImagem($id_oferta_nova, $arquivoNome);

					WideImage::load(APPLICATION_PATH.'/../images/ofertas/'.$id_oferta_nova.'.jpg')->resize(150, 150)->crop('center','center',75,75)->saveToFile(APPLICATION_PATH.'/../images/ofertas/thumbs/'.$id_oferta_nova.'.jpg',75);
					WideImage::load(APPLICATION_PATH.'/../images/ofertas/'.$id_oferta_nova.'.jpg')->resizeDown(1500, 1500)->saveToFile(APPLICATION_PATH.'/../images/ofertas/'.$id_oferta_nova.'.jpg',75);
				}
			}
			
			
			$this->_response->setRedirect("../ofertascadastradas")->sendResponse();
			
// 			$msg['mensagem'] = "Oferta cadastrada com sucesso.";
// 			$msg[] = $msg;
// 			$this->_helper->json($msg);
			
			
		}
	
	}
	
}