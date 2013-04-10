function enviarLogin() {
	login = $('#frm_login').val();
	senha = $('#frm_senha').val();
	$('#statusMsg').fadeOut();
	if((login != "") && (senha != "")) {
		$.ajax({data: {login:login, senha:senha},type:'POST', dataType:'json', url:'login', timeout:10000,
			success: function(dados){
				if(dados[0].sucesso) {
					$('#statusMsg').removeClass('label-important');
					$('#statusMsg').addClass('label-success');
					window.location = "ofertascadastradas";
				} else {
					$('#statusMsg').removeClass('label-success');
					$('#statusMsg').addClass('label-important');
				} 
				$('#statusMsg').html(dados[0].mensagem);
				$('#statusMsg').fadeIn();
			},
			error: function(){
				console.warn("Erro ao enviar login");
			}
		});
	} else {
		$('#statusMsg').html('Informe ambos os campos (Usuário e Senha)');
		$('#statusMsg').removeClass('label-success');
		$('#statusMsg').addClass('label-important');
		$('#statusMsg').fadeIn();
	}
}

function enviarEnter(e, callback) {
	if(e && e.which){
		e = e
		characterCode = e.which
	}
	else{
		e = event
		characterCode = e.keyCode
	}

	if(characterCode == 13){ //13 = ENTER
		return callback();
	}
	else{
		return true 
	}	
}