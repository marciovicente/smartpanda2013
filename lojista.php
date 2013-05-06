<?php 
	include("includes/config.php");
?>

<!doctype html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<title>Área do Lojista - Smartpanda</title>
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
			
			<div class="lojista">
				

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

</body>
</html>