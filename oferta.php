<?php $id = $_GET['id']; ?>
<!doctype html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<title>Smartpanda - O shopping na palma da mão</title>
	<link rel="stylesheet" href="css/index.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link href='http://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'>
	<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
</head>
<body>
	<div id="all">
		<div id="container">
			<header id="header">
				<div class="central">
					<a href="http://smartpanda.com.br"><div id="logo"><span>O shopping na palma da mão</span></div></a>
					<div id="statusLogin">
						
						<img src="" alt="">
						<div id="profile">
							<h6>Márcio Vicente Santos </h6>
							<a href="#" class="logout"> <i class="icon icon-white icon-remove"></i>Sair</a>
							
							<i class="icon icon-white icon-chevron-down"></i>
						</div>
					</div>
				</div>

			
			</header>


			<div class="central">
				<section id="firstContainer">
					<div id="oferta">
						<img src="" alt="" class="imgOferta">
						<div id="infoOferta">
							<h2></h2>
							<a href="#"><h4><i class="icon icon-gift"></i></h4></a>
							<a href=""><h4 class="shoppingName"><i class="icon icon-tags"></i></h4></a>
							<article class="articleOferta">
							
							<br><span class="validadeOferta"></span>
							</article>
							<div id="validade"></div>
							
							<nav id="barOferta">
								<a href=""><span class="spriteInteracao like"></span><h5>Gostei</h5> <span class="curtiram"></span></a>
								<div class="innerLine"></div>
								<a href=""><span class="spriteInteracao dislike"></span><h5>Não gostei</h5></a>
								<div class="innerLine"></div>
								<a href=""><span class="spriteInteracao reservar"></span><h5>Reservar</h5></a>
								<div class="innerLine"></div>
								<a href=""><span class="spriteInteracao share"></span><h5>Compartilhe</h5></a>
							</nav>
						</div>
					</div>
				</section>

					
			</div>
		</div>
	</div>

	<footer id="footer">
		<div class="central">
			
			
		</div>
	</footer>
	
	<script src="js/jquery.1-9-1.min.js"></script>
	<script src="js/global.js"></script>
	<script src="js/bootstrap.min.js"></script>

	<script>
		$(document).ready(function(){
			
			var id_oferta = <?php echo $id; ?>;
			carregaDetalhes(id_oferta);
			getShoppingName(oferta.id_estabelecimento); 
			
			checkLogin();
			imgSrc = "http://graph.facebook.com/"+usuarioID+"/picture?type=small";
			$('#statusLogin img').attr('src',imgSrc);
		});

		
	</script>
</body>
</html>