<?php
	
	include('includes/config.inc');
	include('con.php');
	include('functions.php');
	
	$email = $_POST['email'];

	$sql = "SELECT * FROM users WHERE email = '$email';";
	$stmt = $db->prepare($sql);
	$stmt->execute();
	$userBdd = ($stmt->fetch(PDO::FETCH_ASSOC));

	$id = (int)$userBdd['id'];
	
  if ($userBdd['email'] === $email) {

		$passNew = generateStrongPassword();

		include('includes/emails/reset-password/template-reset-pass.inc.php'); // Cargo el contenido del email a enviar al usuario.

		mail($email, 'Reseteo de contraseña - Newsletter Interno Vistage', $body,"MIME-Version: 1.0\nContent-type: text/html; charset=UTF-8\nFrom: Newsletter Vistage < info@no-reply.com >");

		$sql = "UPDATE users SET pass = :pass WHERE id = '$id' ";
		
		$stmt = $db->prepare($sql);
		$stmt->bindValue(":pass", md5($passNew), PDO::PARAM_STR);
		$result = $stmt->execute();

		if ($result != false) {
			$message = 'La nueva contraseña se envio al email registrado. Verifica tu casilla. No olvides revisar en SPAM ;)';
		}
		
	} else {
		$errors['match'] = 'Ingresá el email con el que te registraste.';
	}

?>