<?php 
	// $server = "http://smartpanda.com.br/smartpanda2013/";
	$server = "http://localhost:8080/smartpanda2013/";
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
	<div id="all">
		<div id="container">
			<header id="header">
				<div class="central">
					<a href="<?php echo $server ?>"><div id="logo"><span>O shopping na palma da mão</span></div></a>
					<div id="statusLogin">
						
						<img src="" alt="">
						<div id="profile">
							<h6>Márcio Vicente Santos </h6>
							<a href="#" class="logout"> <i class="icon icon-white icon-remove"></i>Sair</a>
							
							<i class="icon icon-white icon-chevron-down"></i>
						</div>
					</div>
				</div>

				<div id="filter">
					<div class="central">
						<form action="" id="formQuery">
							<select name="cbCategorias" id="cbCategorias" title="Filtrar por Categoria">
								<option value="0">Todas as Categorias</option>
							</select>
							
							<select name="selectShAtivos" id="selectShAtivos" title="Filtrar por Shopping">
								<option value="0">Todos os shoppings</option>
							</select>
								
						</form>
					</div>
				</div>
			</header>


			<div class="central">
				<section id="firstContainer">
					
					<div id="paperFolding">
						<button class="folding"><h4><div class="categoriaIcon roupas"></div>  Roupas e Acessórios</h4></button>
						<button class="folding"><h4><div class="categoriaIcon praia"></div>Moda praia</h4></button>
						<button class="folding"><h4><div class="categoriaIcon informatica"></div>Informática</h4></button>
						<button class="folding"><h4><div class="categoriaIcon categoria6"></div>Esportes/Fitness</h4></button>
						<button class="folding"><h4><div class="categoriaIcon categoria18"></div>Turismo</h4></button>	
						<button class="folding"><h4><div class="categoriaIcon joias"></div>Jóias</h4></button>	
						<button id="footerFolding"><h4><i class="icon icon-white icon-plus"></i> Ver todas categorias</h4></button>

					</div>

					
					<div id="destaque" class="praia">
						<div id="fotoDestaque">
						<!--	<div class="filterCategoria praia"><div class="categoriaIcon praia"></div></div> -->
							<a href="#">
								<img src="http://amorume.com.br/wp-content/uploads/2013/03/veludo.jpg" alt="Sapato de Marca">
							</a>
						</div>
						<a href=""><div id="ribbon"><div class="pinIcon"></div></div></a>
						<div id="ofertaDestaque" >
							<h3>Saia de Veludo 70% OFF no Iguatemi</h3>
							<a href="#"> <h4><i class="icon icon-tags"></i> Arezzo Sport Fino</h4></a>
							<a href=""><h4><i class="icon icon-bookmark"></i> Shopping Paseo Itaigara</h4></a>
							<article class="descOfertaDetalhe">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
							tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
							quis nostrud exercitation ullamco. </article>
						</div>
						
						<div id="barDestaque">
							<button class="btnDestaque" onclick="event.preventDefault(); gostar(1, 199, $(this)); "> <div class="spriteDestaque like"></div> <h5>Gostei</h5> <span>137</span> </button>
							<button class="btnDestaque" onclick="event.preventeDefault(); gostar(0, 199); "><div class="spriteDestaque dislike"></div> <h5>Não gostei</h5></button>
							<button class="btnDestaque"><div class="spriteDestaque share"></div> <h5>Share</h5></button>
							
							<button class="btnDestaque"><div class="spriteDestaque reservar"></div> <h5>Reservar</h5></button>
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

	<footer id="footer">

	</footer>
	
	<script src="<?php echo $server;?>js/jquery.1-9-1.min.js"></script>
	<script src="<?php echo $server;?>js/index.js"></script>
	<script src="<?php echo $server;?>js/global.js"></script>
	<script src="<?php echo $server;?>js/bootstrap.min.js"></script>
	<script src="<?php echo $server;?>js/jquery.sharrre-1.3.4.min.js"></script>

	<script>
		
		// (function ($) { 
		// 	var control = 0;
		// 	$('#cbCategorias').change(function(){
		// 		var cat = $(this).val();
		// 		if(cat == 0)
		// 			$('.ofertaUnique').show();
		// 		else{
		// 			$('.ofertaUnique').show();
		// 			$('.ofertaUnique').not('.categoria'+cat+'').hide();
		// 		}
				
		// 		// depois escolher um efeito legal

		// 		$("#selectShAtivos option").change(function(){
		// 			// var id_shopping = $(this).val();
		// 			// carregarOfertas(id_shopping);
		// 			alert($(this).val());
		// 		});
		// 	});

 			
		// })(jQuery)

		$(document).ready(function(){
			$('#textLoading').addClass('animated tada');
			getShoppingsAtivos(1);
			carregarCategorias();
			var id_shopping = 14;		
			carregarOfertas(id_shopping);
			checkLogin();
		});







		
	</script>
</body>
</html>