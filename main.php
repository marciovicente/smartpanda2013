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
			<div class="banner">
				<div class="central">
					<h2>Encontre tudo o que você precisa</h2>
					<h3>com o shopping na palma da mão</h3>
					<h3>(ou na tela do computador)</h3>
					<button class="getButton"><span>Instale agora mesmo</span> <div class="androidIcon"></div> <h6>Versão 2.1 no Google Play</h6> </button>
					<button class="getButton apple"><span>Instale agora mesmo</span>  <div class="appleIcon"></div></button>
				</div>
			</div>


			<!-- =========================== modal lojista =========================== -->
			
			<div id="modalLojista" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h3 id="myModalLabel">Área do Lojista</h3>
				</div>
				
				<div class="modal-body">
					<form class="loginLojista" method="POST" action="">
						<span>Login</span>
						<input type="text" name="user" placeholder="Nome de usuário">
						<input type="password" name="password" placeholder="Senha">
						<button class="btn btn-info"><i class="icon icon-white icon-lock" ></i> Entrar</button>
						<a href=""> <i class="icon icon-question-sign"></i> Esqueci minha senha</a>
					</form>
					<div class="leftModalLojista">
						<h4>Ainda não cadastrou sua loja?</h4>
						<p>Aumente suas receitas</p>
						<p>Gerencie e otimize suas despesas com publicidade</p>
		 				<p>Seus produtos e serviços na palma da mão dos consumidores</p>
						<p>Seja eficaz em satisfazer as necessidades dos seus clientes</p>
						<button class="btn btn-success btn-large">Cadastre agora!</button>
					</div>
				</div>
				
				<!-- <div class="modal-footer">
					<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
					<button class="btn btn-primary">Save changes</button>
				</div> -->
			</div>

			<!-- ======================================================================= -->

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


			

		});







		
	</script>
</body>
</html>