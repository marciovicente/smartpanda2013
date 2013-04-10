function ativarOferta() {
	$('#botoes').fadeOut().queue(function(){$('#msgBox').fadeIn();$(this).dequeue();});
}

function cancelarAtivarOferta() {
	$('#msgBox').fadeOut().queue(function(){$('#botoes').fadeIn();$(this).dequeue();});
}

function desativarOferta(id_oferta) {
	desativar = confirm('A oferta será removida');
	if(desativar) {
		enviarDesativarOferta(id_oferta);
	}
}

function enviarAtivarOferta(id_oferta) {
	$.ajax({data: { id_oferta:id_oferta }, type:'GET', dataType:'json', url:'statusoferta/ativarcampanha', timeout:10000,
		success: function(dados){
			exibirStatus(dados);
			if(dados.sucesso)
				window.location.reload();
		},
		error: function(){
			console.warn("Erro ao ativar oferta.");

		}
	});
}

function enviarPausarOferta(id_oferta) {
	$.ajax({data: { id_oferta:id_oferta }, type:'GET', dataType:'json', url:'statusoferta/pausarcampanha', timeout:10000,
		success: function(dados){
			exibirStatus(dados);
			if(dados.sucesso)
				window.location.reload();
		},
		error: function(){
			console.warn("Erro ao pausar oferta.");

		}
	});
}

function enviarDesativarOferta(id_oferta) {
	$.ajax({data: { id_oferta:id_oferta }, type:'GET', dataType:'json', url:'statusoferta/desativarcampanha', timeout:10000,
		success: function(dados){
			exibirStatus(dados);
			if(dados.sucesso)
				window.location = 'ofertascadastradas';
		},
		error: function(){
			console.warn("Erro ao desativar oferta.");

		}
	});
}

function exibirStatus(dados) {
	if(dados[0].sucesso) {
		$('#statusMsg').css('color','#070')
		$('#msgBox fieldset').fadeOut();
		$('#botoes').fadeIn();
	} else {
		$('#statusMsg').css('color','#f00')
	}
	$('#statusMsg').html(dados[0].mensagem);
}