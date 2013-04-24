<?php 
	// $server = "http://smartpanda.com.br/smartpanda2013/";
	$server = "http://localhost:8080/smartpanda2013/";
	// $server = "http://localhost:8887/smartpanda2013/";
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
<body class="notLogged">
	<div id="all" class="notLogged">
		<div class="container">

			<header class="header">
				<div id="headerMain">
					
					<a href="<?php echo $server ?>"><div id="logo"><span>O shopping na palma da mão</span></div></a>

					<a class="btn-auth btn-facebook large" href="#"> Entre com <b>Facebook</b> </a>
				</div>
			</header>
			<div class="banner">
				<div class="central">
					<h2>Encontre tudo o que você precisa</h2>
					<h3>com o shopping na palma da mão</h3>
					<h3>(ou na tela do computador)</h3>
					<button class="getButton"><span>Instale agora mesmo</span> <div class="androidIcon"></div> <h6>Versão 2.1 no Google Play</h6> </button>
					<button class="getButton apple"><span>Instale agora mesmo</span>  <div class="appleIcon"></div></button>
				</div>
			</div>

			<div class="banner second">
				<div class="central">
					<div class="leftBanner">
						<h2>Em qualquer lugar,</h2>
						<h3>de qualquer dispositivo</h3>
						<button class="getButton"><span>Instale agora mesmo</span> <div class="androidIcon"></div> <h6>Versão 2.1 no Google Play</h6> </button>
						<button class="getButton apple"><span>Instale agora mesmo</span>  <div class="appleIcon"></div></button>

					</div>
				</div>
			</div>

			<div class="central">
				<h1>Como Funciona</h1>
				<div class="iconsBio">
					<div class="exp smartphone">
						<h5>Instale o aplicativo em seu smartphone ou acesse pelo site</h5>	
					</div>

					<div class="exp pin">
						<h5>Localize o shopping mais próximo ou de sua preferência</h5>	
					</div>

					<div class="exp deal">
						<h5>Encontre as melhores ofertas para seu perfil</h5>	
					</div>

					<div class="exp cart">
						<h5>Só sair para as compras!</h5>	
					</div>

					
				</div>
				
				<div class="algorithms">
					

				profile icon - caracteristicas - algoritmo - explicar processo
				</div>
				
				
				<!-- <div id="leftMain">
					
				</div>
				
				<div id="rightMain">
					<h3>Baixe agora mesmo no seu smartphone</h3>
					<div id="galaxy">
						<a href=""><img src="images/gplay.png" alt="Google play icon"></a>
					</div>
					<div id="iphone">
						<h2>BREVE!</h2>
					</div>
					
				</div> -->
			</div>
			

			<div class="download">
				<div class="central">
					<h3>
						Faça o download agora mesmo 
						<br> 
						<a href="">Android</a> 
						<a href="">iPhone</a>
					</h3>
					<span>ou</span> 

					<a class="btn-auth btn-facebook large" href="#"> Entre com <b>Facebook</b> </a>
				</div>
			</div>

		</div>
	</div> <!-- all -->

	<footer id="footerMain">
		
	</footer>

	<script src="<?php echo $server;?>js/jquery.1-9-1.min.js"></script>

	<script>
		$(function () {
			var counter = 0, divs = $('.banner, .banner.second');
			
		    function alternateDiv() {
		        divs.hide() // hide all divs
		            .filter(function (index) { return index == counter % 2; }) // figure out correct div to show
		            .fadeIn('slow'); // and show it

		        counter++;
		    }; 

		    alternateDiv(); 

		    setInterval(function () {
		        alternateDiv(); 
		    }, 6 * 1000); 


			$('.getButton.apple').hover(function() {
				$(this).fadeIn().html('<span>Em breve!</span> <div class="appleIcon"></div>');
			});

			$('.getButton.apple').mouseleave(function() {
				$(this).html('<span>Instale agora mesmo</span> <div class="appleIcon"></div>');
			});

		});







		
	</script>
</body>
</html>