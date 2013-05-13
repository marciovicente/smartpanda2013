<?php 
	include("includes/config.php");


?>

<!doctype html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<title>Smartpanda - O shopping na palma da mão</title>
	<link rel="stylesheet" href="<?php echo $server;?>css/index.css">
	<link rel="stylesheet" href="<?php echo $server;?>css/bootstrap.min.css">
	<link href='http://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'>
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo $server;?>images/favicon.ico">
</head>
<body>
	<!-- <div class="overlayLoad">
		<div class="loaderSp">
			<span>Carregando</span>
		</div>
	</div> -->
	<div class="countFilter">A busca retornou <span></span> <button class="limpar"> <span class="inner"><i class="icon icon-white icon-trash"></i> <h6>Limpar</h6></span> </button></div>
	<div id="all">
		<div id="container">
			<?php include("includes/header.php"); ?>


			<div class="central">
				<section id="firstContainer">
					
					<div id="paperFolding">
						<button class="folding"><h4><div class="categoriaIcon roupas"></div>  Roupas e Acessórios</h4></button>
						<button class="folding"><h4><div class="categoriaIcon praia"></div>Moda praia</h4></button>
						<button class="folding"><h4><div class="categoriaIcon informatica"></div>Informática</h4></button>
						<button class="folding"><h4><div class="categoriaIcon categoria6"></div>Esportes/Fitness</h4></button>
						<button class="folding"><h4><div class="categoriaIcon categoria18"></div>Turismo</h4></button>	
						<button class="folding"><h4><div class="categoriaIcon joias"></div>Jóias</h4></button>	
						<button id="footerFolding"  data-toggle="modal" data-target="#modalCategorias"><h4><i class="icon icon-white icon-plus"></i> Ver todas categorias</h4></button>

					</div>

					<div id="modalCategorias" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							<h3 id="myModalLabel">Selecione uma ou mais categorias</h3>
							<button class="selectAll">Selecionar todas</button>
						</div>
						
						<div class="modal-body" >
							<button class="categoria categoria1">
								<div class="icon"></div>
								<h6>NomeDaCategoria</h6>
							</button>

							<button class="categoria categoria2">
								<div class="icon"></div>
								<h6>NomeDaCategoria</h6>
							</button>

							<button class="categoria categoria3">
								<div class="icon"></div>
								<h6>NomeDaCategoria</h6>
							</button>

							<button class="categoria categoria4">
								<div class="icon"></div>
								<h6>NomeDaCategoria</h6>
							</button>

							<button class="categoria categoria5">
								<div class="icon"></div>
								<h6>NomeDaCategoria</h6>
							</button>

							<button class="categoria categoria6">
								<div class="icon"></div>
								<h6>NomeDaCategoria</h6>
							</button>

							<button class="categoria categoria7">
								<div class="icon"></div>
								<h6>NomeDaCategoria</h6>
							</button>

							<button class="categoria categoria8">
								<div class="icon"></div>
								<h6>NomeDaCategoria</h6>
							</button>

							<button class="categoria categoria9">
								<div class="icon"></div>
								<h6>NomeDaCategoria</h6>
							</button>

							<button class="categoria categoria10">
								<div class="icon"></div>
								<h6>NomeDaCategoria</h6>
							</button>

							<button class="categoria categoria11">
								<div class="icon"></div>
								<h6>NomeDaCategoria</h6>
							</button>

							<button class="categoria categoria12">
								<div class="icon"></div>
								<h6>NomeDaCategoria</h6>
							</button>

							<button class="categoria categoria13">
								<div class="icon"></div>
								<h6>NomeDaCategoria</h6>
							</button>

							<button class="categoria categoria14">
								<div class="icon"></div>
								<h6>NomeDaCategoria</h6>
							</button>

							<button class="categoria categoria15">
								<div class="icon"></div>
								<h6>NomeDaCategoria</h6>
							</button>

							<button class="categoria categoria16">
								<div class="icon"></div>
								<h6>NomeDaCategoria</h6>
							</button>

							<button class="categoria categoria17">
								<div class="icon"></div>
								<h6>NomeDaCategoria</h6>
							</button>

							<button class="categoria categoria18">
								<div class="icon"></div>
								<h6>NomeDaCategoria</h6>
							</button>

							<button class="categoria categoria19">
								<div class="icon"></div>
								<h6>NomeDaCategoria</h6>
							</button>

						</div>
						
						<div class="modal-footer">
							<button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
							<button class="btn btn-primary btn-success">Atualizar</button>
						</div>
					</div>
					
					<div id="destaque" class="praia">
						<div id="fotoDestaque">
						<!--	<div class="filterCategoria praia"><div class="categoriaIcon praia"></div></div> -->
							<a href="#">
								<img src="" alt="">
							</a>
						</div>
						<button class="ribbon" class="notAvailable" title="Reservar: Em breve"><div class="pinIcon"></div></button>
						<div id="ofertaDestaque" >
							<h3></h3>
							<h4><i class="icon icon-tags"></i> </h4>
							<h4><i class="icon icon-bookmark"></i> </h4>
							<article class="descOfertaDetalhe"> </article>
						</div>
						
						<div id="barDestaque">
							<button class="btnDestaque" onclick="event.preventDefault(); gostar(1, 199, $(this)); "> <div class="spriteDestaque like"></div> <h5>Gostei</h5> <span>0</span> </button>
							<button class="btnDestaque" onclick="event.preventeDefault(); gostar(0, 199); "><div class="spriteDestaque dislike"></div> <h5>Não gostei</h5></button>
							<button class="btnDestaque"><div class="spriteDestaque share "></div> <h5>Compartilhe</h5></button>
							
							<!-- <button class="btnDestaque"><div class="spriteDestaque reservar"></div> <h5>Reservar</h5></button> -->
							<!-- trocar favorito, nao existira, entrara Reservar -->
							
							<button class="btnDestaque"><div class="spriteDestaque comment"></div> <h5>Comentar</h5></button>
							
						</div>

					</div>
				</section>

				<section id="listaOfertas">
					<p id="textLoading">Carregando ofertas...</p>
					
					<div class="groupOfertas">
					
						<!-- <a href="#" class="ofertaUnique categoria18">
							<div class="imageOferta">
								<img src="https://img.getyourguide.com/img/tour_img-19091-21.jpg" alt="">

								<div class="desc categoria18">
									<h5>Tênis nike com 70% de desconto</h5>
									<h6>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco.</h6>
								</div>
							</div>
							<div class="bottomBar">
								<button class="btnBar like"></button>
								<div class="innerLine"></div>
								<button class="btnBar dislike"></button>
								<div class="innerLine"></div>
								<button class="btnBar share"></button>
								<div class="innerLine"></div>
								<button class="btnBar comment"></button>
								<div class="innerLine"></div>
								<button class="btnBar pin"></button>
								
							</div>
						</a>

						 -->
					</div>

					
					
				</section>
			</div>
			<div class="footerPush"></div>
		</div>
	</div> <!-- all -->

	<footer id="footerMain">
		<div class="central">
			<div class="menuFooter">
				<a href="">Assine um plano</a>
				<a href="about.php">Quem somos</a>
				<a href="">Regras gerais</a>
				<a href="">Blog</a>
				<a href="">Contato</a>
			</div>
		</div>		
	</footer>
	
	<script src="<?php echo $server;?>js/jquery.1-9-1.min.js"></script>
	<script src="<?php echo $server;?>js/global.js"></script>
	<script src="<?php echo $server;?>js/jquery.tooltipster.min.js"></script>
	<script src="<?php echo $server;?>js/bootstrap.min.js"></script>
	<script src="<?php echo $server;?>js/browser.js"></script>
	<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

	<script type="text/javascript">
		
		$('#searchInput').on('keyup', function(e) {
			var query = $(this).val().toLowerCase();
			query = removeAcentos(query);
			
			$('.ofertaUnique').each(function(){
				obj_txt = $(this).find('h5,h6').text();
				obj_txt = removeAcentos(obj_txt);
				obj_txt = obj_txt.toLowerCase();
				if(obj_txt.indexOf(query) < 0){
					$(this).attr('style','');	
					$(this).addClass('hide');
				}
				else
					$(this).removeClass('hide');
			});


			//adicionando contador
			var i = 0;
			$('.ofertaUnique').each(function(){
				if(!$(this).hasClass('hide'))
					i++;
				
			});

			if(query == '' || query == ' '){
				$('.countFilter').removeClass('show');
				$('.ofertaUnique').removeClass('hide');
			}else{

				if(i == 0){
					$('.countFilter > span').html("nenhum anúncio, tente outro termo");
					$('.countFilter').addClass('danger');
				}else{
					$('.countFilter').removeClass('danger');
					$('.countFilter > span').html("<b>"+i+"</b> anúncio(s)");
				}
					
				$('.countFilter').addClass('show');
				$("html, body").animate({ scrollTop: 370 }, "slow");
				
			}

			$('.countFilter button.limpar').click(function(){
				$('.countFilter').removeClass('show');
				$('#filter #searchInput').val('');
				$('.ofertaUnique').removeClass('hide');
			});



		});


		function removeAcentos(e){
			e = e.replace(/[áàâã]/g,'a').replace(/[éèê]/g,'e').replace(/[óòôõ]/g,'o').replace(/[úùû]/g,'u').replace(/[íìî]/g,'i');
			return e;
		}

		$(document).ready(function(){
			
			$('#textLoading').addClass('animated tada');
			var id_shopping = 14;	
			carregaDestaque(id_shopping);	
			getShoppingsAtivos(1);
			carregarCategorias();
			carregarOfertas(id_shopping);

			checkLogin();

		});


		(function ($) { 


			
			$('#cbCategorias').change(function(){
				var cat = $(this).val();
				if(cat == 0)
					$('.ofertaUnique').show();
				else{
					$('.ofertaUnique').show();
					$('.ofertaUnique').not('.categoria'+cat+'').hide();

					var i = 0;
					$('.ofertaUnique categoria'+cat+'').each(function(){
						i++;
					});
					
					if(i == 0)
						$('#listaOfertas').html("<h1 class='noHas'>Não há ofertas com o filtro desejado</h1>");
						
					
				}
			
			});
			
			$("#selectShAtivos option").change(function(){
				// var id_shopping = $(this).val();
				// carregarOfertas(id_shopping);
				alert($(this).val());
			});

			$('button.categoria').click(function(){
				if($(this).hasClass('active'))
					$(this).removeClass('active');
				else
					$(this).addClass('active');
			});

			$('.modal-header button.selectAll').click(function(){
				if($(this).hasClass('remove')){
					$(this).removeClass('remove');
					$(this).html('Selecionar todas');
					$('button.categoria').removeClass('active');
				}else{
					$(this).html('Desmarcar todas');
					$(this).addClass('remove');
					$('button.categoria').addClass('active');
				}
			});	

			$('.modal-footer .btn-primary').click(function(){
				//aqui faz a seleção e atualiza na index
			});
 			
		})(jQuery)




		
	</script>
</body>
</html>