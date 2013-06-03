<?php 
	$nome = $_POST['nome'];
	$email = $_POST['email'];
	$telefone = $_POST['telefone'];
	$estado = $_POST['estado'];
	$cidade = $_POST['cidade'];
	$experiencias = $_POST['experiencias'];
	$bio = $_POST['bio'];

	$error = 0;

	validaEmail($email);

	if($nome == " " || $email == " " || $telefone == " " || $experiencias == " " || $cidade == " " || $estado == " " || $bio == " ")
		$error = 1;

	function validaEmail($mail){
		$user = "^[a-zA-Z0-9\._-]+@";
		$dominio = "[a-zA-Z0-9\._-]+.";
		$extensao = "([a-zA-Z]{2,4})$";

		$pattern = $user.$dominio.$extensao;

		if(!ereg($pattern, $mail))
			$error = 2;

	}

	if($error == 0){
		$msg = "Interesse em trabalhar no Smartpanda\n";
		$msg .= "Nome do responsável: ".$nome."\n";
		$msg .= "Email: ".$email."\n";
		$msg .= "Telefone para contato: ".$telefone."\n";
		$msg .= "Estado: ".$estado."\n";
		$msg .= "Cidade: ".$cidade."\n";
		$msg .= "Experiências: ".$experiencias."\n";
		$msg .= "Por que deve ser um Smartbrother: ".$bio."\n";

		if(mail("contato@smartpanda.com.br", "Curriculo enviado pelo site", $msg))
			$return ['error'] = false;

	}else{
		$return ['error'] = true;
		$return ['num_error'] = $error;
	}

	echo json_encode($return);

 ?>