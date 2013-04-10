$(document).ready(function() {
	carregarCreditos();
	carregarLojistas();
	carregarConvites()
	
});

function carregarLojistas() {
	$.ajax({type:'GET', dataType:'json', url:'shopping/getlojistas', timeout:10000,
		success: function(dados){
			if((dados) == "") {
				tabela = "NENHUM LOJISTA CADASTRADO";
			} else {
				tabela = '	<thead>'
	                			+'<tr>'
	            					+'<th>USUÁRIO</th>'
	            					+'<th rowspan="2">CRÉDITOS</th>'
	            				+'</tr>'
	            			+'</thead>';
				
				$.each(dados, function(i, obj) {
					if(!obj.nome) user_nome = "";
					else user_nome = "("+obj.nome+")";
					tabela += '<tbody r>'
								+'<tr id="'+obj.id_facebook+'">'
	                                +'<td><a id="a'+obj.id+'" href="" target="_blank">Carregando Usuário...</a> '+user_nome+'</td>'
	                                +'<td>'+obj.creditos+'</td>'
	                                +'<td><input type="text" size="5" id="creditos'+obj.id+'" style="width:50px;vertical-align:baseline;"> <button onclick="creditarLojista('+obj.id+');">+ Adicionar</button> <button onclick="descreditarLojista('+obj.id+');">- Subtrair</button></td>'
	                            +'</tr>'
	                        +'</tbody>';
					
					FB.api('/'+obj.id_facebook, function(response) {
						$('#a'+obj.id).html(response.name);
						$('#a'+obj.id).attr('href',response.link);
					});
				});
				tabela += '</table>';
			}
			
			$('#tableLojistas').html(tabela);
		},
		error: function(){
			console.warn("Erro ao carregar os usuarios inativos");
		}
	});
}

function carregarCreditos() {
	$.ajax({type:'GET', dataType:'json', url:'shopping/creditosdisponiveis', timeout:10000,
		success: function(dados){
			$('#creditosDisponiveis').html(dados[0].creditos);
			
		},
		error: function(){
			alert('Erro ao carregar créditos disponíveis.');
			console.warn("Erro ao carregar créditos disponíveis.");
		}
	});
}

function carregarConvites() {
	$.ajax({type:'GET', dataType:'json', url:'shopping/getconvites', timeout:10000,
		success: function(dados){
			if((dados) == "") {
				tabela = "NENHUM CONVITE CRIADO";
			} else {
				tabela = '	<thead>'
	                			+'<tr>'
	            					+'<th>LOJISTA CONVIDADO</th>'
	            					+'<th>CÓDIGO</th>'
	            					+'<th>AÇÂO</th>'
	            				+'</tr>'
	            			+'</thead>';
				
				$.each(dados, function(i, obj) {
					if(!obj.nome) user_nome = "";
					else user_nome = "("+obj.nome+")";
					tdUsuario = '<td><a id="a'+obj.id+'" href="" target="_blank">Carregando Usuário...</a> '+user_nome+'</td>';
					tdAcao = '<td id="acao'+obj.id+'"> - </td>';
					if(obj.id_lojista > 0) {
						FB.api('/'+obj.id_lojista, function(response) {
							$('#a'+obj.id).html(response.name);
							$('#a'+obj.id).attr('href',response.link);
						});
					} else {
						tdUsuario = '<td><span id="a'+obj.id+'">CONVITE DISPONÍVEL</a></td>';
						tdAcao = '<td id="acao'+obj.id+'"> <button onclick="removerConvite('+obj.id+')">Remover Convite</button> </td>';
					}
					
					tabela += '<tbody r>'
								+'<tr id="'+obj.id+'">'
	                                +tdUsuario
	                                +'<td>'+obj.codigo+'</td>'
	                                +tdAcao
	                            +'</tr>'
	                        +'</tbody>';

				});
				tabela += '</table>';
			}
			
			$('#tableConvites').html(tabela);
		},
		error: function(){
			console.warn("Erro ao carregar os convites");
		}
	});
}

function removerConvite(id_convite) {
	$.ajax({data: {id_convite:id_convite}, type:'GET', dataType:'json', url:'shopping/removerconvite', timeout:10000,
		success: function(dados){
			carregarConvites();
			console.info(dados[0].mensagem);
			
		},
		error: function(){
			alert('Erro ao enviar pedido de remoção de convite.');
			console.warn("Erro ao enviar pedido de remoção de convite.");
		}
	});
}

function creditarLojista(id_lojista, creditos) {
	creditos = $('#creditos'+id_lojista).val();
	$.ajax({data: {id:id_lojista, creditos:creditos}, type:'GET', dataType:'json', url:'shopping/inccreditos', timeout:10000,
		success: function(dados){
			carregarCreditos();
			carregarLojistas();
			
		},
		error: function(){
			alert('Erro ao enviar pedido de crédito.');
			console.warn("Erro ao enviar pedido de crédito.");
		}
	});
}

function descreditarLojista(id_lojista, creditos) {
	creditos = $('#creditos'+id_lojista).val();
	$.ajax({data: {id: id_lojista, creditos:creditos}, type:'GET', dataType:'json', url:'shopping/deccreditos', timeout:10000,
		success: function(dados){
			carregarCreditos();
			carregarLojistas();
			
		},
		error: function(){
			alert('Erro ao enviar pedido de descrédito.');
			console.warn("Erro ao enviar pedido de descrédito.");
		}
	});
}