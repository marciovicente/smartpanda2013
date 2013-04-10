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
					<div id="logo"><span>O shopping na palma da mão</span></div>
					<div id="statusLogin">
						
						<img src="https://fbcdn-profile-a.akamaihd.net/hprofile-ak-ash3/195225_100001708066608_415344984_q.jpg" alt="">
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
						<img src="http://img.clasf.com.br/2013/03/18/Cadeira-de-Madeira-Envernizada-Tok-Stok-Bom-estado-de-20130318181138.jpg" alt="" class="imgOferta">
						<div id="infoOferta">
							<h2>Cadeira Tok Stok de madeira maciça com 70%</h2>
							<a href="#"><h4><i class="icon icon-gift"></i>Ual Modas</h4></a>
							<a href=""><h4><i class="icon icon-tags"></i>Shopping Iguatemi</h4></a>
							<article class="articleOferta">
								Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
								tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
								quis nostrud exercitation ullamco. <br><span class="validadeOferta"></span>
							</article>
							<div id="validade"></div>
							
							<nav id="barOferta">
								<a href=""><span class="spriteDestaque like"></span>Gostei <span class="curtiram"></span></a>
								<div class="innerLine"></div>
								<a href=""><span class="spriteDestaque dislike"></span>Não gostei <span class="curtiram"></span></a>
								<div class="innerLine"></div>
								<a href=""><span class="spriteDestaque pin"></span>Reservar <span class="curtiram"></span></a>
								<div class="innerLine"></div>
								<a href=""><span class="spriteDestaque like"></span>Compartilhar <span class="curtiram"></span></a>
								<div class="innerLine"></div>
								<a href=""><span class="spriteDestaque like"></span>Comentar <span class="curtiram"></span></a>
								<div class="innerLine"></div>

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
		$(window).ready(function(){
			var id_oferta = <?php echo $id; ?>;
			carregaDetalhes(id_oferta);
		});

		
	</script>
</body>
</html>