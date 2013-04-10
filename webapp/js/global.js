var usuarioID = "";
var appId = '225275740933146';
var distanciaMaxima = 0.5; //Em KM
var timeout = 30000; //Em ms

//var servidor = "localhost/panda/sistema/";
var servidor = "smartpanda.com.br/servidor/sistema/";
//var servidor = "192.168.0.19/panda/sistema/";

if((location.href).charAt(7) == 'w' && (location.href).charAt(8) == 'w' && (location.href).charAt(9) == 'w')
	servidor = 'http://www.'+servidor;
else
	servidor = 'http://'+servidor;

window.fbAsyncInit = function() {
  FB.init({
    appId      : appId,
    channelUrl : 'www.smartpanda.com.br/webapp/channel.php',
    status     : true, 
    cookie     : true,
    xfbml      : true,
    oauth      : true,
  });
  FB.Event.subscribe('auth.login', function () {
		window.location = "./";
  });
  FB.Event.subscribe('auth.logout', function () {
		window.location = "./";
  });
  FB.Event.subscribe('auth.statusChange', function(response) {
      if (response.authResponse) {
        // user has auth'd your app and is logged into Facebook
        FB.api('/me', function(me){
        	usuarioID = me.id;
        });
      }
  });

  
};
(function(d){
   var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;}
   js = d.createElement('script'); js.id = id; js.async = true;
   js.src = "//connect.facebook.net/pt_BR/all.js";
   d.getElementsByTagName('head')[0].appendChild(js);
 }(document));

erroFacebook = 0;
function checkLogin() {
	if(erroFacebook == 5) {
		erroFacebook++;
		console.error('Erro ao conectar/autenticar com o Facebook (Javascript)');
//		document.location.reload(true);
//		alert('Erro de autenticação com o Facebook, tente recarregar o site.');
	}
	
	if((!usuarioID) && (erroFacebook < 5)) {
		erroFacebook++;
		FB.init({
		    appId      : appId,
		    channelUrl : 'www.smartpanda.com.br/webapp/channel.php',
		    status     : true, 
		    cookie     : true,
		    xfbml      : true,
		    oauth      : true,
		  });
	     // user has auth'd your app and is logged into Facebook
	     FB.api('/me', function(me){
	    	 usuarioID = me.id;
//	    	 imgSrc = "http://graph.facebook.com/"+me.id+"/picture?type=large";
//	    	 $('#mnUsuario').html(me.name);
//        	 $('#profile-name').html(me.name);
//        	 $('#profile-pic').attr('src',imgSrc);
	     });
	}
	
	setTimeout(checkLogin, 1000);
}

checkLogin();


//##### Index
$('#index').live("pageinit", function() {
	
});

//##### Shoppings
$('#shoppings').live("pageinit", function() {
	obterPosicao();
});

//##### Loja
$('#loja').live("pageinit", function() {
	getEstabelecimentoInfo(id,'lojaNome');
	carregarOfertas('listaOfertas2');
	
	$('#cbCategorias').change(function() {
		selecionarCategoria($(this).val());
	});
});

//##### Acontecendo
$('#acontecendo').live("pageinit", function() {
	getEstabelecimentoInfo(id,'shoppingNome');
	carregarOfertas('listaOfertas');
//	carregarLojas();
	$('#cbCategorias').change(function() {
		selecionarCategoria($(this).val());
	});
});

//##### Detalhes
$('#detalhes').live("pageinit", function() {
	var campanha;
	var oferta;
	carregarDetalhes();
	$( "#popupDialog" ).popup();
	$( "#popupPicture" ).popup();
});


$( document ).on( "pageinit", function() {
    $( ".photopopup" ).on({
        popupbeforeposition: function() {
            var maxHeight = $( window ).height() - 60 + "px";
            $( ".photopopup img" ).css( "max-height", maxHeight );
        }
    });
});

shoppingsLista = "";
pagina = 1;
cache_lat = 0;
cache_long = 0;
function carregarShoppings(latitude, longitude) {
	cache_lat = latitude;
	cache_long = longitude;
	$.mobile.loading( 'show' );
	$.ajax({data: {latitude: latitude, longitude:longitude, p:pagina}, type:'GET', dataType:'json', url:servidor+'getshoppingscomofertas', timeout:timeout,
		success: function(dados){
			$( "#popupInfo1" ).popup( "close" );
			shoppingsProximos = new Array();
			$.each(dados, function(i, obj) {
				if((latitude != 0) && (longitude != 0)) {
//					distancia = calcularDistancia(latitude,longitude,obj.latitude,obj.longitude);
					distancia = obj.distancia;
					dados[i]['distancia'] = distancia; 
//					console.debug(obj.id_facebook+': '+distancia+' km');
					if(distancia <= distanciaMaxima) {
						shoppingsProximos.push(obj);
						
					}
				}
				
			});
			
			//Se nao estiver proximo a nenhum shopping, lista todos
			if(shoppingsProximos.length == 0) shoppingsLista = dados;
			else {
				shoppingsLista = shoppingsProximos;
				if(shoppingsLista.length == 1) window.location = 'acontecendo?id='+shoppingsLista[0].id;
			}
			shoppings = "";
			//Ordena os shoppings pela menor distancia
//			shoppingsLista.sort(function(a,b){return a.distancia - b.distancia;});
			$.each(shoppingsLista, function(i,obj) {
//				console.debug(obj.id_facebook+': '+obj.distancia+' km');
//				$.mobile.loadPage( 'acontecendo?id_shopping='+obj.id, { showLoadMsg: false } );
//				distanciakm = parseFloat(Math.round(obj.distancia * 100) / 100).toFixed(2);
				if(obj.nr_ofertas == 1) qtdAnuncios = '1 anúncio';
				else qtdAnuncios = obj.nr_ofertas+' anúncios';
				shopping = 	'<li>'
								+'<a href="acontecendo?id='+obj.id+'">';
				if((obj.thumb) && (obj.thumb != "")) shopping += '<img src="'+servidor+'../'+obj.thumb+'" />';
				shopping += ''
									+'<h3 id="h3'+obj.id+'">'+obj.nome_fantasia+'</h3>'
									+'<p>'+obj.cidade+' - '+obj.estado+'</p>'
//									+'<p>'+qtdAnuncios+'</p>'
//									+'<p>'+distanciakm+' km</p>'
								+'</a>'
							+'</li>';
				if(obj.nr_ofertas > 0) shoppings += shopping;
			});
			
			
			$('#listaShoppings').append(shoppings);
			$('#listaShoppings').listview("refresh");
//			$('#maisShoppings').fadeIn();
			carregarProximaPagina(latitude,longitude);
			
			$.mobile.loading( 'hide' );
		},
		error: function(){
			$( "#popupInfo1" ).popup( "open" );
			carregarShoppings(latitude,longitude);
			console.warn("Erro ao carregar os shoppings");
		}
	});
}

proximosShoppings = "";
function carregarProximaPagina(latitude,longitude) {
	pagina++;
	$.ajax({data: {latitude: latitude, longitude:longitude, p:pagina}, type:'GET', dataType:'json', url:servidor+'getshoppingscomofertas', timeout:timeout,
		success: function(dados){
			$( "#popupInfo1" ).popup( "close" );
			if(dados != "") {
				$.each(dados, function(i, obj) {
					if(obj.nr_ofertas == 1) qtdAnuncios = '1 anúncio';
					else qtdAnuncios = obj.nr_ofertas+' anúncios';
					shopping = 	'<li>'
									+'<a href="acontecendo?id='+obj.id+'">'
										+'<h3 id="h3'+obj.id+'">'+obj.nome_fantasia+'</h3>'
										+'<p>'+qtdAnuncios+'</p>'
									+'</a>'
								+'</li>';
					proximosShoppings += shopping;
				});	
				
				$('#maisShoppings').fadeIn();
			} else {
				$('#maisShoppings').fadeOut();
			}
			
		},
		error: function(){
			$( "#popupInfo1" ).popup( "open" );
			pagina--;
			carregarProximaPagina(latitude,longitude);
			console.warn("Erro ao carregar mais shoppings");
		}
	});
}

function exibirMaisShoppings() {
	$.mobile.loading( 'show' );
	$('#maisShoppings').fadeOut();

	$('#listaShoppings').append(proximosShoppings);
	$('#listaShoppings').listview("refresh");
	proximosShoppings = "";
	$.mobile.loading( 'hide' );
	carregarProximaPagina(cache_lat,cache_long);
}

function carregarLojas() {
	$.mobile.loading( 'show' );
	$.ajax({data: {id_shopping: id}, type:'GET', dataType:'json', url:servidor+'getlojascomofertas', timeout:timeout,
		success: function(dados){
			$( "#popupInfo1" ).popup( "close" );
			lojas = "";
			$.each(dados, function(i,obj) {
				if(obj.nr_ofertas == 1) qtdAnuncios = '1 anúncio';
				else qtdAnuncios = obj.nr_ofertas+' anúncios';
				loja = 	'<li>'
								+'<a href="loja?id='+obj.id+'">'
									+'<h3 id="h3'+obj.id+'">'+obj.nome_fantasia+'</h3>'
//									+'<p>'+qtdAnuncios+'</p>'
								+'</a>'
							+'</li>';
//				if(obj.nr_ofertas > 0) 
					lojas += loja;
			});
			
			
			$('#listaLojas').append(lojas);
			$('#listaLojas').listview("refresh");
			$('#maisLojas').fadeIn();
			
			$.mobile.loading( 'hide' );
		},
		error: function(){
			$( "#popupInfo1" ).popup( "open" );
			carregarLojas();
			console.warn("Erro ao carregar as lojas com ofertas do shopping");
		}
	});
}

function carregarLojasSemOfertas() {
	$.mobile.loading( 'show' );
	$('#maisLojas').fadeOut();
	$.ajax({data: {id_shopping: id}, type:'GET', dataType:'json', url:servidor+'getlojassemofertas', timeout:timeout,
		success: function(dados){
			$( "#popupInfo1" ).popup( "close" );
			lojas = "";
			$.each(dados, function(i,obj) {
				loja = 	'<li>'
								+'<a href="loja?id='+obj.id+'">'
									+'<h3 id="h3'+obj.id+'">'+obj.nome_fantasia+'</h3>'
								+'</a>'
							+'</li>';
//				if(obj.nr_ofertas == 0)
					lojas += loja;
			});
			
			
			$('#listaLojas').append(lojas);
			$('#listaLojas').listview("refresh");
			
			$.mobile.loading( 'hide' );
		},
		error: function(){
			$( "#popupInfo1" ).popup( "open" );
			carregarLojas();
			console.warn("Erro ao carregar as lojas sem ofertas do shopping");
		}
	});
}

var ofertasDisponiveis = new Array();
function carregarOfertas(listaOfertas) {
	$.mobile.loading( 'show' );
	$.ajax({data: {id: id}, type:'GET', dataType:'json', url:servidor+'getofertasbyid', timeout:timeout,
		success: function(dados){
			if(dados[0]) {
				$( "#popupInfo2" ).popup( "close" );
				ofertas = "";
				ultimaLoja = 0;
				$.each(dados, function(i, obj) {
	//				mapa = '( <a target="_blank" href="https://maps.google.com.br/maps?q='+obj.latitude+',+'+obj.longitude+'&hl=pt-BR&t=h&z=18">Ver No Mapa</a> )';
//					$('#shoppingNome').html(obj.shopping);
					oferta = obj.oferta;
					campanha = obj.campanha;
					ofertasDisponiveis.push(obj.categoria);
					ofertaLI = '';
					if((oferta.id_estabelecimento != id) && (oferta.id_estabelecimento != ultimaLoja)) {
						ultimaLoja = oferta.id_estabelecimento;
						if((oferta.lojista_thumb) && (oferta.lojista_thumb != ""))
							ofertaLI = '<li data-role="list-divider" role="heading" class="ui-li ui-li-divider ui-bar-b"><img alt="Logo" src="'+servidor+'../'+oferta.lojista_thumb+'" style="height:29px;display:block;"><span style="margin-left:40px">'+oferta.lojista+'</span></li>';
						else
							ofertaLI = '<li data-role="list-divider" role="heading" class="ui-li ui-li-divider ui-bar-b">'+oferta.lojista+'</li>';
					}
					ofertaLI += 	'<li class="categorias categoria'+obj.categoria+'">'
									+'<a href="detalhes?id='+oferta.id+'">'
										+'<img src="'+servidor+'../'+oferta.thumb+'" />'
										+'<h3 style="font-size:14px">'+oferta.titulo+'</h3>';
					if(campanha.curtiram > 2)
										ofertaLI += '<p>'+campanha.curtiram+' pessoas gostaram</p>';
					ofertaLI +=''
									+'</a>'
								+'</li>';
					ofertas += ofertaLI;
	
				});
				carregarCategorias();
				$('#'+listaOfertas).append(ofertas);
				$('#'+listaOfertas).listview("refresh");
			} else {
				$('#'+listaOfertas).append('<p style="text-align: center">Nenhum anúncio cadastrado para o seu perfil no momento</p>');
					
			}
			
			$.mobile.loading( 'hide' );
			
//			var usuariosBuscados = new Array();
//			$('.h3Lojista').each(function(){
//				id_facebook = $(this).html();
//				if($.inArray(id_facebook,usuariosBuscados) < 0) {
//					usuariosBuscados.push(id_facebook);
//					$(this).html('Carregando Nome...');
//					FB.api('/'+id_facebook, function(response) {
//						$('.h3'+response.id).attr('title',response.name);
//						$('.h3'+response.id).html(response.name);
//					});
//				}
//			});
		},
		error: function(){
			$( "#popupInfo2" ).popup( "open" );
			carregarOfertas();
			console.warn("Erro ao carregar as ofertas cadastradas");
		}
	});
}


function carregarDetalhes() {
	$.mobile.loading( 'show' );
	$.ajax({data: {id: id_oferta}, type:'GET', dataType:'json', url:servidor+'getoferta', timeout:timeout,
		success: function(dados){
			$( "#popupInfo3" ).popup( "close" );
			ofertas = "";
			oferta = dados[0].oferta;
			campanha = dados[0].campanha;
			validade = dados[0].validade.data_max;
			
			$('#imagem, #imagemZoom').attr('src',servidor+'../'+oferta.imagem);
			$('#lojistaNome').html(oferta.lojista);
			if((oferta.lojista_banner) && (oferta.lojista_banner != "")) {
				$('#banner').html('<div style="text-align:center;"><img alt="logo" src="'+servidor+'../'+oferta.lojista_banner+'" style="height:60px;"></div>');
			}
			$('#titulo').html(oferta.titulo);
			if(validade) $('#titulo').append(' (Validade: '+validade+')');
			$('#texto').html(oferta.texto);
			if(campanha.curtiram > 2) {
				$('#titulo').append('<br><br> <span style="font-size: 14px;"><a href="#" id="btCurtiram" data-role="button" data-icon="check" data-inline="true" data-iconpos="notext"></a>'+campanha.curtiram+' pessoas gostaram disso.</span>');
				$( "#btCurtiram" ).button();
			}
			
			$.mobile.loading( 'hide' );
		},
		error: function(){
			$( "#popupInfo3" ).popup( "open" );
			carregarDetalhes();
			console.warn("Erro ao carregar as ofertas cadastradas");
		}
	});
}

function votarOferta(curtir) {
	$.mobile.loading( 'show' );
	$.ajax({data: {id_campanha: campanha.id, curtir: curtir}, type:'GET', dataType:'json', url:servidor+'curtir', timeout:timeout,
		success: function(dados){
			$('#popMsg').html(dados[0].mensagem);
			if(dados[0].voto) $('#btFacebook').show();
			else $('#btFacebook').hide();
			$('#popupDialog').popup( "open" );
			
			$.mobile.loading( 'hide' );
		},
		error: function(){
			$.mobile.loading( 'hide' );
			console.warn("Erro ao carregar curti/nao curtir a oferta");
		}
	});
}

function compartilharNoFacebook() {
	lojistaNome = $('#lojistaNome').html();
	link = servidor+'../publico/anuncio?id='+oferta.id;
	FB.ui(
			  {
			   method: 'feed',
			   display: 'popup',
			   name: oferta.titulo,
			   caption: oferta.texto,
			   description: (
			      lojistaNome
			   ),
			   link: link,
			   picture: servidor+'../'+oferta.imagem
			  },
			  function(response) {
			    if (response && response.post_id) {
			      console.debug('Compartilhado no Facebook com sucesso.');
			    } else {
			      console.error('Erro ao compartilhar no Facebook.');
			    }
			  }
			);
}


function carregarCategorias() {
	$.ajax({type:'GET', dataType:'json', url:servidor+'getcategorias', timeout:timeout,
		success: function(dados){
			html = '<option value="0">Todas as Categorias</option>';
			$.each(dados.categorias, function(i, obj) {
				if(ofertasDisponiveis.indexOf(obj.id) > -1)
					html += '<option value="'+obj.id+'">'+obj.nome+'</option>';
			});
			$('#cbCategorias').html('');
			$('#cbCategorias').append(html);
		},
		error: function(){
			carregarCategorias();
			console.warn("Erro ao carregar lista de categorias");
		}
	});
}

function selecionarCategoria(id) {
	$('.categorias').removeClass('ui-screen-hidden');
	if(id > 0)
		$('.categorias:not(.categoria'+id+')').addClass('ui-screen-hidden');
}


function getEstabelecimentoInfo(id_estabelecimento, campo) {
	$.ajax({data: {id:id_estabelecimento}, type:'GET', dataType:'json', url:servidor+'getestabelecimento', timeout:timeout,
		success: function(dados){
			if(dados[0].tipo == 4) {
				$('#'+campo).html(dados[0].nome_fantasia);
				if(dados[0].banner) {
					banner = '<img src="'+servidor+'../'+dados[0].banner+'" style="height:85px;margin-bottom:10px;">';
					$('#banner').html(banner);
				}
			} else {
				$('#'+campo).html(dados[0].nome_fantasia);
				getEstabelecimentoInfo(dados[0].id_shopping,'shoppingdolojistaNome');
			}

		},
		error: function(){
			carregarCategorias();
			console.warn("Erro ao carregar informações do estabelecimento");
		}
	});
}

//Geolocalizacao***
function obterPosicao() {
	if(navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(geoSucesso,geoErro, {
			enableHighAccuracy: true,
			timeout: 5000, //5s
			maximumAge:300000 //5min
		});
	} else {
		console.warn("O navegador não suporta Geolocation");
		carregarShoppings(0,0);
	}
}

function geoSucesso(position) {
	latitude = position.coords.latitude;
	longitude = position.coords.longitude;
	
	console.debug("Latitude: "+latitude);
	console.debug("Longitude: "+longitude);
	
	carregarShoppings(latitude,longitude);
}

function geoErro(err) {
	switch (err.code) {
		case 1 :
			console.error("A permissão para obter a geolocalizacao foi negada");
			break;
		case 2 :
			console.error("Não foi possivel estabelecer uma conexao para obter a geolocalizacao");
			break;
		case 3 :
			console.error("Tempo Esgostado ao tentar obter a geolocalizacao");
			break;
		default:
			console.error("Erro ao obter a geolocalizacao");
	}
	
	carregarShoppings(0,0);
}

function calcularDistancia(lat1,lon1,lat2,lon2) {
	var R = 6371; // km
	var dLat = toRad((lat2-lat1));
	var dLon = toRad((lon2-lon1));
	var lat1 = toRad(lat1);
	var lat2 = toRad(lat2);
	
	var a = Math.sin(dLat/2) * Math.sin(dLat/2) +
    Math.sin(dLon/2) * Math.sin(dLon/2) * Math.cos(lat1) * Math.cos(lat2); 
	var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
	var d = R * c;
	
	return d;
}

function toRad(Value) {
    /** Converts numeric degrees to radians */
    return Value * Math.PI / 180;
}

function getnomeCidade() {
	latlng = latitude+','+longitude;
	$.ajax({data: {latlng:latlng, sensor:'true'}, type:'GET', dataType:'json', url:'http://maps.googleapis.com/maps/api/geocode/json', timeout:timeout,
		success: function(dados){
			

		},
		error: function(){
			carregarCategorias();
			console.warn("Erro ao carregar nome da cidade");
		}
	});
}

//***Geolocalizacao