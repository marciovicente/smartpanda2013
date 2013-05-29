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
	<link rel="stylesheet" type="text/css" href="<?php echo $server; ?>css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $server; ?>css/font-awesome.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $server; ?>css/parallax.css">
</head>
<body class="notLogged">
	<div id="all" class="notLogged">
		<div class="container notLogged">

			<header class="header">
				<div id="headerMain">
					
					<a href="<?php echo $server ?>"><div id="logo"><span>O shopping na palma da mão</span></div></a>

					<div class="auth">
						<!-- <span>Cadastre-se agora</span> -->
						<a class="btn-auth btn-facebook large" href="#"> Conecte-se <b>Facebook</b> </a>
						<a class="btn-auth btn-lojista large" href="<?php echo $server ?>lojista.php">Área do Lojista</a>
					</div>
				</div>
			</header>

			<div id="da-slider" class="da-slider">
 
			    <div class="da-slide">
			        <h2>Encontre tudo o que você precisa <br>	
					com o shopping na palma da mão</h2>
			        <p>
			        	<button class="getButton" onclick="location.href='https://play.google.com/store/apps/details?id=com.bambooss.smartpanda'" ><span>Instale agora mesmo</span> <div class="androidIcon"></div> <h6>Versão 1.2.4 no Google Play</h6> </button>
						<button class="getButton web"><span>Acesse agora</span>  <i class="icon-laptop"></i> <h6>pelo seu computador</h6> </button>
						<button class="getButton apple"><span>Em desenvolvimento.</span>  <div class="appleIcon"></div> <h6>Breve na App Store</h6> </button>

			        </p>
			        <div class="da-img">
			            <img src="images/devices.png" alt="Smartpanda em diversos aparelhos" />
			        </div>
			    </div>

			    <div class="da-slide">
			        <h2>Em qualquer lugar, <br>	
					de qualquer dispositivo.</h2>
			        <p>
			        	<button class="getButton" onclick="location.href='https://play.google.com/store/apps/details?id=com.bambooss.smartpanda'" ><span>Instale agora mesmo</span> <div class="androidIcon"></div> <h6>Versão 1.2.4 no Google Play</h6> </button>
						<button class="getButton web"><span>Acesse agora</span>  <i class="icon-laptop"></i> <h6>pelo seu computador</h6> </button>
						<button class="getButton apple"><span>Em desenvolvimento.</span>  <div class="appleIcon"></div> <h6>Breve na App Store</h6> </button>

			        </p>
			        <div class="da-img">
			            <img src="images/nexus2.png" alt="Smartpanda Nexus" />
			        </div>
			    </div> 

			    <div class="da-slide">
			        <h2>Em qualquer lugar, <br>	
					de qualquer dispositivo.</h2>
			        <p>
			        	<button class="getButton" onclick="location.href='https://play.google.com/store/apps/details?id=com.bambooss.smartpanda'" ><span>Instale agora mesmo</span> <div class="androidIcon"></div> <h6>Versão 1.2.4 no Google Play</h6> </button>
						<button class="getButton web"><span>Acesse agora</span>  <i class="icon-laptop"></i> <h6>pelo seu computador</h6> </button>
						<button class="getButton apple"><span>Em desenvolvimento.</span>  <div class="appleIcon"></div> <h6>Breve na App Store</h6> </button>

			        </p>
			        <div class="da-img">
			            <img src="images/iphone.png" alt="Smartpanda Iphone" />
			        </div>
			    </div>

			    
			     
			    
			     
			    <nav class="da-arrows">
			        <span class="da-arrows-prev"></span>
			        <span class="da-arrows-next"></span>
			    </nav>
			     
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
						<h5>Encontre os melhores produtos para seu perfil</h5>	
					</div>

					<div class="exp cart">
						<h5>Só sair para as compras!</h5>	
					</div>

					
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

	<footer id="footerMain" class="notLogged">
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
	<script src="<?php echo $server;?>js/bootstrap.modal.js"></script>
	<script src="<?php echo $server;?>js/modernizr.custom.28468.js"></script>
	<script src="<?php echo $server;?>js/jquery.cslider.js"></script>

	<script>

	
		$('#da-slider').cslider({
	 
		    current     : 0,    
		    bgincrement : 50,   
		    autoplay    : true,
		    interval    : 6000 
		     
		});

	
		// $(function () {
		// 	var counter = 0, divs = $('.banner, .banner.second');
			
		//     function alternateDiv() {
		//         divs.hide() // hide all divs
		//             .filter(function (index) { return index == counter % 2; }) // figure out correct div to show
		//             .fadeIn('slow'); // and show it

		//         counter++;
		//     }; 

		//     alternateDiv(); 
		    
		//     setInterval(function () {
		//         alternateDiv(); 
		//     }, 6 * 1000); 


			

		// });

	</script>
</body>
</html>