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

					<div class="bio davi">
						<div class="photo"><div class="icon"></div></div>
						<h5>Davi Ricardo</h5>
						<h6>CEO & Co-founder</h6>
						<div class="articleBio">
							<p>Davi é um apaixonado por estratégias empresariais e comportamento varejista. Empreender sempre esteve no DNA de sua família: cresceu vendo e fazendo negócios. Atuou no desenvolvimento comercial de instituições como Diário Oficial da Bahia, Cosentino Group, Petrobahia e outras.</p>
						</div>
					</div>
					<div class="bio vicente">
						<div class="photo"><div class="icon"></div></div>
						<h5>Vicente Machado</h5>
						<h6>CTO & Co-founder</h6>
						<div class="articleBio">
							<p>Pode-se dizer que Vicente respira tecnologia. Domina diversas linguagens e sistemas. Desenvolveu seu primeiro software aos 13 anos e não parou mais. Bacharel em Ciência da Computação, fluente em inglês, trabalhou para Portugal Telecom, Itin e Telegate Americas.</p>
						</div>
					</div>
					<div class="bio ivo">
						<div class="photo"><div class="icon"></div></div>
						<h5>Ivo Machado</h5>
						<h6>CMO & Co-founder</h6>
						<div class="articleBio">
							<p>Publicitário e sócio da Jobs Filmes, Ivo é criativo por excelência e não esconde o prazer de trabalhar. Fluente em inglês, tem experiência internacional na produção de comerciais. No mercado local tem produzido também documentários e videoclips. Já trabalhou para Malagueta Filmes, Rx30 e TCG.</p>
						</div>
					</div>
					<div class="bio marcio">
						<div class="photo"><div class="icon"></div></div>
						<h5>Márcio Vicente</h5>
						<h6>Front-End Engineer</h6>
						<div class="articleBio">
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
							tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
							tempor incididunt ut labore et dolore magna aliqua. Ut enim ad.</p>
						</div>
					</div>
					<div class="bio marlon">
						<div class="photo"><div class="icon"></div></div>
						<h5>Marlon Carvalho</h5>
						<h6>Desenvolvedor Mobile</h6>
						<div class="articleBio">
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
							tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
							tempor incididunt ut labore et dolore magna aliqua. Ut enim ad.</p>
						</div>
					</div>

					<div class="bio tiosam">
						<div class="photo"><div class="icon"></div></div>
						<h5>VOCÊ!</h5>
						<h6>Seja um Smartbrother</h6>
						<div class="articleBio">
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
							tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
							tempor incididunt ut labore et dolore magna aliqua. Ut enim ad.</p>
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


</body>
</html>