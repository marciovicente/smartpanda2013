<?php 

	$nome = $_POST['nome'];
	$email = $_POST['email'];
	$telefone = $_POST['telefone'];
	$empresa = $_POST['empresa'];
	$estado = $_POST['estado'];
	$cidade = $_POST['cidade'];
	$mensagem = $_POST['mensagem'];

	$error = 0;

	validaEmail($email);

	if($nome == " " || $email == " " || $telefone == " " || $empresa == " " || $cidade == null || $estado == null)
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
		$msg = "Mensagem enviada pelo Lojista\n";
		$msg .= "Nome do responsável: ".$nome."\n";
		$msg .= "Email: ".$email."\n";
		$msg .= "Telefone para contato: ".$telefone."\n";
		$msg .= "Estado: ".$estado."\n";
		$msg .= "Cidade: ".$cidade."\n";
		$msg .= "Mensagem: ".$mensagem."\n";
		if(mail())
	}else{
		$return ['error'] = true;
		$return ['num_error'] = $error;
	}
	echo json_encode($return);
?>

