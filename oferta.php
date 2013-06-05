<?php 
	$id = $_GET['id']; 
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
	<meta property="fb:admins" content="100001708066608"/>
	<meta property="fb:app_id" content="225275740933146"/>


</head>
<body>
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/pt_BR/all.js#xfbml=1&appId=225275740933146";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));

	</script>
	
	<!-- <div class="overlayLoad">
		<div class="loaderSp">
			<span>Carregando</span>
		</div>
	</div> -->

	<div id="all">
		<div id="container">
			<header id="header">
				<div class="central">
					<a href="<?php echo $server ?>"><div id="logo"><span>O shopping na palma da mão</span></div></a>
					<div id="statusLogin">
						<div class="imgLogin">
							<img src="" alt="Facebook profile">
						</div>
						<div class="profile">
							<h6></h6>
							<a href="#"><i class="icon icon-user icon-white"></i>Meu cadastro</a>
							<a href="#" class="logout"> <i class="icon icon-white icon-remove"></i>Sair</a>
							
						</div>
					</div>
				</div>

				
			</header>

			<div class="central">
				<button class="backButton"><i class="icon icon-chevron-left"></i> <span>Voltar</span></button>
				<section id="firstContainer">
					
					<div id="oferta">
						<img src="" alt="" class="imgOferta">
						<div id="infoOferta">
							<h2></h2>
							<h4><div class="iconLoja"></div> </h4>
							<h4 class="shoppingName"><div class="iconLoja mall"></div> </h4>
							<article class="articleOferta">
							
							<br><span class="validadeOferta"></span>
							</article>
							<div id="validade"></div>
							
							<nav id="barOferta">
								<a ><span class="spriteInteracao like"></span><h5>Gostei</h5> <span class="curtiram"></span></a>
								<div class="innerLine"></div>
								<a ><span class="spriteInteracao dislike"></span><h5>Não gostei</h5></a>
								<div class="innerLine"></div>
								<a ><span class="spriteInteracao reservar"></span><h5>Reservar</h5></a>
								<div class="innerLine"></div>
								<a ><span class="spriteInteracao share"></span><h5>Compartilhe</h5></a>
							</nav>
						</div>
					</div>
				</section>
				<section class="secondContainer">
					<!-- <div class="suggest">
						<h5>Também poderá gostar de</h5>
						
					</div> -->
					
						<div class="comments">
							<div class="fb-comments" data-href="<?php echo $server;?>oferta.php?id=<?php echo $id; ?>" data-width="770" data-num-posts="5"></div>
						</div>
				
					
				</section>
					
			</div> <!-- .central -->

		</div>
	</div>

	<footer id="footerMain">
		<div class="central">
			<div class="menuFooter">
				<a href="https://bambooss.websiteseguro.com/cadastro.php">Assine um plano</a>
				<a href="about.php">Quem somos</a>
				<a href="http://www.smartpanda.com.br/TermosDeUso-SMARTPANDA.pdf">Regras gerais</a>
				<a href="" title="Em breve">Blog</a>
				<a href="">Contato</a>
			</div>
		</div>		
	</footer>
	
	<script src="<?php echo $server;?>js/jquery.1-9-1.min.js"></script>
	<script src="<?php echo $server;?>js/global.js"></script>
	<script src="<?php echo $server;?>js/bootstrap.min.js"></script>
	
	<script>
		$(document).ready(function(){
			<?php 
				$r = $_GET['r'];
				if($r == 'cm'):
			?>
				$('.comments').addClass('animated tada');

				setTimeout(function(){
				    $('.comments').removeClass('animated tada');
				},30000);
			<?php endif; ?>
			var id_oferta = <?php echo $id; ?>;
			carregaDetalhes(id_oferta);
			
			// checkLogin();
			
		});

		$('.backButton').click(function(){
			event.preventDefault();
    		history.back(1);
		});

		
	</script>
</body>
</html>