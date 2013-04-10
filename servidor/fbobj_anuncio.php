<?php 
$titulo = $_GET['titulo'];
$anuncioID = $_GET['anuncioid'];
$imagem = $_GET['imagem'];

$link_anuncio = "http://smartpanda.com.br/webapp/detalhes?id=".$anuncioID;
$link = "http://smartpanda.com.br/servidor/fbobj_anuncio.php?titulo=".$titulo."&anuncioid=".$anuncioID."&imagem=".$imagem;
?>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="pt-BR"
      xmlns:fb="https://www.facebook.com/2008/fbml">
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# object: http://ogp.me/ns/object#">
  <meta charset="UTF-8">
  <meta property="fb:app_id" content="225275740933146" /> 
  <meta property="og:type"   content="object" /> 
  <meta property="og:url"    content="<?= $link ?>" /> 
  <meta property="og:title"  content="<?= $titulo?>" /> 
  <meta property="og:image"  content="<?= $imagem?>" />
  </head>
<body>
  <div id="fb-root"></div>
  <script>
    window.fbAsyncInit = function() {
      FB.init({
        appId      : '225275740933146', // App ID
        status     : true, // check login status
        cookie     : true, // enable cookies to allow the server to access the session
        xfbml      : true  // parse XFBML
      });
    };

    // Load the SDK Asynchronously
    (function(d){
      var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;}
      js = d.createElement('script'); js.id = id; js.async = true;
      js.src = "//connect.facebook.net/pt_BR/all.js";
      d.getElementsByTagName('head')[0].appendChild(js);
    }(document));

   //window.location = "<?= $link_anuncio ?>";
  </script>

  <h3><?= $titulo?></h3>
  <p><a href="<?= $link_anuncio ?>">Ir para o anúncio</a><p>
  <p>
    <img title="<?= $titulo?>" 
         src="<?= $imagem?>" 
         width="320"/>
  </p>
</body>
</html>
