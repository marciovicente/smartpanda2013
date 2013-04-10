$(document).ready(function() {
	$('.dica + span').css({display:'none', 
						border:'1px solid #959595',
						borderRadius:'8px',
						padding:'2px 4px',
						color:'#fff',
						background:'#7BA13C',
						marginLeft:'10px'
	});
	$('.dica').focus(function() {
		$(this).next().fadeIn(500);
	}).blur(function() {
		$(this).next().fadeOut(500);
	});
	
    $( "#from" ).datepicker({
        minDate:0,
        showOtherMonths: true,
        selectOtherMonths: true,
        showAnim: 'slideDown',
        onClose: function( selectedDate ) {
            $( "#to" ).datepicker( "option", "minDate", selectedDate );
        }
    });
    $( "#to" ).datepicker({
        minDate:0,
        showOtherMonths: true,
        selectOtherMonths: true,
        showAnim: 'slideDown', 
        onClose: function( selectedDate ) {
            $( "#from" ).datepicker( "option", "maxDate", selectedDate );
        }
    });
    
    $('#formCadastro').submit(function() { 
    	if(uploadSize('imagem') > 5242880) {
    		$.alert('','Imagem grande demais (Maior que 5MB).');
    		return false;
    	}

    });
    
    $('#maior_idade').click(function() {
    	if(($('#maior_idade').attr('checked')) && ($('#idade_min').val() < 18)) {
    		$('#idade_min').val(18);
    	}
    });
    
    $('#idade_min').keypress(function() {
    	if($('#idade_min').val() < 18)
    		$('#maior_idade').removeAttr('checked');
    });
    
});


function countChar(campo){
    var len = $(campo).val().length;
    restantes = 120 - len;
    
    $('#restantes').html(restantes);
};

function uploadSize(inputID) {
	myFile = document.getElementById(inputID);
	if(myFile.files.length == 1)
		return myFile.files[0].size;
	else
		return 0;
}

