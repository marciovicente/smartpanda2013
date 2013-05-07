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
						<img src="images/clientes/soho.png" alt="Soho Restaurante">
						<img src="images/clientes/flytour.png" alt="Flytour Turismo">
						<img src="images/clientes/mia_tropical.png" alt="Mia Tropical">
						<img src="images/clientes/vila-cani.png" alt="Vila Cani">
						<img src="images/clientes/fiolaser.png" alt="Fiolaser Estética">
						<img src="images/clientes/salvatur.png" alt="Salvatur Turismo">
						<img src="images/clientes/humpty.png" alt="Humpty Dumpty Brinquedos">
						
					</div>
					<a class="doIt" href="#">Faça como eles</a>
				</div>
			</section>

			<section class="fourth">
				<div class="central">
					<div class="left">
						<h2>Depoimentos</h2>
						<div class="depoimento">
							<span>,,</span>
							<article class="article">
								A nossa experiência com o Smartpanda tem sido ótima, já que é uma ferramenta digital, simples e fácil, que tem ajudando a divulgar a nossa marca, focando no nosso público-alvo. Definitivamente recomendamos para clientes que procuram oportunidades e novidades, e para lojistas que visam estar sempre comunicados com seus clientes. Parabéns equipe Smartpanda! 

							</article>
							<h5>Camila Alemany - Proprietária Mia Tropical</h5>
						</div>
						<div class="depoimento">
							<span>,,</span>
							<article class="article">
								Acreditamos neste novo serviço e nos benefícios que ele trará a nossa empresa. O Sistema é fácil de usar e podemos divulgar os pacotes da Flytour. Hoje, na era dos Iphones e Smatrtphones, onde os aplicativos podem ser baixados e a facilidade que eles trazem aos seus usuários, com certeza o Smartpanda será mais um de sucesso. Continuaremos indicando.
							</article>
							<h5>Taiana Gama - Analista de Marketing Flytour Amex</h5>
						</div>
						<div class="depoimento">
							<span>,,</span>
							<article class="article">
								Tenho achado bem simples, prático e fácil utilizar. Eu indicaria, com certeza, sei que vamos alavancar as vendas e a divulgação dos nossos serviços, aliado a outras formas de divulgação, que não foram utilizadas.
							</article>
							<h5>Cristina Botoli - Gerente - Vila Cani Pet Center</h5>
						</div>
					</div>

			
					<form action="" class="form">
						<h3>Ainda com dúvidas?</h3>
						<h5>Preencha o formulário abaixo ou agende uma visita de um dos nossos consultores</h5>
						
						<div class="input">
							<div class="placeholder">Seu nome </div>
							<input type="text" name="nome" required>
						</div>

						<div class="input">
							<div class="placeholder">Seu email</div>
							<input type="email" name="email" required>
						</div>

						<div class="input">
							<div class="placeholder">Telefone</div>
							<input type="text" name="phone" required>
						</div>

						<div class="input">
							<div class="placeholder">Empresa</div>
							<input type="text" name="empresa" required>
						</div>

							<label>
								<select name="estado" id="estado">
									<option value="0">Estado</option>
								</select>
							</label>

							<label class='cidade'>
								<select name="cidades" id="cidade">
									<option value="0">Cidade</option>
								</select>
							</label>
						<textarea name="mensagem"></textarea>
						<button class="btn" type="submit">Enviar mensagem</button>

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

		$('.input').click(function(){
			$(this).find('input').focus();
		});

		$('input, textarea').on('keyup', function(e){
			$(this).addClass('ok');

			if(!$(this).val())
				$(this).removeClass('ok').addClass('error');
			else
				$(this).removeClass('error').addClass('ok');
			
		});

		var x = 0;
			
		$('form input').each(function(i){
			if($(this).hasClass('error'))
				x++;
		});

		$('form .btn').mouseover(function(){
			if(x > 0){
				$('form button').html('Preencha corretamente');
				$('form').find('button').addClass('error');
			}else{
				$('form button').html('Enviar mensagem');
				$('form').find('button').removeClass('error');
			}
			
		});

		$('select').change(function(){
			$(this).parent().addClass('active');
		});

		
		
		$('.form').submit(function(){

			if(x == 0){

				$.ajax({
					type: 'POST',
					dataType: 'json',
					cache: false,
					url: 'contato.php',
					success: function(data){
						if(data.error == true)
							$('form.form').html("<h3> Mensagem enviada</h3>"); 
						else
							alert("Ocorreu um erro, tente novamente mais tarde"); 
					}
				});

				return false;
			}
		});
	</script>

</body>
</html>