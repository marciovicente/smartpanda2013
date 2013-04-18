<?php 
	$id = $_GET['id']; 
	$server = "http://smartpanda.com.br/smartpanda2013/";
	// $server = "http://localhost:8080/smartpanda2013/";
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
				
				<div class="fb-comments" data-href="<?php echo $server;?>oferta.php?id=<?php echo $id; ?>" data-width="770" data-num-posts="5"></div>
					
			</div>
		</div>
	</div>

	<!-- <footer id="footer">
		<div class="central">
			
			
		</div>
	</footer> -->
	
	<script src="<?php echo $server;?>js/jquery.1-9-1.min.js"></script>
	<script src="<?php echo $server;?>js/global.js"></script>
	<script src="<?php echo $server;?>js/bootstrap.min.js"></script>
	
	<script>
		$(document).ready(function(){
			
			var id_oferta = <?php echo $id; ?>;
			carregaDetalhes(id_oferta);
			
			// checkLogin();
			
		});

		
	</script>
</body>
</html>