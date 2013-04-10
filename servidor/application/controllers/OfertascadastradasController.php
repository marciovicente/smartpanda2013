<?php
class OfertascadastradasController extends Zend_Controller_Action
{
	public function  indexAction() {
		$model_usuario = $this->_getModelUsuarios();
		$model_estabelecimento = $this->_getModelEstabelecimentos();
		$model_assinatura = $this->_getModelAssinaturas();
		$model_plano = $this->_getModelPlanos();
		$model_oferta = $this->_getModelOfertas();
		
		$usuario = $model_usuario->loadUsuarioLogado();
// 		$user_profile = $model_usuario->getUserProfile();

		
		if(isset($_GET['fimpromocao']))
			$this->view->msgFimPromocao = 'Infelizmente a promoção terminou, mas você poderá usar o serviço do plano Basic por 1 mês sem pagar NADA.';
		
		if($model_estabelecimento->temEstabelecimentoContratado($usuario['id'])) {
			$estabelecimento = $model_estabelecimento->getByUsuario($usuario['id']);
			$assinaturas = $model_assinatura->getAssinaturasByEstabelecimento($estabelecimento['id']);
			
			$maxAnuncios = 0;
			if($assinaturas) {
				foreach($assinaturas as $value) {
					if($value['id_plano'] != 4) {
						//se nao for o plano do Smartpanda TV
						$plano = $model_plano->fetchEntry($value['id_plano']);
						if($plano['max_anuncios'] > $maxAnuncios) $maxAnuncios = $plano['max_anuncios'];
					}
				}
			}
			$anunciosAtivos = $model_oferta->getQtdOfertas($estabelecimento['id']);
	
			$this->view->script .= 'maxAnuncios = '.$maxAnuncios.';';
			$this->view->script .= 'anunciosAtivos = '.$anunciosAtivos.';';
			
			$this->view->msgQtdAnuncios = $anunciosAtivos.'/'.$maxAnuncios.' anúncios ativos';
			
			if($anunciosAtivos < $maxAnuncios)
				$this->view->botao = '<a href="novaoferta" class="btn btn-success bt-avancar">Novo Anúncio</a>';
			else {
				$this->view->botao = '<a href="novaoferta" class="btn btn-success bt-avancar">Novo Anúncio</a>';
				$this->view->msgQtdAnuncios = 'Número máximo de anúncios atingido. Para ativar um novo anúncio será necessário interromper um primeiro.';
			}
		}
		
		
		if($usuario['tipo'] == 2) { //SE FOR LOJISTA
// 			if($usuario['id_shopping'] == null) { //E SEM SHOPPING
// 				$this->view->botao .= '<a id="btEntrarShopping" href="" onclick="event.preventDefault();entrarShopping();" class="btn btn-success bt-avancar">Participar de um Shopping</a>';
// 			} 
			$shopping = $model_estabelecimento->fetchEntry($estabelecimento['id_shopping']);
			$id_shopping = $shopping['id'];
			
			$nomeShopping = $shopping['nome_fantasia'];
			
			$this->view->shoppingFb = 'Membro do: <a href="#">'.$nomeShopping.'</a>';

		}
		
		if($usuario['tipo'] == 3) { //SE FOR ADMIN
			$this->view->botao .= '<a href="admin" class="btn btn-success bt-avancar">Administrar Usuários</a>';
		}
		
		if($usuario['tipo'] == 4) { //SE FOR SHOPPING
			$this->view->botao .= ' <a href="shopping" class="btn btn-success bt-avancar">Administrar Lojistas</a>';
			$this->view->botao .= ' <a href="" onclick="event.preventDefault();carregarOfertasLojistas();" class="btn btn-success bt-avancar">Exibir Anúncios dos Lojistas</a>';
		}
		
		if(($usuario['tipo'] == 2) or ($usuario['tipo'] == 4)) { //SE FOR LOJISTA OU SHOPPING
			$nome_fantasia = $model_estabelecimento->getNome($estabelecimento['id']);
// 			$this->view->botao .= ' <a href="../../fullscreen/index?id_lojista='.$usuario['id'].'" class="btn btn-success bt-avancar" target="_blank">Vitrine de Anúncios</a>';
			$this->view->opcoes = '';
			if(($estabelecimento['imagem']) and ($estabelecimento['imagem'] != "")) {
				$this->view->temImagem = true;
				$this->view->opcoes = '<img alt="Logo" width="75" height="75" src="images/estabelecimentos/thumbs/'.$estabelecimento['imagem'].'"> ';
			}
			$this->view->opcoes .= 	'<input type="text" size="70" id="nome" name="nome" value="'.$nome_fantasia.'" placeholder="Nome do Estabelecimento" title="Nome exibido aos clientes" maxlength="30" required class="dica"> '
									.'<button type="submit" onclick="alterarNome()" class="btn btn-success bt-avancar">Salvar</button>'
									.' <a href="#modalalterarimagens" class="btn btn-success bt-avancar" data-toggle="modal">Alterar Imagens</a>';
		}
		
		if(!$model_usuario->temLoginSenha($usuario['id'])) {
			$this->view->botao .= ' <a href="#modallogin" class="btn btn-success bt-avancar" data-toggle="modal">Criar login sem Facebook</a>';
			$this->view->script .= '$("#modallogin").modal("show")';
		} else {
			$this->view->botao .= ' <a href="#modalalterarsenha" class="btn btn-success bt-avancar" data-toggle="modal">Alterar Senha</a>';
			if((!$model_estabelecimento->temEstabelecimentoContratado($usuario['id'])) and (($usuario['tipo'] == 2) or ($usuario['tipo'] == 4))) {
				$this->view->script .= 'id_shopping = '.$shopping['id'].';';
				$this->view->nome_fantasia = $usuario['nome'];
				if(isset($usuario['email'])) $this->view->email = $usuario['email'];
				$this->view->botao .= ' <a href="#modalcompletarcadastro" class="btn btn-success bt-avancar" data-toggle="modal">Completar Cadastro</a>';
				$this->view->script .= 'carregarLojas();$("#modalcompletarcadastro").modal("show");';
			}
		}
		

	}
	
	public function init(){
		$this->view->headScript()->appendFile('js/ofertascadastradas.js');
	}
	
	public function preDispatch() {
		$model_usuario = $this->_getModelUsuarios();
		$usuario = $model_usuario->loadUsuarioLogado();
// 		$user_profile = $model_usuario->getUserProfile();
// 		$usuario = $model_usuario->getUsuario();
	
		if($usuario['tipo'] < 2) {
			$webapp = Zend_Registry::get('configuration')->webapp;
			return $this->_response->setRedirect($webapp)->sendResponse();
		}
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
	
	protected function _getModelConvites() {
		require_once APPLICATION_PATH . '/models/Convites.php';
		$this->_model = new Model_Convites();
	
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
	
	protected function setnomeAction() {
		$model_usuario = $this->_getModelUsuarios();
		$model_estabelecimento = $this->_getModelEstabelecimentos();
		
		$usuario = $model_usuario->loadUsuarioLogado();
		$estabelecimento = $model_estabelecimento->getByUsuario($usuario['id']);

		
		$request = $this->getRequest();
		//Verifica se foi enviado via GET
		if($this->getRequest()->isGet()) {
			$data = $request->getQuery();
			
			$novoNome = $data['nome'];
			
			if($model_estabelecimento->setNome($estabelecimento['id'], $novoNome)) {
				$msg['sucesso'] = true;
				$msg['mensagem'] = 'Nome alterado com sucesso.';
				
			} else {
				$msg['sucesso'] = false;
				$msg['mensagem'] = 'Erro ao tentar alterar nomes.';
			}
			
			$msg[] = $msg;
			$this->_helper->json($msg);
		}
	}
	
	protected function getlistadecampanhasAction() {
		$model_usuario = $this->_getModelUsuarios();
		$model_estabelecimento = $this->_getModelEstabelecimentos();
		
		$usuario = $model_usuario->loadUsuarioLogado();
		$user = $usuario['id_facebook'];
		$request = $this->getRequest();
		//Verifica se foi enviado via GET
		if($this->getRequest()->isGet()) {
			$id_facebook = $user;
			$model_campanhas = $this->_getModelCampanhas();
			$model_ofertas = $this->_getModelOfertas();
	
			if($usuario['tipo'] == 3) { //Se for Admin pega todas as ofertas ativas
				$ofertas = $model_ofertas->getAtivos();
			} else {
				$estabelecimento = $model_estabelecimento->getByUsuario($usuario['id']);
				$ofertas = $model_ofertas->getOfertasByEstabelecimento($estabelecimento['id']);
			}
	
			$dados = array();
			foreach($ofertas as $value) {
				$campanha_e_oferta = $this->loadCampanhaEoferta($value);				
				$dados[] = $campanha_e_oferta;
			}
	
			$this->_helper->json($dados);
	
		}
	}
	
	protected function getcampanhasdoslojistasAction() {
		$model_usuario = $this->_getModelUsuarios();
		$model_estabelecimento = $this->_getModelEstabelecimentos();
		
		$usuario = $model_usuario->loadUsuarioLogado();
		$user = $usuario['id_facebook'];
		$request = $this->getRequest();
		//Verifica se foi enviado via GET
		if(($this->getRequest()->isGet()) and ($usuario['tipo'] == 4)) {
			$id_shopping = $usuario['id'];
			
			$model_ofertas = $this->_getModelOfertas();
			
			$lojistas = $model_usuario->getLojistasByShopping($id_shopping);
			
			$dados = array();
			foreach ($lojistas as $lojista) {
				$estabelecimento = $model_estabelecimento->getByUsuario($lojista['id']);
				foreach($ofertas as $value) {
					$ofertas = $model_ofertas->getOfertasByEstabelecimento($estabelecimento['id']);
					$campanha_e_oferta = $this->loadCampanhaEoferta($value);
					$campanha = $campanha_e_oferta['campanha'];
					if($campanha->ativo == 1)
						$dados[] = $campanha_e_oferta;
				}
			}
			
			$this->_helper->json($dados);
		}
	}
	
	protected function loadCampanhaEoferta($value) {
		require_once APPLICATION_PATH . '/models/Campanha.php';
		
		$model_campanhas = $this->_getModelCampanhas();
		$model_estabelecimento = $this->_getModelEstabelecimentos();
		
		if($value['id_estabelecimento'])
			$estabelecimento = $model_estabelecimento->fetchEntry($value['id_estabelecimento']);
		else
			$estabelecimento = $model_estabelecimento->getByUsuario($value['id_usuario']);
		
		$campanha_e_oferta = array();

		$campanha_da_oferta = $model_campanhas->getCampanhas($value['id']);
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
		
		$campanha_e_oferta['oferta'] = $value;
		$campanha_e_oferta['campanha'] = $campanha;
		$campanha_e_oferta['lojista'] = $estabelecimento['nome_fantasia'];
		
		return $campanha_e_oferta;
	}
	
	protected function aceitarconviteAction() {
		$model_usuario = $this->_getModelUsuarios();
		$usuario = $model_usuario->loadUsuarioLogado();
		$user = $usuario['id_facebook'];
		$request = $this->getRequest();
		//Verifica se foi enviado via GET
		if(($this->getRequest()->isGet()) and ($usuario['tipo'] == 2) and ($usuario['id_shopping'] == null)) {
			$data = $request->getQuery();
			$model_convite = $this->_getModelConvites();
			$codigo = $data['codigo'];
			$convite = $model_convite->getConviteByCodigo($codigo);
			if($convite) {
				$id_convite = $convite['id'];
				$id_lojista = $usuario['id'];
				
				if($model_convite->conviteDisponivel($id_convite)) {
					$model_convite->aceitarConvite($id_convite, $id_lojista);
					$msg['sucesso'] = true;
					$msg['mensagem'] = 'O convite foi processado com sucesso.';
					$msg[] = $msg;
					$this->_helper->json($msg);
	
				} else {
					$msg['sucesso'] = false;
					$msg['mensagem'] = 'O convite não está disponível.';
					$msg[] = $msg;
					$this->_helper->json($msg);
				}
			} else {
				$msg['mensagem'] = 'O convite não existe.';
				$msg[] = $msg;
				$this->_helper->json($msg);
			}
			
		} else {
			$msg['sucesso'] = false;
			$msg['mensagem'] = 'O convite não pode ser processado.';
			$msg[] = $msg;
			$this->_helper->json($msg);
		}
		
	}
	
	protected function salvarimagemAction() {
		$model_usuario = $this->_getModelUsuarios();
		$model_estabelecimento = $this->_getModelEstabelecimentos();
		$usuario = $model_usuario->loadUsuarioLogado();
		
		$request = $this->getRequest();
		//Verifica se foi enviado via POST
		if($this->getRequest()->isPost()) {
			$data = $request->getPost();
			
			$estabelecimento = $model_estabelecimento->getByUsuario($usuario['id']);
			$id_estabelecimento = $estabelecimento['id'];
			
			$upload = new Zend_File_Transfer_Adapter_Http();
			$upload->setDestination(APPLICATION_PATH.'/../images/estabelecimentos/temp');
	
			if($upload->isUploaded()){
				$arquivosPermitidos = array("jpg", "jpeg", "png");
				$filename = strtolower($upload->getFileName(null,FALSE));
				$exts = split("[/\\.]", $filename) ;
				$n = count($exts)-1;
				$arquivoTipo = $exts[$n];
				$upload->setOptions(array('useByteString' => false));
				$arquivoTamanho = $upload->getFileSize();
			
				if((in_array($arquivoTipo,$arquivosPermitidos)) and ($arquivoTamanho <= 5242880)) {
					$upload->addFilter('Rename', APPLICATION_PATH.'/../images/estabelecimentos/temp/'.$id_estabelecimento.'.jpg');
					$upload->receive();
					$arquivoNome = $upload->getFileName(null,FALSE);
					$model_estabelecimento->setImagem($id_estabelecimento, $arquivoNome);
			
					WideImage::load(APPLICATION_PATH.'/../images/estabelecimentos/temp/'.$id_estabelecimento.'.jpg')->resize(150, 150)->crop('center','center',75,75)->saveToFile(APPLICATION_PATH.'/../images/estabelecimentos/thumbs/'.$id_estabelecimento.'.jpg',75);
					WideImage::load(APPLICATION_PATH.'/../images/estabelecimentos/temp/'.$id_estabelecimento.'.jpg')->resize(675, null)->crop('center','center',670,210)->saveToFile(APPLICATION_PATH.'/../images/estabelecimentos/banners/'.$id_estabelecimento.'.jpg',75);
					WideImage::load(APPLICATION_PATH.'/../images/estabelecimentos/temp/'.$id_estabelecimento.'.jpg')->resizeDown(1500, 1500)->saveToFile(APPLICATION_PATH.'/../images/estabelecimentos/'.$id_estabelecimento.'.jpg',75);
					unlink(APPLICATION_PATH.'/../images/estabelecimentos/temp/'.$id_estabelecimento.'.jpg');
				}
			}
			$this->_response->setRedirect("../ofertascadastradas")->sendResponse();
			
		}
	}
	
	protected function salvarlogoAction() {
		$model_usuario = $this->_getModelUsuarios();
		$model_estabelecimento = $this->_getModelEstabelecimentos();
		$usuario = $model_usuario->loadUsuarioLogado();
	
		$request = $this->getRequest();
		//Verifica se foi enviado via POST
		if($this->getRequest()->isPost()) {
			$data = $request->getPost();
				
			$estabelecimento = $model_estabelecimento->getByUsuario($usuario['id']);
			$id_estabelecimento = $estabelecimento['id'];
				
			$upload = new Zend_File_Transfer_Adapter_Http();
			$upload->setDestination(APPLICATION_PATH.'/../images/estabelecimentos/temp');
	
			if($upload->isUploaded()){
				$arquivosPermitidos = array("jpg", "jpeg", "png");
				$filename = strtolower($upload->getFileName(null,FALSE));
				$exts = split("[/\\.]", $filename) ;
				$n = count($exts)-1;
				$arquivoTipo = $exts[$n];
				$upload->setOptions(array('useByteString' => false));
				$arquivoTamanho = $upload->getFileSize();
					
				if((in_array($arquivoTipo,$arquivosPermitidos)) and ($arquivoTamanho <= 5242880)) {
					$upload->addFilter('Rename', APPLICATION_PATH.'/../images/estabelecimentos/temp/'.$id_estabelecimento.'.jpg');
					$upload->receive();
					$arquivoNome = $upload->getFileName(null,FALSE);
					$model_estabelecimento->setImagem($id_estabelecimento, $arquivoNome);
						
					WideImage::load(APPLICATION_PATH.'/../images/estabelecimentos/temp/'.$id_estabelecimento.'.jpg')->resize(75, 75)->saveToFile(APPLICATION_PATH.'/../images/estabelecimentos/thumbs/'.$id_estabelecimento.'.jpg',75);
					unlink(APPLICATION_PATH.'/../images/estabelecimentos/temp/'.$id_estabelecimento.'.jpg');
				}
			}
			$this->_response->setRedirect("../ofertascadastradas")->sendResponse();
				
		}
	}
}