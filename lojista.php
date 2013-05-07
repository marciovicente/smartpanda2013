<?php 
	include("includes/config.php");
?>

<!doctype html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<title>Área do Lojista - Smartpanda</title>
	<link rel="stylesheet" href="<?php echo $server;?>css/lojista.css">
	
	<link href='http://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'>
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo $server;?>images/favicon.ico">
	
</head>
<body>
	<div class="all">
		<header class="header">
			<div class="central">
				<div class="brand"><span>O shopping na palma da mão</span></div>

				<button class="buttonTop">Cadastre-se agora <br><span>É grátis!</span> </button>
			</div>

		</header>

		<div class="content">
			<section class="first">
				<div class="central">
					<h2>Nunca foi tão fácil monitorar o marketing da sua empresa!</h2>
					<div class="labels">
						<h3>Cadastre facilmente uma oferta</h3>
						<h3>Direcione seu público alvo e atinja somente quem deve ver seu anúncio</h3>
						<h3>Acompanhe relatórios, gráficos e todos os dados relevantes da sua campanha</h3>
					</div>

					<div class="lojista1">

					</div>

					<div class="legends">
						<h5></h5>
						<h5></h5>
						<h5></h5>
					</div>
				</div>
			</section>	

			<section class="second">
				<div class="central">
					<h2>"Por que minha loja deve usar o Smartpanda?"</h2>
					<div class="why receita">
						<h4>Aumente suas receitas</h4>
						<article class="article">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
							tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.Lorem ipsum dolor sit amet.</article>
					</div>
					<div class="why mkt">
						<h4>Aumente suas receitas</h4>
						<article class="article">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
							tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.Lorem ipsum dolor sit amet.</article>	
					</div>
					<div class="why hand">
						<h4>Aumente suas receitas</h4>
						<article class="article">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
							tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.Lorem ipsum dolor sit amet.</article>
					</div>

					<button class="btn"><span>Estou convencido!</span> <br> Quero me cadastrar agora</button>
				</div>

			</section>
			
			<section class="third">
				<div class="central">
					
					<h2>Lojas que já se cadastraram</h2>
					
					<div id="listaClientes" clas="elastislide-list">
						<img src="images/soho.png" alt="">
						<img src="images/flytour.png" alt="">
						<img src="images/mia_tropical.png" alt="">
						<img src="images/soho.png" alt="">
						<img src="images/flytour.png" alt="">
						<img src="images/mia_tropical.png" alt="">
						<img src="images/soho.png" alt="">
						<img src="images/flytour.png" alt="">
						<img src="images/mia_tropical.png" alt="">
					</div>
					<button class="btn">Faça como eles</button>
				</div>
			</section>

			<section class="fourth">
				<div class="central">
					<div class="left">
						<h2>Depoimentos</h2>
						<div class="depoimento">
							<span>,,</span>
							<article class="article">
								Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
								tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.Lorem ipsum dolor sit amet.
								Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
								tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.Lorem ipsum dolor sit amet.
							</article>
							<h5>Marcio Vicente - Empório Vinhos</h5>
						</div>
						<div class="depoimento">
							<span>,,</span>
							<article class="article">
								Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
								tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.Lorem ipsum dolor sit amet.
								Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
								tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.Lorem ipsum dolor sit amet.
							</article>
							<h5>Marcio Vicente - Empório Vinhos</h5>
						</div>
						<div class="depoimento">
							<span>,,</span>
							<article class="article">
								Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
								tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.Lorem ipsum dolor sit amet.
								Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
								tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.Lorem ipsum dolor sit amet.
							</article>
							<h5>Marcio Vicente - Empório Vinhos</h5>
						</div>
					</div>

			
					<form action="" class="form">
						<input type="text" name="nome">
						<input type="email" name="email">
						<input type="text" name="empresa">
						<input type="text" name="phone">
							<label>
								<select name="estado" id="estado">
									<option value="0">Selecione seu Estado</option>
								</select>
							</label>

							<label class='cidade'>
								<select name="cidades" id="cidade">
									<option value="0">Selecione sua cidade</option>
								</select>
							</label>
						<textarea name="mensagem"></textarea>
						<button class="btn">Enviar mensagem</button>

					</form>
				</div> <!-- central -->
				
			</section>
		</div>
	</div>




	<script src="<?php echo $server;?>js/jquery.1-9-1.min.js"></script>
	<script src="<?php echo $server;?>js/browser.js"></script>
	<script src="<?php echo $server;?>js/jquery.carouFredSel-6.2.1-packed.js"></script>
	<script src="<?php echo $server;?>js/cities.js"></script>


	<script>	
		$(document).ready(function(){
			$("#listaClientes").carouFredSel({
				scroll : {
					duration		: 800,							
					pauseOnHover	: true
				}
			});

			new dgCidadesEstados({
			    estado: $('#estado').get(0),
			    cidade: $('#cidade').get(0)
			});
		});
	</script>

</body>
</html>