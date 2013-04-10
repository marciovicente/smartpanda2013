$(document).ready(function() {
	carregarCidades();
	carregarEstados();
	carregarPlanos();
	
});

var cidades;
function carregarCidades() {
	cidades = new Array();
	$.ajax({type:'GET', dataType:'json', url:'../sistema/getcidadescomshoppings',
		success: function(dados){
			$.each(dados, function(i, obj) {
				cidades.push(obj);
			});
		},
		error: function(){
			console.warn("Erro ao carregar as cidades");
		}
	});
}

var estados;
function carregarEstados() {
	estados = new Array();
	$.ajax({type:'GET', dataType:'json', url:'../sistema/getestadoscomshoppings',
		success: function(dados){
			$.each(dados, function(i, obj) {
				estados.push(obj);
			});
			listarEstados();
		},
		error: function(){
			console.warn("Erro ao carregar os estados");
		}
	});
}

var shoppings;
function carregarShoppings() {
	html_loading = '<option>Carregando Shoppings...</option>';
	$('#shopping').html(html_loading);
	shoppings = new Array();
	$.ajax({data: {id_cidade:$('#cidade').val()}, type:'GET', dataType:'json', url:'../sistema/getshoppingsativos',
		success: function(dados){
			$.each(dados, function(i, obj) {
				shoppings.push(obj);
			});
			listarShoppings();
		},
		error: function(){
			console.warn("Erro ao carregar os shoppings");
		}
	});
}

var lojas;
function carregarLojas() {
	lojas = new Array();
	id_shopping = $('#shopping').val();
	$.ajax({data: {id_shopping:id_shopping}, type:'GET', dataType:'json', url:'../admin/getcadastroslojistas',
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

var planos;
function carregarPlanos() {
	planos = new Array();
	$.ajax({type:'GET', dataType:'json', url:'../admin/getplanos',
		success: function(dados){
			$.each(dados, function(i, obj) {
				planos.push(obj);
			});
		},
		error: function(){
			console.warn("Erro ao carregar os planos");
		}
	});
}

function listarPlanos(id_assinatura, id_plano) {
	html = '';
	$.each(planos, function(i, obj) {
		if(obj.id == id_plano)
			html += '<option value='+obj.id+' selected>'+obj.titulo+'</option>';
		else
			html += '<option value='+obj.id+'>'+obj.titulo+'</option>';
	});
	
	$('#plano'+id_assinatura).html(html);
}

function listarEstados() {
	html = '<option>Selecione um estado</option>';
	$.each(estados, function(i, obj) {
		html += '<option value='+obj.id+'>'+obj.nome+'</option>';
	});
	
	$('#estado').html(html);
}

function listarCidades() {
	cidades_selecionadas = new Array();
	$.each(cidades, function(i, obj) {
		if(obj.id_estado == $('#estado').val())
			cidades_selecionadas.push(obj);
	});
	
	html = '<option>Selecione uma cidade</option>';
	$.each(cidades_selecionadas, function(i, obj) {
		html += '<option value='+obj.id+'>'+obj.nome+'</option>';
	});
	
	$('#cidade').html(html);
}


function listarShoppings() {
	shoppings_selecionados = new Array();
	$.each(shoppings, function(i, obj) {
		if(obj.id_cidade == $('#cidade').val())
			shoppings_selecionados.push(obj);
	});
	
	html = '<option>Selecione um shopping</option>';
	$.each(shoppings_selecionados, function(i, obj) {
		html += '<option value='+obj.id+'>'+obj.nome_fantasia+'</option>';
	});
	
	$('#shopping').html(html);
}

function listarLojas() {
	html = ''
		+'<thead>'
		+'	<tr>'
		+'		<th>NOME FANTASIA</th>'
		+'		<th>RAZÃO SOCIAL</th>'
		+'		<th>CATEGORIA</th>'
		+'		<th>TELEFONE</th>'
		+'		<th>EMAIL</th>'
		+'		<th>ASSINATURA</th>'
//		+'		<th>AÇÃO</th>'
		+'	</tr>'
		+'</thead>';
	$.each(lojas, function(i, obj) {
		html += '<tr>'
					+'<td>'+obj.loja.nome_fantasia+'</td>'
					+'<td>'+obj.loja.razao_social+'</td>'
					+'<td>'+obj.categoria+'</td>'
					+'<td>'+obj.telefone+'</td>'
					+'<td>'+obj.loja.email+'</td>'
					+'<td><button onclick="carregarAssinaturas('+obj.loja.id+');$(\'#modalassinaturas\').modal(\'show\');">Editar</button></td>'
//					+'<td>-</td>'
				+'</tr>';
	});
	
	$('#tableEstabelecimentos').html(html);
}

function carregarAssinaturas(id_estabelecimento) {
	assinaturas = new Array();
	$.ajax({data: {id:id_estabelecimento}, type:'GET', dataType:'json', url:'../admin/getassinaturasbyestabelecimento',
		success: function(dados){
			$.each(dados, function(i, obj) {
				assinaturas.push(obj);
			});
			listarAssinaturas();
		},
		error: function(){
			console.warn("Erro ao carregar as assinaturas");
		}
	});
}

function listarAssinaturas() {
	$('#lista_assinaturas').html('');
	$.each(assinaturas, function(i, obj) {
		if(obj.inicio) inicio = obj.inicio; else inicio = '';
		if(obj.fim) fim= obj.fim; else fim = '';
		
		html = ''
			+'<select id="plano'+obj.id+'" name="plano" required><option>Carregando planos...</option></select>';
		if(obj.ativo == 1)
			html += ' Assinatura Ativa <input type="checkbox" name="ativo" id="ativo'+obj.id+'" checked="yes" value="1" title="Assinatura Ativada/Desativada"/>';
		else
			html += ' Assinatura Ativa <input type="checkbox" name="ativo" id="ativo'+obj.id+'" value="1" title="Assinatura Ativada/Desativada"/>';
		html += ''
			+'<br>'
			+'Preço: <input type="text" id="preco'+obj.id+'" name="preco" placeholder="Preço" value="'+obj.preco+'" required>'
			+'<br>'
			+'Desconto: <input type="text" id="desconto'+obj.id+'" name="desconto" placeholder="Desconto" value="'+obj.desconto+'" required>'
			+'<br>'
			+'Data de Início: <input type="text" id="inicio'+obj.id+'" disabled name="inicio" placeholder="Sem limite inicial" value="'+inicio+'" required>'
			+'<br>'
			+'Data do Fim: <input type="text" id="fim'+obj.id+'" name="fim" placeholder="Sem limite" value="'+fim+'" required>'
			+'<br>'
			+'<button onclick="salvarAssinatura('+obj.id+')">Salvar</button>'
			+'<br><br>';
		$('#lista_assinaturas').append(html);
		listarPlanos(obj.id,obj.id_plano);
	});
	
}

function salvarAssinatura(id_assinatura) {
	plano = $('#plano'+id_assinatura+' option:selected').val();
	ativo = $('#ativo'+id_assinatura).val();
	preco = $('#preco'+id_assinatura).val();
	desconto = $('#desconto'+id_assinatura).val();
	inicio = $('#inicio'+id_assinatura).val();
	fim = $('#fim'+id_assinatura).val();
	
	statusMsg = $('#modalassinaturas #statusMsg');
	statusMsg.fadeOut();
	$.ajax({data: {id_assinatura:id_assinatura, plano:plano, ativo:ativo, preco:preco, desconto:desconto, inicio:inicio, fim:fim}, type:'GET', dataType:'json', url:'../admin/salvarassinatura',
		success: function(dados){
			if(dados[0].sucesso) {
				statusMsg.removeClass('label-important');
				statusMsg.addClass('label-success');
			} else {
				statusMsg.removeClass('label-success');
				statusMsg.addClass('label-important');
			} 
			statusMsg.html(dados[0].mensagem);
			statusMsg.fadeIn();
		},
		error: function(){
			console.warn("Erro ao salvar assinatura");
		}
	});
}