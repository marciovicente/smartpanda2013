$(document).ready(function() {

});


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

function completarCadastro() {
	razao_social = $('#razao_social').val();
	nome_fantasia = $('#nome_fantasia').val();
	cnpj = $('#cnpj').val();
	endereco = $('#endereco').val();
	nr = $('#nr').val();
	complemento = $('#complemento').val();
	cep = $('#cep').val();
	email = $('#email').val();
	telefone = $('#telefone').val();
	
	$('#statusMsg3').fadeOut();
	if((razao_social != "") && (nome_fantasia != "") && (cnpj != "") && (endereco != "") && (nr != "") && (cep != "") && (email != "") && (telefone != "")) {
		$('#modalcompletarcadastro input').each(function(){ $(this).attr("disabled",true); });
		$.ajax({data: {razao_social:razao_social, nome_fantasia:nome_fantasia, cnpj:cnpj, endereco:endereco, nr:nr, complemento:complemento, cep:cep, email:email, telefone:telefone},type:'POST', dataType:'json', url:'cadastro/completar', timeout:10000,
			success: function(dados){
				if(dados[0].sucesso) {
					$('#statusMsg3').removeClass('label-important');
					$('#statusMsg3').addClass('label-success');
					
					setTimeout(function() {
						window.location = "ofertascadastradas";
					}, 3000);
				} else {
					$('#modalcompletarcadastro input').each(function(){ $(this).attr("disabled",false); });
					
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