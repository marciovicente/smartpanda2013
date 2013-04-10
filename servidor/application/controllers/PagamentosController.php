<?php
class PagamentosController extends Zend_Controller_Action
{
	public function  indexAction() {
		
	}
	
	public function init(){
// 		$this->view->headScript()->appendFile('js/pagamentos.js');
	}
	
	protected function _getModelUsuarios() {
		require_once APPLICATION_PATH . '/models/Usuarios.php';
		$this->_model = new Model_Usuarios();
	
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
	
	protected function _getModelPagamentos() {
		require_once APPLICATION_PATH . '/models/Pagamentos.php';
		$this->_model = new Model_Pagamentos();
	
		return $this->_model;
	}
	
	protected function _getModelPagamentos_Assinaturas() {
		require_once APPLICATION_PATH . '/models/Pagamentos_Assinaturas.php';
		$this->_model = new Model_Pagamentos_Assinaturas();
	
		return $this->_model;
	}
	
	protected function _getModelLogSistemas() {
		require_once APPLICATION_PATH . '/models/LogSistemas.php';
		$this->_model = new Model_LogSistemas();
	
		return $this->_model;
	}
	
	protected function gerarpagamentoAction() {
		$model_usuario = $this->_getModelUsuarios();
		$model_assinatura = $this->_getModelAssinaturas();
		$model_pagamento = $this->_getModelPagamentos();
		$model_pagamento_assinatura = $this->_getModelPagamentos_Assinaturas();
		$model_plano = $this->_getModelPlanos();
		
		$usuario = $model_usuario->loadUsuarioLogado();
		
		$request = $this->getRequest();
		//Verifica se foi enviado via GET
		if($this->getRequest()->isGet()) {
			
			$id_usuario = $usuario['id'];
			
			$assinaturas = $model_assinatura->getAssinaturasByUsuario($id_usuario); //Carregar vetor com assinaturas do usuario
			if(!$assinaturas) return $this->_response->setRedirect("cadastro/assinar")->sendResponse();
			
			$assinante = $model_usuario->fetchEntry($id_usuario);
			
			$data_atual = new DateTime();
			$dia = $data_atual->format('d');
			if($dia > 28) $dia = 1;
			
			$data_atual->modify('+1 month');
			$inicio = $data_atual->format(DateTime::W3C);
			$data_atual->modify('+1 year');
			$fim = $data_atual->format(DateTime::W3C);
			
			$diaPagamento = $dia; //Dia do pagamento (<29)
			$data_inicial = $inicio; //Data que comeca a ser cobrado (considerar periodo gratis)
			$data_final = $fim; //Data final da assinatura (1 ano apos inicio)
			
			$maximoPorMes = '200.00';
			$maximoPorAssinatura = '2400.00';
			
			$url = 'https://ws.pagseguro.uol.com.br/v2/checkout';
			
			//$data = 'email=seuemail@dominio.com.br&amp;token=95112EE828D94278BD394E91C4388F20&amp;currency=BRL&amp;itemId1=0001&amp;itemDescription1=Notebook Prata&amp;itemAmount1=24300.00&amp;itemQuantity1=1&amp;itemWeight1=1000&amp;itemId2=0002&amp;itemDescription2=Notebook Rosa&amp;itemAmount2=25600.00&amp;itemQuantity2=2&amp;itemWeight2=750&amp;reference=REF1234&amp;senderName=Jose Comprador&amp;senderAreaCode=11&amp;senderPhone=56273440&amp;senderEmail=comprador@uol.com.br&amp;shippingType=1&amp;shippingAddressStreet=Av. Brig. Faria Lima&amp;shippingAddressNumber=1384&amp;shippingAddressComplement=5o andar&amp;shippingAddressDistrict=Jardim Paulistano&amp;shippingAddressPostalCode=01452002&amp;shippingAddressCity=Sao Paulo&amp;shippingAddressState=SP&amp;shippingAddressCountry=BRA';
			/*
			 Caso utilizar o formato acima remova todo código abaixo até instrução $data = http_build_query($data);
			*/
			
			$data['email'] = 'drcbarboza@bambooss.com';
			$data['token'] = 'A442E448656C4A579F2C3DB72907625C';
			$data['currency'] = 'BRL';
			
			foreach($assinaturas as $key => $item) {
				if($item['promocao'])
					return $this->gerarPagamentoUnico($assinante,$assinaturas);
				
				if((!$item['fim']) and ($item['ativo'] == 0)) {
					$pagamento_aberto = $model_pagamento_assinatura->getPagamentoByAssinatura($item['id']);
					if($pagamento_aberto) {
					$code = $model_pagamento->getFieldById($pagamento_aberto['id_pagamento'], 'payment_code');
					$paymentLink = $model_pagamento->getFieldById($pagamento_aberto['id_pagamento'], 'paymentLink');
					
					if($paymentLink)
						return $this->_response->setRedirect($paymentLink)->sendResponse();
					if($code)
						return $this->_response->setRedirect("https://pagseguro.uol.com.br/v2/checkout/payment.html?code=".$code)->sendResponse();
					}
				}
			}
			
			$pagamento['status'] = 0;
			$id_pagamento = $model_pagamento->save($pagamento);
			
			$custos = 0;
			$descontos = 0;
			$planos_nomes = "";
			$qtd_planos = 0;
			foreach($assinaturas as $key => $item) {
				if((!$item['fim']) and ($item['ativo'] == 0)) {
					$qtd_planos++;
					$pos = $key+1;
					
					$plano = $model_plano->fetchEntry($item['id_plano']);
					
					$data['itemId'.$pos] = $item['id_plano'];
					$data['itemDescription'.$pos] = $plano['titulo'];
					$data['itemAmount'.$pos] = $item['preco'];
					$data['itemQuantity'.$pos] = '1';
					
					$planos_nomes .= $plano['titulo'].", ";
					
					$custos += $item['preco'];
					$descontos += $item['desconto'];
					
					$pagamento_assinatura['id_pagamento'] = $id_pagamento;
					$pagamento_assinatura['id_assinatura'] = $item['id'];
					$model_pagamento_assinatura->save($pagamento_assinatura);
// 					$assinatura_fim = $data_atual->format('Y-m-d H:i:s');
// 					$model_assinatura->setFieldById($item['id'], 'fim', $assinatura_fim);
				}
			}
			if($qtd_planos < 1) return $this->_response->setRedirect("ofertascadastradas")->sendResponse();
			
			$mensalidade = number_format(($custos - $descontos),2);
			
// 			$pos = 1;
// 			$data['itemId'.$pos] = 0;
// 			$data['itemDescription'.$pos] = 'Plano de Assinatura';
// 			$data['itemAmount'.$pos] = $mensalidade;
// 			$data['itemQuantity'.$pos] = '1';
			
			$data['preApprovalName'] = 'Assinatura Smartpanda';
			$data['preApprovalDetails'] = 'Valor cobrado mensalmente pelo(s) plano(s) contratado(s).';
			$data['preApprovalAmountPerPayment'] = $mensalidade;
			$data['preApprovalPeriod'] = 'MONTHLY';
			$data['preApprovalDayOfMonth'] = $diaPagamento;
// 			$data['preApprovalInitialDate' ] = '2015-01-17T19:20:30.45+01:00';
			$data['preApprovalInitialDate' ] = $data_inicial;
			$data['preApprovalFinalDate'] = $data_final;
			$data['preApprovalMaxAmountPerPeriod'] = $maximoPorMes;
			$data['preApprovalMaxTotalAmount'] = $maximoPorAssinatura;
			$data['reviewURL'] = 'https://smartpanda.com.br/servidor/cadastro/confirmarplano'; //Alterar esse endereco
			
			$data['reference'] = $id_pagamento;
			$data['senderName'] = $assinante['nome'];
			if(isset($assinante['email'])) $data['senderEmail'] = $assinante['email'];
			$data['shippingType'] = '3';
			if($descontos > 0) $data['extraAmount'] = number_format((0 - $descontos),2);
			$data['redirectURL'] = 'https://smartpanda.com.br/panda/servidor/'; //Alterar esse endereco
			
			$data = http_build_query($data);
			
// 			$this->_helper->json($data);
			
			$curl = curl_init($url);
			
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
			$xml= curl_exec($curl);
			
			if($xml == 'Unauthorized'){
				//Insira seu código de prevenção a erros
				$this->_helper->json($xml);
			
				header('Location: erro.php?tipo=autenticacao');
				exit;//Mantenha essa linha
			}
			curl_close($curl);
			
			$xml= simplexml_load_string($xml);
			if(count($xml -> error) > 0){
				//Insira seu código de tratamento de erro, talvez seja útil enviar os códigos de erros.
				$this->_helper->json($xml);
				
				header('Location: erro.php?tipo=dadosInvalidos');
				exit;
			}
			
// 			header('Location: https://pagseguro.uol.com.br/v2/checkout/payment.html?code=' . $xml -> code);
			if(($xml->code) and ($xml->code != "")) {
				$model_pagamento->setFieldById($id_pagamento, 'payment_code', $xml->code);
				return $this->_response->setRedirect("https://pagseguro.uol.com.br/v2/checkout/payment.html?code=".$xml->code)->sendResponse();
			} else {
				$resposta['msg'] = 'Erro: payment_code invalido.';
				$resposta['xml'] = $xml;
				
				$this->_helper->json($resposta);
			}
			
			
		}
	}
	
	protected function gerarPagamentoUnico($assinante, $assinaturas) {
		$model_usuario = $this->_getModelUsuarios();
		$model_assinatura = $this->_getModelAssinaturas();
		$model_pagamento = $this->_getModelPagamentos();
		$model_pagamento_assinatura = $this->_getModelPagamentos_Assinaturas();
		$model_plano = $this->_getModelPlanos();
		
		$data_atual = new DateTime();
		$dia = $data_atual->format('d');
		$diaPagamento = $dia;
		
		$url = 'https://ws.pagseguro.uol.com.br/v2/checkout';
		
		$data['email'] = 'drcbarboza@bambooss.com';
		$data['token'] = 'A442E448656C4A579F2C3DB72907625C';
		$data['currency'] = 'BRL';
		
		foreach($assinaturas as $key => $item) {
			if($item['ativo'] == 0) {
				$pagamento_aberto = $model_pagamento_assinatura->getPagamentoByAssinatura($item['id']);
				if($pagamento_aberto) {
					$code = $model_pagamento->getFieldById($pagamento_aberto['id_pagamento'], 'payment_code');
					$paymentLink = $model_pagamento->getFieldById($pagamento_aberto['id_pagamento'], 'paymentLink');
					
					if($paymentLink)
						return $this->_response->setRedirect($paymentLink)->sendResponse();
					if($code)
						return $this->_response->setRedirect("https://pagseguro.uol.com.br/v2/checkout/payment.html?code=".$code)->sendResponse();
				}
			}
		}
			
		$pagamento['status'] = 0;
		$id_pagamento = $model_pagamento->save($pagamento);
			
		$custos = 0;
		$descontos = 0;
		$planos_nomes = "";
		$qtd_planos = 0;
		foreach($assinaturas as $key => $item) {
			if(($item['promocao']) and ($item['ativo'] == 0)) {
				$qtd_planos++;
				$pos = $key+1;
					
				$plano = $model_plano->fetchEntry($item['id_plano']);
					
				$data['itemId'.$pos] = $item['id_plano'];
				$data['itemDescription'.$pos] = "Plano Promocional 1 Ano";
				$data['itemAmount'.$pos] = $item['preco'];
				$data['itemQuantity'.$pos] = '1';
					
				$planos_nomes .= $plano['titulo'].", ";
					
				$custos += $item['preco'];
				$descontos += $item['desconto'];
					
				$pagamento_assinatura['id_pagamento'] = $id_pagamento;
				$pagamento_assinatura['id_assinatura'] = $item['id'];
				$model_pagamento_assinatura->save($pagamento_assinatura);
			}
		}
		if($qtd_planos < 1) return $this->_response->setRedirect("ofertascadastradas")->sendResponse();
		
		$data['reference'] = $id_pagamento;
		$data['senderName'] = $assinante['nome'];
		if(isset($assinante['email'])) $data['senderEmail'] = $assinante['email'];
		$data['redirectURL'] = 'https://smartpanda.com.br/panda/servidor/';
		
		$data = http_build_query($data);
			
		//$this->_helper->json($data);
			
		$curl = curl_init($url);
			
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		$xml= curl_exec($curl);
			
		if($xml == 'Unauthorized'){
			//Insira seu código de prevenção a erros
				
			header('Location: erro.php?tipo=autenticacao');
			exit;//Mantenha essa linha
		}
		curl_close($curl);
			
		$xml= simplexml_load_string($xml);
		if(count($xml -> error) > 0){
				//Insira seu código de tratamento de erro, talvez seja útil enviar os códigos de erros.
				$this->_helper->json($xml);
				
				header('Location: erro.php?tipo=dadosInvalidos');
				exit;
			}
			
// 			header('Location: https://pagseguro.uol.com.br/v2/checkout/payment.html?code=' . $xml -> code);
			if(($xml->code) and ($xml->code != "")) {
				$model_pagamento->setFieldById($id_pagamento, 'payment_code', $xml->code);
				return $this->_response->setRedirect("https://pagseguro.uol.com.br/v2/checkout/payment.html?code=".$xml->code)->sendResponse();
			} else {
				$resposta['msg'] = 'Erro: payment_code invalido.';
				$resposta['xml'] = $xml;
				
				$this->_helper->json($resposta);
			}
	}
	
	protected function notificacaoAction() {
		$model_assinatura = $this->_getModelAssinaturas();
		$model_pagamento = $this->_getModelPagamentos();
		$model_pagamento_assinatura = $this->_getModelPagamentos_Assinaturas();
		$model_logSistema = $this->_getModelLogSistemas();
		
// 		$model_logSistema->log('7', 'Reached');
		
		$request = $this->getRequest();
		//Verifica se foi enviado via POST
		if($this->getRequest()->isPost()) {
// 			$data = $request->getPost();
			$host = gethostbyaddr($_SERVER['REMOTE_ADDR']);
			$model_logSistema->log('7', 'Notificação recebida do host: '.$host);
// 			if($host == "pagseguro.uol.com.br") {
// 				$notificationCode = $data['notificactionCode'];
// 			}
			
			if(isset($_POST['notificationType']) && $_POST['notificationType'] == 'transaction'){
				$model_logSistema->log('7', 'Notificação #: '.$_POST['notificationCode']);
				$data['email'] = 'drcbarboza@bambooss.com';
				$data['token'] = 'A442E448656C4A579F2C3DB72907625C';
				$url = 'https://ws.pagseguro.uol.com.br/v2/transactions/notifications/' . $_POST['notificationCode'] . '?email=' . $data['email'] . '&token=' . $data['token'];
				
				$curl = curl_init($url);
				curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				$transaction= curl_exec($curl);
				
				if($transaction == 'Unauthorized'){
					//Insira seu código avisando que o sistema está com problemas, sugiro enviar um e-mail avisando para alguém fazer a manutenção
					$model_logSistema->log('3', 'Notificação #: '.$_POST['notificationCode'].'. Erro: Transação não autorizada.');
					exit;//Mantenha essa linha
				}
				
				curl_close($curl);
				try {
					$transaction = simplexml_load_string($transaction);
				} catch (Exception $e) {
					$model_logSistema->log('3', 'Notificação #: '.$_POST['notificationCode'].'. Erro: '.$e);
				} 
				
				$notificationCode = $_POST['notificationCode'];
				$transactionCode = $transaction->code;
				$id_pagamento = $transaction->reference;
				if(($transaction->paymentLink) and ($transaction->paymentLink != "")) $paymentLink = $transaction->paymentLink;
				$status = $transaction->status;
				
				try {
					$model_pagamento->updatePagamento($id_pagamento, $paymentLink, $notificationCode, $transactionCode, $status);
				} catch (Exception $e) {
					$model_logSistema->log('3', 'Notificação #: '.$_POST['notificationCode'].'. Erro: '.$e);
				}
				
				if($status == 3) {//se o pagamento foi efetuado com sucesso
					$model_logSistema->log('6', 'Pagamento efetuado, id_pagamento: '.$id_pagamento);
					$assinaturas_pagas = $model_pagamento_assinatura->getAssinaturasByPagamento($id_pagamento);
					foreach($assinaturas_pagas as $value) {
						$model_assinatura->setPaga($value['id_assinatura']);
					}
				}
			}
			
		}
	}
	
}