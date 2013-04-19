<?php 
	// $server = "http://smartpanda.com.br/smartpanda2013/";
	$server = "http://localhost:8080/smartpanda2013/";
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
</head>
<body class="notLogged">
	<div id="all" class="notLogged">
		<div id="container">
			<div class="central">
				
				<header id="headerMain">
					<a href="<?php echo $server ?>"><div id="logo"><span>O shopping na palma da mão</span></div></a>

					<a class="btn-auth btn-facebook large" href="#">
					    Entre com <b>Facebook</b>
					</a>
				</header>

				<div id="banner">
					<h2>Encontre tudo o que você precisa</h2>
					<h3>com o shopping na palma da mão</h3>
					<h3>(ou na tela do computador)</h3>
					<button class="getAndroid">Instale agora mesmo</button>
				</div>
				<!-- <div id="leftMain">
					
				</div>
				
				<div id="rightMain">
					<h3>Baixe agora mesmo no seu smartphone</h3>
					<div id="galaxy">
						<a href=""><img src="images/gplay.png" alt="Google play icon"></a>
					</div>
					<div id="iphone">
						<h2>BREVE!</h2>
					</div>
					
				</div> -->
			</div>
		</div>
	</div> <!-- all -->

	<footer id="footerMain">
		
	</footer>

	<script src="<?php echo $server;?>js/jquery.1-9-1.min.js"></script>

	<script>
		$(function () {

		    var counter = 0, divs = $('#galaxy, #iphone');

		    function alternateDiv() {
		        divs.hide() // hide all divs
		            .filter(function (index) { return index == counter % 2; }) // figure out correct div to show
		            .fadeIn('slow'); // and show it

		        counter++;
		    }; // function to loop through divs and show correct div

		    alternateDiv(); // show first div    

		    setInterval(function () {
		        alternateDiv(); // show next div
		    }, 6 * 1000); // do this every 10 seconds    

		});







		
	</script>
</body>
</html>