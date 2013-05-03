<?php 
	include("includes/config.php");
?>

<!doctype html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<title>Quem somos - Smartpanda</title>
	<link rel="stylesheet" href="<?php echo $server;?>css/index.css">
	
	<link href='http://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'>
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo $server;?>images/favicon.ico">
	<link rel="stylesheet" type="text/css" href="<?php echo $server; ?>css/bootstrap.min.css">
</head>
<body class="notLogged">
	<div id="all" class="notLogged">
		<div class="container notLogged">

			<header class="header">
				<div id="headerMain">
					
					<a href="<?php echo $server ?>"><div id="logo"><span>O shopping na palma da mão</span></div></a>

					<div class="auth">
						<a class="btn-auth btn-facebook large" href="#"> Entre com <b>Facebook</b> </a>
						<a class="btn-auth btn-lojista large" data-toggle="modal" data-target="#modalLojista">Lojista</a>
					</div>
				</div>
			</header>
			
			<div class="about">
				<div class="central">
					<h3>Quem somos</h3>		

					<div class="bio">
						<div class="photo davi"></div>
						<h5>Davi Ricardo</h5>
						<h6>Diretor Executivo</h6>
						<div class="articleBio">
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
							tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
							tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
						</div>
					</div>
					<div class="bio">
						<div class="photo vicente"></div>
						<h5>Vicente Machado</h5>
						<h6>Diretor de Tecnologia</h6>
						<div class="articleBio">
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
							tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
							tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
						</div>
					</div>
					<div class="bio">
						<div class="photo ivo"></div>
						<h5>Ivo Machado</h5>
						<h6>Diretor de Marketing</h6>
						<div class="articleBio">
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
							tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
							tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
						</div>
					</div>
					<div class="bio">
						<div class="photo marcio"><div class="brush"></div></div>
						<h5>Márcio Vicente</h5>
						<h6>Desenvolvedor Front-End</h6>
						<div class="articleBio">
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
							tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
							tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
						</div>
					</div>
					<div class="bio">
						<div class="photo marlon"></div>
						<h5>Marlon Carvalho</h5>
						<h6>Desenvolvedor Mobile</h6>
						<div class="articleBio">
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
							tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
							tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
						</div>
					</div>
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
	<script src="<?php echo $server;?>js/bootstrap.modal	.js"></script>

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