<?php 
	include("includes/config.php");
?>

<!doctype html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<title>Smartpanda - O shopping na palma da mão</title>
	<link rel="stylesheet" href="<?php echo $server;?>css/index.css">
	
	<link href='http://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'>
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo $server;?>images/favicon.ico">
</head>
<body class="notLogged">
	<div id="all" class="notLogged">
		<div class="container notLogged">

			<header class="header">
				<div id="headerMain">
					
					<a href="<?php echo $server ?>"><div id="logo"><span>O shopping na palma da mão</span></div></a>

					<div class="auth">
						<a class="btn-auth btn-facebook large" href="#"> Entre com <b>Facebook</b> </a>
						<a class="btn-auth btn-lojista large">Lojista</a>
					</div>
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
						<h5>Encontre os melhores anúncios para seu perfil</h5>	
					</div>

					<div class="exp cart">
						<h5>Só sair para as compras!</h5>	
					</div>

					
				</div>
				
				<div class="algorithms">
					<h3>Através do Facebook entendemos o seu perfil e capturamos seus interesses</h3>
					<h3>O algoritmo inteligente do Smartpanda é capaz de identificar apenas o que é de seu interesse</h3>
					<h3>Você aproveita todos anúncios que o Smartpanda preparou pra você! </h3>
				</div>
				
				
	
			</div>
			

			<div class="download">
				<div class="central main">
					<div class="textDownload">
						Faça o download agora mesmo 
						<br> 
						<a href=""><div class="os android"></div>Android</a> 
						<a href=""><div class="os ios"></div>iPhone</a>
					</div>
					<span>ou</span> 

					<a class="btn-auth btn-facebook large" href="#"> Entre com <b>Facebook</b> </a>
				</div>
			</div>

		</div>
	</div> <!-- all -->

	<footer id="footerMain">
		<div class="central">
			<div class="menuFooter">
				<a href="">Assine um plano</a>
				<a href="">Quem somos</a>
				<a href="">Regras gerais</a>
				<a href="">Blog</a>
				<a href="">Contato</a>
			</div>
		</div>		
	</footer>

	<script src="<?php echo $server;?>js/jquery.1-9-1.min.js"></script>

	<script>
		$(function () {
			var counter = 0, divs = $('.banner, .banner.second');
			
		    function alternateDiv() {
		        divs.hide() // hide all divs
		            .filter(function (index) { return index == counter % 2; }) // figure out correct div to show
		            .fadeIn('fast'); // and show it

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