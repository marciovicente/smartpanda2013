var usuarioID = "";
var appId = '225275740933146';

fbCarregou = false;
window.fbAsyncInit = function() {
  FB.init({
    appId      : appId,
    channelUrl : 'www.smartpanda.com.br/servidor/channel.php',
    status     : true, 
    cookie     : true,
    xfbml      : true,
    oauth      : true,
  });
  fbCarregou = true;
  
  FB.Event.subscribe('auth.login', function () {
	  window.location = "./migrarfb";
  });

  
};
(function(d){
   var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;}
   js = d.createElement('script'); js.id = id; js.async = true;
   js.src = "//connect.facebook.net/pt_BR/all.js";
   d.getElementsByTagName('head')[0].appendChild(js);
 }(document));