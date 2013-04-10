jQuery(function($){
    $.datepicker.regional['pt-BR'] = {
            closeText: 'Fechar',
            prevText: '&#x3c;Anterior',
            nextText: 'Pr&oacute;ximo&#x3e;',
            currentText: 'Hoje',
            monthNames: ['Janeiro','Fevereiro','Mar&ccedil;o','Abril','Maio','Junho',
            'Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
            monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun',
            'Jul','Ago','Set','Out','Nov','Dez'],
            dayNames: ['Domingo','Segunda-feira','Ter&ccedil;a-feira','Quarta-feira','Quinta-feira','Sexta-feira','Sabado'],
            dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sab'],
            dayNamesMin: ['Dom','Seg','Ter','Qua','Qui','Sex','Sab'],
            weekHeader: 'Sm',
            dateFormat: 'dd/mm/yy',
            firstDay: 0,
            isRTL: false,
            showMonthAfterYear: false,
            yearSuffix: ''};
    $.datepicker.setDefaults($.datepicker.regional['pt-BR']);
});

(function($) {
	$.alert = function(msgTitulo, msgTexto) {
		if(msgTitulo == '') { msgTitulo = 'Smart Panda'; }
		html = ''
				+'<div id="msgBox" title="'+msgTitulo+'">'
				+'<p>'+msgTexto+'</p>'
				+'</div>';
		$('body').append(html);
		$( "#msgBox" ).dialog({ buttons: { "Ok": function() { $(this).dialog("close"); } } });
	}
})(jQuery);

(function($) {
	$.confirm = function(msgTitulo, msgTexto, callback) {
		if(msgTitulo == '') { msgTitulo = 'Smart Panda'; }
		html = ''
				+'<div id="msgConfirm" title="'+msgTitulo+'">'
				+'<p>'+msgTexto+'</p>'
				+'</div>';
		$('body').append(html);
		$( "#msgConfirm" ).dialog({ buttons: { "Confirmar": function() { callback(); }, "Cancelar": function() { $(this).dialog("close"); } } });
	}
})(jQuery);

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