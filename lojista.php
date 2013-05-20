<?php 
	include("includes/config.php");
?>

<!doctype html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<title>Área do Lojista - Smartpanda</title>
	<link rel="stylesheet" href="<?php echo $server;?>css/lojista.css">
	<link rel="stylesheet" href="<?php echo $server;?>css/font-awesome.css">
	<link href='http://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'>
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo $server;?>images/favicon.ico">
	
</head>
<body>
	<div class="all">
		<header class="header">
			<div class="central">
				<a href="http://smartpanda.com.br"><div class="brand"><span>O shopping na palma da mão</span></div></a>

				<form action="" class="formLogin">
					<label>
						<span class="icon-user"></span>
						<input type="text" placeholder="Usuário">
					</label>

					<label>
						<span class="icon-lock"></span>
						<input type="password" placeholder="Senha">
					</label>
					<button>OK</button>
				</form>
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

					<div class="lojista1"></div>

					
				</div>
			</section>	

			<section class="second">
				<div class="central">
					<h2>"Por que minha loja deve usar o Smartpanda?"</h2>

					<div class="tabContent">
						<div class="tabLeft">
							<button class="tab" value="1">Aumente suas receitas</button>
							<button class="tab" value="2">Reduza gastos com Marketing</button>
							<button class="tab" value="3">Não pague nada</button>
						</div>
						<div class="tabRight">
							<article class="article1">Os Smartphones têm um papel fundamental para as estratégias de marketing, pois aumentam o envolvimento do consumidor com seu produto. Ligamos o mundo offline com o mundo online, trazendo a sua loja para a palma da mão dos consumidores. Não só isso, o Smartpanda é um sistema inteligente e de fácil uso. Conseguimos entregar o mesmo anúncio nas redes sociais, em nosso site e no Smartpanda TV, aplicando o conceito de comunicação 360°.</article>
							<article class="article2">Os seus investimentos em marketing serão otimizados, pois suas campanhas serão direcionadas para o seu público-alvo. Com o poder analítico que possuímos, a sua empresa terá informações precisas, sabendo exatamente quantas pessoas foram atingidas por um anúncio, quantas gostaram e compartilharam nas redes sociais e até mesmo quantas pessoas compraram, após terem visto uma informação no Smartpanda.</article>	
							<article class="article3">Possuímos planos que cabem em seu orçamento. Você pode usar o Smartpanda GRÁTIS pelo tempo que quiser (no plano Basic) ou migrar para outros planos que se adequem ao seu negócio. Comece agora mesmo. Basta efetuar o seu cadastro e aproveitar. Não perca mais tempo e dinheiro.</article>
							
						</div>
					</div>

					<div class="why receita">
						<h4></h4>
					</div>
					<div class="why mkt">
						<h4></h4>
					</div>
					<div class="why hand">
						<h4></h4>
					</div>

					<button class="btn">Quero me cadastrar agora</button>
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

					

					<div class="searchShopping">
						
						<input type="text" class="search"><i class="icon-search"></i>
						<div class="listaShopping">
							<div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
						    <div class="viewport">
						        <div class="overview">
									<h4 class="shopping">Shopping Iguatemi</h4>
									<h4 class="shopping">Shopping Iguatemi</h4>
									<h4 class="shopping">Shopping Iguatemi</h4>
									<h4 class="shopping">Shopping Iguatemi</h4>
									<h4 class="shopping">Shopping Iguatemi</h4>
									<h4 class="shopping">Shopping Iguatemi</h4>
									<h4 class="shopping">Shopping Iguatemi</h4>
									<h4 class="shopping">Shopping Iguatemi</h4>
									<h4 class="shopping">Shopping Iguatemi</h4>
									<h4 class="shopping">Shopping Iguatemi</h4>
									<h4 class="shopping">Shopping Iguatemi</h4>
									<h4 class="shopping">Shopping Iguatemi</h4>
									<h4 class="shopping">Shopping Iguatemi</h4>
						        </div>
						    </div>
						</div>
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
								Acreditamos neste novo serviço e nos benefícios que ele trará à nossa empresa. O Sistema é fácil de usar e podemos divulgar os pacotes da Flytour. Hoje, na era dos Iphones e Smartphones, onde os aplicativos podem ser baixados e a facilidade que eles trazem aos seus usuários, com certeza o Smartpanda será mais um de sucesso. Continuaremos indicando.
							</article>
							<h5>Taiana Gama - Analista de Marketing Flytour Amex</h5>
						</div>

						<div class="depoimento">
							<span>,,</span>
							<article class="article">
								A nossa experiência com o Smartpanda tem sido ótima, já que é uma ferramenta digital, simples e fácil, que tem ajudado a divulgar a nossa marca, focando no nosso público-alvo. Definitivamente recomendamos para clientes que procuram oportunidades e novidades, e para lojistas que visam estar sempre se comunicando com seus clientes. Parabéns, Equipe Smartpanda!

							</article>
							<h5>Camila Alemany - Proprietária Mia Tropical</h5>
						</div>

						<div class="depoimento">
							<span>,,</span>
							<article class="article">
								Tenho achado bem simples, prático e fácil de utilizar. Eu indico, com certeza, pois sei que vamos alavancar as vendas e a divulgação dos nossos serviços.
							</article>
							<h5>Cristina Bortoli - Gerente - Vila Cani Pet Center</h5>
						</div>

						<div class="phone"><span>+55</span> 71 4141-6366</div>
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
	<script src="<?php echo $server;?>js/tiny.js"></script>
	

	<script>	
		$(document).ready(function(){

			$("#listaClientes").carouFredSel({
				scroll : {
					duration		: 800,							
					pauseOnHover	: true
				}
			});
			
			carregaShoppings();

			new dgCidadesEstados({
			    estado: $('#estado').get(0),
			    cidade: $('#cidade').get(0)
			});
			$('.article2,.article3').hide();
			$('.tab:first').addClass('active');

			$('.listaShopping').tinyscrollbar();

		}); 

		var servidor = "smartpanda.com.br/servidor/sistema/";
		
		if((location.href).charAt(7) == 'w' && (location.href).charAt(8) == 'w' && (location.href).charAt(9) == 'w')
			servidor = 'http://www.'+servidor;
		else
			servidor = 'http://'+servidor;

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

		var e = 0;
			
		$('form input').each(function(i){
			if($(this).hasClass('error'))
				e++;
		});

		$('form .btn').mouseover(function(){
			if(e > 0){
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

		$('button.tab').click(function(){
			$(this).siblings().removeClass('active');
			$(this).addClass('active');

			var value = $(this).val();

			$('article.article'+value).show();
			$('article.article'+value).siblings().hide();
		});
		
		$('.form').submit(function(){

			if(e == 0){

				$.ajax({
					type: 'POST',
					dataType: 'json',
					cache: false,
					url: 'contato.php',
					success: function(data){
						if(data.error == true && data.num_error == 1)
							alert("Preencha todos os campos obrigatórios");
						else if(data.num_error == 2)
							alert("Digite um email válido");
						else{
							$('form.form').html("Mensagem enviada com sucesso! Em breve entraremos em contato com você");
						}
						
							
					}
				});

				return false;
			}
		});
		
		
		function carregaShoppings(){
			var shop = '';	
			$.ajax({type:'GET', dataType:'json', url: servidor+'getshoppingsativos', timeout:3000,
				success: function(dados){
					$.each(dados, function(i,obj){
						shop += '<span class="shopping">'+obj.nome_fantasia+'</span>';
					});

					$('.listaShopping').html(shop);
				},
				error: function(){			
					console.warn("Erro ao carregar shoppings ");
				}
			});
		}

		// $('input.search').on('live',function(){});
	</script>

</body>
</html>