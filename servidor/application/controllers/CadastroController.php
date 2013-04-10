<?php
class CadastroController extends Zend_Controller_Action
{
	public function  indexAction() {
		
	}
	
	public function init(){
// 		$this->view->headScript()->appendFile('js/cadastro.js');
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
	
	protected function _getModelTelefones() {
		require_once APPLICATION_PATH . '/models/Telefones.php';
		$this->_model = new Model_Telefones();
	
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
	
	protected function _getModelPromocoes() {
		require_once APPLICATION_PATH . '/models/Promocoes.php';
		$this->_model = new Model_Promocoes();
	
		return $this->_model;
	}
	
	protected function _getModelLogPromocoes() {
		require_once APPLICATION_PATH . '/models/LogPromocoes.php';
		$this->_model = new Model_LogPromocoes();
	
		return $this->_model;
	}
	
	function validaCNPJ($cnpj) {
		if(strlen($cnpj) <> 14){
			return false;
		}
        $calcular = 0;
        $calcularDois = 0;
        for ($i = 0, $x = 5; $i <= 11; $i++, $x--) {
            $x = ($x < 2) ? 9 : $x;
            $number = substr($cnpj, $i, 1);
            $calcular += $number * $x;
        }
        for ($i = 0, $x = 6; $i <= 12; $i++, $x--) {
            $x = ($x < 2) ? 9 : $x;
            $numberDois = substr($cnpj, $i, 1);
            $calcularDois += $numberDois * $x;
        }

        $digitoUm = (($calcular % 11) < 2) ? 0 : 11 - ($calcular % 11);
        $digitoDois = (($calcularDois % 11) < 2) ? 0 : 11 - ($calcularDois % 11);

        if ($digitoUm <> substr($cnpj, 12, 1) || $digitoDois <> substr($cnpj, 13, 1)) {
            return false;
        }
        return true;
	}
	
	function validaCPF($cpf = null) {
	
		// Verifica se um número foi informado
		if(empty($cpf)) {
			return false;
		}
	
		// Elimina possivel mascara
		$cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);
		 
		// Verifica se o numero de digitos informados é igual a 11
		if (strlen($cpf) != 11) {
			return false;
		}
		// Verifica se nenhuma das sequências invalidas abaixo
		// foi digitada. Caso afirmativo, retorna falso
		else if ($cpf == '00000000000' ||
		$cpf == '11111111111' ||
		$cpf == '22222222222' ||
		$cpf == '33333333333' ||
		$cpf == '44444444444' ||
		$cpf == '55555555555' ||
		$cpf == '66666666666' ||
		$cpf == '77777777777' ||
		$cpf == '88888888888' ||
		$cpf == '99999999999') {
			return false;
			// Calcula os digitos verificadores para verificar se o
			// CPF é válido
		} else {
			 
			for ($t = 9; $t < 11; $t++) {
				 
				for ($d = 0, $c = 0; $c < $t; $c++) {
					$d += $cpf{$c} * (($t + 1) - $c);
				}
				$d = ((10 * $d) % 11) % 10;
				if ($cpf{$c} != $d) {
					return false;
				}
			}
	
			return true;
		}
	}
	
	function pegarNumeros($dado) {
		$formatado = preg_replace('/[^0-9]/', '', $dado);
		
		return $formatado;
	}
	
	protected function cadastrarAction() {
	$model_usuario = $this->_getModelUsuarios();
	$model_estabelecimento = $this->_getModelEstabelecimentos();
	$model_promocao = $this->_getModelPromocoes();
	$model_logPromocao = $this->_getModelLogPromocoes();

		$request = $this->getRequest();
		//Verifica se foi enviado via POST
		if($this->getRequest()->isPost()) {
			$data = $request->getPost();
			
			$campoVazio = false;
			foreach ($data as $key => $value) {
				if((!isset($data[$key])) and ($key != 'complemento')) $campoVazio = true;
			}
			
			if($campoVazio) {
				$msg['mensagem'] = 'Um ou mais campos obrigatórios não foram preenchidos.';
				$msg[] = $msg;
				$this->_helper->json($msg);
			}
			
			$cnpj = $this->pegarNumeros($data['cnpj']);
			if(!$this->validaCNPJ($cnpj)){
				$msg['mensagem'] = 'CNPJ inválido.';
				$msg[] = $msg;
				$this->_helper->json($msg);
			}
			
			$cpf = $this->pegarNumeros($data['cpf']);
			if(!$this->validaCPF($cpf)){
				$msg['mensagem'] = 'CPF inválido.';
				$msg[] = $msg;
				$this->_helper->json($msg);
			}
			
			$loja_precadastro = $model_estabelecimento->fetchEntry($data['loja']);
			if($loja_precadastro['contratado']) {
				$msg = "";
				$msg['mensagem'] = 'Loja "'.$loja_precadastro['nome_fantasia'].'" já cadastrada. Se você é o verdadeiro responsável por ela, favor entrar em contato.';
				$msg[] = $msg;
				$this->_helper->json($msg);
			}
			
			if(isset($data['name_user'])) $login = $data['name_user'];
			if(isset($data['password'])) $senha = $data['password'];
			
			if((isset($login)) and (isset($senha))) {
			
				if(!$model_usuario->fetchLogin($login)) {
					$usuario_dados['email'] = $data['email_usuario'];
					$usuario_dados['cpf'] = $cpf;
					$usuario_dados['nome'] = $data['nome_responsavel'];
					$usuario_dados['tipo'] = 2;
					$id_usuario = $model_usuario->cadastrar($login, $senha, $usuario_dados);
					$usuario_dados['cep'] = $data['cep'];
					if($id_usuario) {
						try {
							$model_telefone = $this->_getModelTelefones();
							$telefone['id_usuario'] = $id_usuario;
							$telefone['numero'] = $data['celular'];
							$model_telefone->save($telefone);
								
							$msg['sucesso'] = true;
							$msg['mensagem'] = 'Informações cadastradas com sucesso.';
						} catch (Exception $e) {
							$msg['mensagem'] = 'Erro ao cadastrar informações do usuário (#2).';
							$msg[] = $msg;
							$this->_helper->json($msg);
						}
						
// 						$msg['sucesso'] = true;
						$msg['mensagem'] = 'Login criado com sucesso.';
					} else {
						$msg['mensagem'] = 'Erro ao criar conta.';
						$msg[] = $msg;
						$this->_helper->json($msg);
					}	
				} else {
					$msg['mensagem'] = 'Este login já está sendo usado.';
					$msg[] = $msg;
					$this->_helper->json($msg);
				}

			} else {
				$msg['mensagem'] = 'Verifique o nome de usuário e senha';
				$msg[] = $msg;
				$this->_helper->json($msg);
			}
			
			$campoVazio = false;
			
			
			foreach ($data as $key => $value) {
				if((!isset($data[$key])) and ($key != 'complemento')) $campoVazio = true;
			}
			if(!$campoVazio) {
				if($model_usuario->temLoginSenha($id_usuario)) {
					$estabelecimento['id_usuario'] = $id_usuario;

					$estabelecimento['razao_social'] = $data['razao_social'];
					$estabelecimento['nome_fantasia'] = $data['nome_fantasia'];
					$estabelecimento['cnpj'] = $cnpj;
					$estabelecimento['endereco'] = $data['endereco'];
					$estabelecimento['nr'] = $data['numero'];
					$estabelecimento['complemento'] = $data['complemento'];
					$estabelecimento['cep'] = $data['cep'];
					$estabelecimento['id_cidade'] = $data['cidade'];
					$estabelecimento['email'] = $data['email'];
					$estabelecimento['tipo'] = 2;
					$estabelecimento['id_shopping'] = $data['shopping'];
					$estabelecimento['ativo'] = 1;
					$estabelecimento['contratado'] = 1;
					$estabelecimento['id_precadastro'] = $data['loja'];
					$estabelecimento['categoria'] = $loja_precadastro['categoria'];
					
					try {
							$id_estabelecimento = $model_estabelecimento->save($estabelecimento);
							$precadastro['ativo'] = 0;
							$precadastro['contratado'] = 1;
							$id_precadastro = $model_estabelecimento->update($precadastro, $data['loja']); 

						try {
							$model_telefone = $this->_getModelTelefones();
							$telefone['id_usuario'] = $id_usuario;
							$telefone['id_estabelecimento'] = $id_estabelecimento;
							$telefone['numero'] = $data['telefone'];
							$model_telefone->save($telefone);
							
							$msg['sucesso'] = true;
							$msg['mensagem'] = 'Conta criada com sucesso. Aguarde...';
						} catch (Exception $e) {
							$msg['mensagem'] = 'Erro ao cadastrar informações (#2).';
						}
						
						try {
							$model_assinatura = $this->_getModelAssinaturas();
							$model_plano = $this->_getModelPlanos();
							
							$id_plano = '';
							
							if((isset($data['plano'])) and ($data['plano'] != "")) {
								$id_plano = $data['plano'];
								if($estabelecimento['id_shopping'] == 14) {$id_plano = 3;$assinatura['ativo'] = 1;} //Se for lojista do Paseo
								if($estabelecimento['id_shopping'] == 15) {$id_plano = 1;$assinatura['ativo'] = 1;} //Se for lojista do Estrada do Coco
								
								$checkPromocao['valid'] = false;
								if(isset($data['promocao'])) { 
									$id_promocao = 1;
									$promocao = $model_promocao->fetchEntry($id_promocao);
									$id_plano = $promocao['id_plano'];
									$checkPromocao = $model_promocao->checkPromocao($id_promocao);
									$logPromocao['id_promocao'] = $id_promocao;
									$logPromocao['id_usuario'] = $id_usuario;
									$logPromocao['mensagem'] = $checkPromocao['mensagem'];
									
									if(!$checkPromocao['valid']) { //Se a promocao nao for mais valida
										$logPromocao['ativo'] = 0;
// 										$msg['mensagem'] = $checkPromocao['mensagem'];
// 										$msg[] = $msg;
// 										$this->_helper->json($msg);
									} else { //Se a promocao ainda eh valida
										$logPromocao['ativo'] = 1;
										$assinatura['promocao'] = 1;
										$data_atual = new DateTime();
										$data_atual->modify('+1 year');
										$assinatura_fim = $data_atual->format('Y-m-d H:i:s'); //add 1 ano a data atual
										$assinatura['fim'] = $assinatura_fim;
									}
									
									$model_logPromocao->save($logPromocao);
									
								}
								
								$plano = $model_plano->fetchEntry($id_plano);
								$assinatura['id_usuario'] = $id_usuario;
								$assinatura['id_estabelecimento'] = $id_estabelecimento;
								$assinatura['id_plano'] = $id_plano;
								$assinatura['preco'] = $plano['preco'];
								$assinatura['desconto'] = 0.00;
								if(($estabelecimento['id_shopping'] == 14) or ($estabelecimento['id_shopping'] == 15)) $assinatura['desconto'] = $plano['preco'];
								$novaAssinatura = $model_assinatura->assinar($assinatura);
								
								if(($id_plano == 1) and ($estabelecimento['id_shopping'] != 15) and (!$checkPromocao['valid'])) {
									$data_atual = new DateTime();
									$data_atual->modify('+1 month');
									$assinatura_fim = $data_atual->format('Y-m-d H:i:s'); //add 1 mes a data atual
									$model_assinatura->setFieldById($novaAssinatura, 'fim', $assinatura_fim);
									if(!isset($data['promocao'])) $model_assinatura->setFieldById($novaAssinatura, 'ativo', '1');
								}
								
								if($id_plano == 3) $data['tv'] = 'auto'; //Se for o plano Premium adicionar automaticamente o Smartpanda TV
							}
							if((isset($data['tv'])) and ($id_plano == 1)) unset($data['tv']); //Se for o plano Basic, nao deixa ter Smartpanda TV

							
							if((isset($data['tv'])) and ($data['tv'] != "")) { //Se tiver Smartpanda TV
								$plano = $model_plano->fetchEntry(4);
								$assinatura['id_usuario'] = $id_usuario;
								$assinatura['id_estabelecimento'] = $id_estabelecimento;
								$assinatura['id_plano'] = 4;
								$assinatura['preco'] = $plano['preco'];
								$assinatura['desconto'] = 0.00;
								$model_assinatura->assinar($assinatura);
							}
							
// 							$this->_response->setRedirect("https://bambooss.websiteseguro.com/servidor/")->sendResponse();
							$msg = "";
							$msg['sucesso'] = true;
							$msg['mensagem'] = "Cadastro realizado com sucesso. Aguarde...";
							$msg[] = $msg;
							$this->_helper->json($msg);
							
						} catch (Exception $e) {
							$msg['mensagem'] = 'Erro ao cadastrar assinatura.';
						}
						
					} catch (Exception $e) {
						$msg['mensagem'] = 'Erro ao cadastrar informações (#1).';
					}
					
				} else {
					$msg['mensagem'] = 'Você ainda não tem um login no Smartpanda. Crie um login sem Facebook primeiro.';
				}
			} else {
				$msg['mensagem'] = 'Um ou mais campos obrigatórios não foram preenchidos.';
			}
			
			$msg[] = $msg;
			$this->_helper->json($msg);
		}
	
	}
	
	protected function completarAction() {
		$model_usuario = $this->_getModelUsuarios();
		$usuario = $model_usuario->loadUsuarioLogado();
		$id_usuario = $usuario['id'];
		
		$request = $this->getRequest();
		//Verifica se foi enviado via POST
		if($this->getRequest()->isPost()) {
			$data = $request->getPost();
			$campoVazio = false;
			
			foreach ($data as $key => $value) {
				if((!isset($data[$key])) and ($key != 'complemento')) $campoVazio = true;
			}
			if(!$campoVazio) {
				if($model_usuario->temLoginSenha($id_usuario)) {
					$model_estabelecimento = $this->_getModelEstabelecimentos();
					$estabelecimento['id_usuario'] = $id_usuario;
					if($usuario['id_facebook'] != '') $estabelecimento['id_facebook'] = $usuario['id_facebook'];
					if($usuario['id_shopping'] != '') {
						$shopping_estabelecimento = $model_estabelecimento->getByUsuario($usuario['id_shopping']);
						$estabelecimento['id_shopping'] = $shopping_estabelecimento['id'];
					}
					$estabelecimento['razao_social'] = $data['razao_social'];
					$estabelecimento['nome_fantasia'] = $data['nome_fantasia'];
					$estabelecimento['cnpj'] = $data['cnpj'];
					$estabelecimento['endereco'] = $data['endereco'];
					$estabelecimento['nr'] = $data['nr'];
					$estabelecimento['complemento'] = $data['complemento'];
					$estabelecimento['id_cidade'] = $data['cidade'];
					$estabelecimento['cep'] = $data['cep'];
					$estabelecimento['email'] = $data['email'];
					$estabelecimento['tipo'] = $usuario['tipo'];
					$estabelecimento['ativo'] = $usuario['ativo'];
					$estabelecimento['creditos'] = $usuario['creditos'];
					$estabelecimento['latitude'] = $usuario['latitude'];
					$estabelecimento['longitude'] = $usuario['longitude'];
					$estabelecimento['contratado'] = 1;
					$estabelecimento['id_precadastro'] = $data['id_estabelecimento'];
					
					try {
// 						$temEstabelecimento = $model_estabelecimento->temEstabelecimento($id_usuario);
// 						if(!$temEstabelecimento) {
// 							$id_estabelecimento = $model_estabelecimento->save($estabelecimento);
// 						} else {
// 							$model_estabelecimento->update($estabelecimento, $temEstabelecimento);
// 							$id_estabelecimento = $temEstabelecimento;
// 						}
						$id_estabelecimento = $model_estabelecimento->save($estabelecimento);
						$precadastro['ativo'] = 0;
						$precadastro['contratado'] = 1;
						$id_precadastro = $model_estabelecimento->update($precadastro, $data['id_estabelecimento']);
						try {
							$model_telefone = $this->_getModelTelefones();
							$telefone['id_usuario'] = $id_usuario;
							$telefone['id_estabelecimento'] = $id_estabelecimento;
							$telefone['numero'] = $data['telefone'];
							$model_telefone->save($telefone);
							
							$msg['sucesso'] = true;
							$msg['mensagem'] = 'Informações cadastradas com sucesso.';
						} catch (Exception $e) {
							$msg['mensagem'] = 'Erro ao cadastrar informações (#2).';
						}
						
						try {
							$model_assinatura = $this->_getModelAssinaturas();
							$model_plano = $this->_getModelPlanos();
							
							if($estabelecimento['id_shopping'] == 14) $id_plano = 3; //Se for lojista do Paseo
							if($estabelecimento['id_shopping'] == 15) $id_plano = 1; //Se for lojista do Estrada do Coco
								

							$plano = $model_plano->fetchEntry($id_plano);
							$assinatura['id_usuario'] = $id_usuario;
							$assinatura['id_estabelecimento'] = $id_estabelecimento;
							$assinatura['id_plano'] = $id_plano;
							$assinatura['preco'] = $plano['preco'];
							$assinatura['desconto'] = $plano['preco'];
							$assinatura['ativo'] = 1;
							$model_assinatura->assinar($assinatura);
					
							if($id_plano == 3) $data['tv'] = 'auto'; //Se for o plano Premium adicionar automaticamente o Smartpanda TV

							if((isset($data['tv'])) and ($id_plano == 1)) unset($data['tv']); //Se for o plano Basic, nao deixa ter Smartpanda TV
								
							if((isset($data['tv'])) and ($data['tv'] != "")) {
								//Se tiver Smartpanda TV
								$plano = $model_plano->fetchEntry(4);
								$assinatura['id_usuario'] = $id_usuario;
								$assinatura['id_estabelecimento'] = $id_estabelecimento;
								$assinatura['id_plano'] = 4;
								$assinatura['preco'] = $plano['preco'];
								$assinatura['desconto'] = $plano['preco'];
								$assinatura['ativo'] = 1;
								$model_assinatura->assinar($assinatura);
							}
								
							// 							$this->_response->setRedirect("https://bambooss.websiteseguro.com/servidor/")->sendResponse();
								
						} catch (Exception $e) {
							$msg['mensagem'] = 'Erro ao cadastrar assinatura.';
						}
						
					} catch (Exception $e) {
						$msg['mensagem'] = 'Erro ao cadastrar informações (#1). Erro: '.$e;
					}
					
				} else {
					$msg['mensagem'] = 'Você ainda não tem um login no Smartpanda. Crie um login sem Facebook primeiro.';
				}
			} else {
				$msg['mensagem'] = 'Um ou mais campos obrigatórios não foram preenchidos.';
			}
			
			$msg[] = $msg;
			$this->_helper->json($msg);
		}
	}
	
	protected function confirmarplanoAction() {
		$this->view->headScript()->appendFile('../js/confirmarplano.js');
		
		$model_usuario = $this->_getModelUsuarios();
		$model_estabelecimento = $this->_getModelEstabelecimentos();
		$model_assinatura = $this->_getModelAssinaturas();
		$model_plano = $this->_getModelPlanos();
		$model_promocao = $this->_getModelPromocoes();
		$model_logPromocao = $this->_getModelLogPromocoes();
		
		$usuario = $model_usuario->loadUsuarioLogado();
		
		$this->view->nome = $usuario['nome'];
		
		$id_estabelecimento = $model_estabelecimento->temEstabelecimento($usuario['id']);
		
		if(!$id_estabelecimento)
			return $this->_response->setRedirect("../ofertascadastradas")->sendResponse();
		
		$estabelecimento = $model_estabelecimento->fetchEntry($id_estabelecimento);
		
		$this->view->razao_social = $estabelecimento['razao_social'];
		
		
		$assinaturas = $model_assinatura->getAssinaturasByUsuario($usuario['id']);
		$promocao = $model_logPromocao->getPromocaoByUsuario($usuario['id']);
		$planoCusto = 0;
		$tvCusto = 0;
		foreach ($assinaturas as $value) {
			if(($promocao) and ($promocao['ativo'] == 0) and ($value['ativo'] == 0)) {
				$model_assinatura->setFieldById($value['id'], 'ativo', '1');
				return $this->_response->setRedirect("../ofertascadastradas?fimpromocao")->sendResponse();
			}
			
			if(($value['promocao']) and ($value['ativo'] == 0))
				return $this->_response->setRedirect("../pagamentos/gerarpagamento")->sendResponse();
			
			if(!$value['fim']) {
				$plano = $model_plano->fetchEntry($value['id_plano']);
				if($plano['id'] != 4) {//se nao for smartpanda tv
					$this->view->planoTitulo = $plano['titulo'];
					$planoCusto = $value['preco'] - $value['desconto'];
					$this->view->planoCusto = $planoCusto;
				} else {
					$tvCusto = $value['preco'] - $value['desconto'];
					$this->view->tvCusto = $tvCusto;
				}
			}
		}
		$this->view->totalCusto = $planoCusto + $tvCusto;
		
		
	}
	
	protected function assinarAction() {
	
	}
	
}