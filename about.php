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
						<a class="btn-auth btn-facebook large" href="#"> Conecte-se <b>Facebook</b> </a>
						<a class="btn-auth btn-lojista large" data-toggle="modal" data-target="#modalLojista">Lojista</a>
					</div>
				</div>
			</header>
			
			<div class="about">
				<div class="central">
					<h2>Quem somos</h2>		

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
							<p>Márcio é o mais jovem da equipe, estudante de Ciência da Computação e conselheiro na Empresa Júnior, ambos na UFBA. Trabalha com desenvolvimento Web desde 2009 e hoje atua como Front-End Engineer. Sempre buscando a excelência em seu trabalho, já desenvolveu projetos em outras startups.</p>
						</div>
					</div>
					<div class="bio marlon">
						<div class="photo"><div class="icon"></div></div>
						<h5>Marlon Carvalho</h5>
						<h6>Desenvolvedor Mobile</h6>
						<div class="articleBio">
							<p>Graduado em Informática e pós-graduado em Sistemas Distribuídos, Marlon é um entusiasta da área e um dos responsáveis pelo GDG de Salvador e pelo Projeto Pessoa Física, da Receita Federal. Domina muitas linguagens e ambientes e é um especialista em mobile. Atualmente está no SERPRO.</p>
						</div>
					</div>

					<div class="bio vitor">
						<div class="photo"><div class="icon"></div></div>
						<h5>Vitor Oliveira</h5>
						<h6>Designer</h6>
						<div class="articleBio">
							<p>Vitor sempre foi fascinado pelo mundo da criação gráfica. Coordenou por 3 anos o Departamento de Artes de uma das maiores gráficas do Brasil. Com sua Agência VITOR CRIANDO desenvolveu trabalhos internacionais e atende hoje todo o mercado nacional.</p>
						</div>
					</div>

					<div class="bio tiosam">
						<div class="photo"><div class="icon"></div></div>
						<h5>VOCÊ!</h5>
						<h6>Seja um Smartbrother</h6>
						<div class="articleBio">
							<p>Quer fazer parte da nossa equipe e ser um Smartbrother? Nos envie seu currículo e iremos analisá-lo com o maior cuidado.</p>
							<button class="btn btn-success" data-toggle="modal" data-target="#modalCurriculo">Enviar currículo</button>
						</div>
					</div>
				</div>
			</div>
			
			<div id="modalCurriculo" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							<h3 id="myModalLabel">Cadastre seu currículo conosco</h3>
						</div>
						
						<!-- only to test -->
						<div class="modal-body">
							<form method="POST" action="" class="curriculo">
								<div class="input-prepend">
							  		<span class="add-on">Nome</span>
							  		<input class="span2" id="prependedInput" type="text" name="nome" required>
								</div>

								<div class="input-prepend">
							  		<span class="add-on">Email</span>
							  		<input class="span2" id="prependedInput" type="email" name="email" required>
								</div>

								<div class="input-prepend">
							  		<span class="add-on">Telefone</span>
							  		<input class="span2" id="prependedInput" type="text" name="telefone" required>
								</div>
								
								<select name="estado" id="estado">
									<option value="0">Estado</option>
								</select>

								<select name="cidades" id="cidade">
									<option value="0">Cidade</option>
								</select>		

								<div class="input-prepend ">
							  		<span class="add-on textarea">Experiências</span>
							  		<textarea name="experiencia"></textarea>
								</div>

								<div class="input-prepend ">
							  		<span class="add-on textarea plus">Por que você <br> deve ser um <br>Smartbrother?</span>
							  		<textarea name="bio"></textarea>
								</div>
				
							</div>
							
							<div class="modal-footer">
								<button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
								<button class="btn btn-primary btn-success" class="submit" type="submit">Enviar</button>
							</div>
						</form>	
					</div>


		</div>
	</div> <!-- all -->

	<footer id="footerMain" class="notLogged">
		<div class="central">
			<div class="menuFooter">
				<a href="https://bambooss.websiteseguro.com/cadastro.php">Assine um plano</a>
				<a href="about.php">Smartpanda</a>
				<a href="http://www.smartpanda.com.br/TermosDeUso-SMARTPANDA.pdf">Regras gerais</a>
				<a href="" title="Em breve">Blog</a>
				<a href="">Contato</a>
			</div>
		</div>		
	</footer>


	<script src="<?php echo $server;?>js/jquery.1-9-1.min.js"></script>
	<script src="<?php echo $server;?>js/cities.js"></script>
	<script type="text/javascript" src="<?php echo $server;?>js/bootstrap.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			new dgCidadesEstados({
			    estado: $('#estado').get(0),
			    cidade: $('#cidade').get(0)
			});
		});

		$('form.curriculo').submit(function(){
			$.ajax({
				type: 'POST',
				dataType: 'json',
				cache: false,
				url: 'curriculo.php',
				success: function(data){
					if(data.error == true && data.num_error == 1)
						alert("Todos os campos são obrigatórios");
					else if(data.num_error == 2)
						alert("Digite um email válido");
					else{
						$('form.curriculo').html("Mensagem enviada com sucesso! Iremos analisar seu perfil com cuidado.");
					}
					
						
				}
			});

			return false;
		});
	</script>

</body>
</html>