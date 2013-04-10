$(document).ready(function() {
	carregarOfertas();

	
});

function carregarOfertas() {
	$.ajax({type:'GET', dataType:'json', url:'ofertascadastradas/getlistadecampanhas', timeout:10000,
		success: function(dados){
			tabela = criarTabela(dados);
			
			$('#tableOfertas').html(tabela);
		},
		error: function(){
			console.warn("Erro ao carregar as ofertas cadastradas");
		}
	});
}

function carregarOfertasLojistas() {
	$.ajax({type:'GET', dataType:'json', url:'ofertascadastradas/getcampanhasdoslojistas', timeout:10000,
		success: function(dados){
			tabela = criarTabelaLojistas(dados);
			
			$('#tableOfertasLojistas').html(tabela);
			
			var usuariosBuscados = new Array();
			$('.tdLojista').each(function(){
				id_facebook = $(this).html();
				if($.inArray(id_facebook,usuariosBuscados) < 0) {
					usuariosBuscados.push(id_facebook);
					$(this).html('Carregando Nome...');
					FB.api('/'+id_facebook, function(response) {
						$('.'+response.id).attr('title',response.name);
						$('.'+response.id).html(response.name);
					});
				}
			});
		},
		error: function(){
			console.warn("Erro ao carregar as ofertas cadastradas");
		}
	});
}

function criarTabela(dados) {
	tabela = '	<thead>'
		+'<tr>'
			+'<th>ANÚNCIO</th>'
			+'<th>TÍTULO</th>'
			+'<th>STATUS</th>'
			+'</tr>'
	+'</thead>';

$.each(dados, function(i, obj) {
	oferta = obj.oferta;
	campanha = obj.campanha;
	lojista = obj.lojista;
	
	if(campanha.ativo >= 0) {
		status = "";
		switch(campanha.ativo) {
			case '1':
				status = "Rodando";
				break;
			case '0':
				status = "Em Pausa";
				break;
		}
	
		tabela += '<tbody r>'
		            +'<tr>'
		                +'<td><a href="statusoferta?id='+oferta.id+'" title="'+lojista+'">'+oferta.nome+'</a></td>'
		                +'<td>'+oferta.titulo+'</td>'
		                +'<td>'+status+'</td>'
		            +'</tr>'
		        +'</tbody>';
	}
});
	tabela += '</table>';
	return tabela;
}

function criarTabelaLojistas(dados) {
	tabela = '	<thead>'
		+'<tr>'
			+'<th>ANÚNCIO</th>'
			+'<th>TÍTULO</th>'
			+'<th>LOJISTA</th>'
			+'</tr>'
	+'</thead>';

$.each(dados, function(i, obj) {
	oferta = obj.oferta;
	campanha = obj.campanha;
	lojista = obj.lojista;
	
	if(campanha.ativo >= 0) {
		
		
	
		tabela += '<tbody r>'
		            +'<tr>'
		                +'<td><a href="statusoferta?id='+oferta.id+'">'+oferta.nome+'</a></td>'
		                +'<td>'+oferta.titulo+'</td>'
		                +'<td id="'+oferta.id+'" class="tdLojista '+oferta.id_facebook+'">'+lojista+'</td>'
		            +'</tr>'
		        +'</tbody>';
	}
});
	tabela += '</table>';
	return tabela;
}

function entrarShopping() {
	$('#msgBoxConvite').fadeIn();
	$('#btEntrarShopping').fadeOut();
}

function enviarConvite() {
	$.ajax({data: { codigo:$('#inputCodigo').val() }, type:'GET', dataType:'json', url:'ofertascadastradas/aceitarconvite', timeout:10000,
		success: function(dados){
			if(dados[0].sucesso) {
				$('#conviteMsg').css('color','#070')
				$('#msgBoxConvite fieldset').fadeOut();
			} else {
				$('#conviteMsg').css('color','#f00')
			}
			$('#conviteMsg').html(dados[0].mensagem);
		},
		error: function(){
			console.warn("Erro ao aceitar convite.");

		}
	});
}

function alterarNome() {
	$.ajax({data: { nome:$('#nome').val() }, type:'GET', dataType:'json', url:'ofertascadastradas/setnome', timeout:10000,
		success: function(dados){
			$.alert('',dados[0].mensagem);
		},
		error: function(){
			console.warn("Erro ao enviar mudança de nome.");

		}
	});
}


function criarLogin() {
	login = $('#frm_login').val();
	senha = $('#frm_senha').val();
	
	$('#statusMsg').fadeOut();
	if((login != "") && (senha != "")) {
		$('#frm_login').attr("disabled",true);
		$('#frm_senha').attr("disabled",true);
		$.ajax({data: {login:login, senha:senha},type:'POST', dataType:'json', url:'sistema/criarlogin', timeout:10000,
			success: function(dados){
				if(dados[0].sucesso) {
					$('#statusMsg').removeClass('label-important');
					$('#statusMsg').addClass('label-success');
					
					setTimeout(function() {
						window.location = "ofertascadastradas";
					}, 3000);
				} else {
					$('#frm_login').attr("disabled",false);
					$('#frm_senha').attr("disabled",false);
					
					$('#statusMsg').removeClass('label-success');
					$('#statusMsg').addClass('label-important');
				} 
				$('#statusMsg').html(dados[0].mensagem);
				$('#statusMsg').fadeIn();
			},
			error: function(){
				console.warn("Erro ao enviar criação de login");
			}
		});
	} else {
		$('#statusMsg').html('Informe ambos os campos (Usuário e Senha)');
		$('#statusMsg').removeClass('label-success');
		$('#statusMsg').addClass('label-important');
		$('#statusMsg').fadeIn();
	}
}

function alterarSenha() {
	senhaAntiga = $('#frm_senhaAntiga').val();
	senhaNova = $('#frm_senhaNova').val();
	senhaNova2 = $('#frm_senhaNova2').val();
	
	$('#statusMsg2').fadeOut();
	if((senhaAntiga != "") && (senhaNova != "") && (senhaNova2 != "")) {
		if(senhaNova == senhaNova2) {
			$('#frm_senhaAntiga').attr("disabled",true);
			$('#frm_senhaNova').attr("disabled",true);
			$('#frm_senhaNova2').attr("disabled",true);
			$.ajax({data: {senhaAntiga:senhaAntiga, senhaNova:senhaNova},type:'POST', dataType:'json', url:'sistema/alterarsenha', timeout:10000,
				success: function(dados){
					if(dados[0].sucesso) {
						$('#statusMsg2').removeClass('label-important');
						$('#statusMsg2').addClass('label-success');
						setTimeout(function() {
							$('#statusMsg2').fadeOut();
							$('#modalalterarsenha').modal('hide');
							senhaAntiga = $('#frm_senhaAntiga').val("");
							senhaNova = $('#frm_senhaNova').val("");
							senhaNova2 = $('#frm_senhaNova2').val("");
							$('#frm_senhaAntiga').attr("disabled",false);
							$('#frm_senhaNova').attr("disabled",false);
							$('#frm_senhaNova2').attr("disabled",false);
						}, 2000);
					} else {
						$('#frm_senhaAntiga').attr("disabled",false);
						$('#frm_senhaNova').attr("disabled",false);
						$('#frm_senhaNova2').attr("disabled",false);
						
						$('#statusMsg2').removeClass('label-success');
						$('#statusMsg2').addClass('label-important');
					} 
					$('#statusMsg2').html(dados[0].mensagem);
					$('#statusMsg2').fadeIn();
				},
				error: function(){
					console.warn("Erro ao enviar criação de login");
				}
			});
		} else {
			$('#statusMsg2').html('Os campos da senha nova não estão iguais.');
			$('#statusMsg2').removeClass('label-success');
			$('#statusMsg2').addClass('label-important');
			$('#statusMsg2').fadeIn();
		}
	} else {
		$('#statusMsg2').html('Informe ambos os campos (Usuário e Senha)');
		$('#statusMsg2').removeClass('label-success');
		$('#statusMsg2').addClass('label-important');
		$('#statusMsg2').fadeIn();
	}
}

function completarCadastro() {
	razao_social = $('#razao_social').val();
	nome_fantasia = $('#nome_fantasia').val();
	cnpj = $('#cnpj').val();
	endereco = $('#endereco').val();
	nr = $('#nr').val();
	complemento = $('#complemento').val();
	cep = $('#cep').val();
	cidade = $('#cidade option:selected').val();
	id_estabelecimento = $('#id_estabelecimento option:selected').val();
	email = $('#email').val();
	telefone = $('#telefone').val();
	
	$('#statusMsg3').fadeOut();
	if((razao_social != "") && (nome_fantasia != "") && (cnpj != "") && (endereco != "") && (nr != "") && (cep != "") && (email != "") && (telefone != "")) {
		$('#modalcompletarcadastro input').each(function(){ $(this).attr("disabled",true); });
		$('#modalcompletarcadastro select').each(function(){ $(this).attr("disabled",true); });
		$('#modalcompletarcadastro button').each(function(){ $(this).attr("disabled",true); });
		$.ajax({data: {razao_social:razao_social, nome_fantasia:nome_fantasia, cnpj:cnpj, endereco:endereco, nr:nr, complemento:complemento, cep:cep, cidade:cidade, id_estabelecimento:id_estabelecimento, email:email, telefone:telefone},type:'POST', dataType:'json', url:'cadastro/completar', timeout:10000,
			success: function(dados){
				if(dados[0].sucesso) {
					$('#statusMsg3').removeClass('label-important');
					$('#statusMsg3').addClass('label-success');
					
					setTimeout(function() {
						window.location = "ofertascadastradas";
					}, 3000);
				} else {
					$('#modalcompletarcadastro input').each(function(){ $(this).attr("disabled",false); });
					$('#modalcompletarcadastro select').each(function(){ $(this).attr("disabled",false); });
					$('#modalcompletarcadastro button').each(function(){ $(this).attr("disabled",false); });
					
					$('#statusMsg3').removeClass('label-success');
					$('#statusMsg3').addClass('label-important');
				} 
				$('#statusMsg3').html(dados[0].mensagem);
				$('#statusMsg3').fadeIn();
			},
			error: function(){
				console.warn("Erro ao enviar criação de login");
			}
		});
	} else {
		$('#statusMsg3').html('Um ou mais campos obrigatórios não foram preenchidos');
		$('#statusMsg3').removeClass('label-success');
		$('#statusMsg3').addClass('label-important');
		$('#statusMsg3').fadeIn();
	}
}

var lojas;
function carregarLojas() {
	lojas = new Array();
	$.ajax({data: {id_shopping:id_shopping}, type:'GET', dataType:'json', url:'sistema/getlojasprecadastradas', timeout:10000,
		success: function(dados){
			$.each(dados, function(i, obj) {
				lojas.push(obj);
			});
			listarLojas();
		},
		error: function(){
			console.warn("Erro ao carregar as lojas");
		}
	});
}

function listarLojas() {
	lojas_selecionadas = new Array();
	$.each(lojas, function(i, obj) {
		if(obj.id_shopping == id_shopping)
			lojas_selecionadas.push(obj);
	});
	
	html = '<option>Selecione a loja</option>';
	$.each(lojas_selecionadas, function(i, obj) {
		html += '<option value='+obj.id+'>'+obj.nome_fantasia+'</option>';
	});
	
	$('#id_estabelecimento').html(html);
}