var tipoativo = "";

$(document).ready(function() {
	carregarCreditos();
	carregarUsuarios();
	
});

function carregarUsuarios() {
	var usuariosBuscados = new Array();
	$('.tdUsuario').each(function(){
		id_facebook = $(this).html();
		if($.inArray(id_facebook,usuariosBuscados) < 0) {
			usuariosBuscados.push(id_facebook);
			$(this).html('Carregando Nome...');
			FB.api('/'+id_facebook, function(response) {
				$('.td'+response.id).attr('title',response.name);
				$('.td'+response.id).html(response.name);
			});
		}
	});
}

function carregarCreditos() {
	if(outroUsuario) url = 'transacoes/creditosdisponiveis?id_usuario='+outroUsuario;
	else url = 'transacoes/creditosdisponiveis';
	$.ajax({type:'GET', dataType:'json', url:url, timeout:10000,
		success: function(dados){
			$('#creditosDisponiveis').html(dados[0].creditos);
			
		},
		error: function(){
			alert('Erro ao carregar créditos disponíveis.');
			console.warn("Erro ao carregar créditos disponíveis.");
		}
	});
}
