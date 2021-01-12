<?php

	include('con.php');

	function createVarialbesSession($user){
		$_SESSION['email'] = $user['email'];
		$_SESSION['rol'] = $user['rol'];
		$_SESSION['sector_code'] = $user['code'];
		$_SESSION['sector_name'] = $user['name'];

		return $user;
	}

	$email = $_POST['email'];
	$pass = md5($_POST['password']);

	$sql = "
		SELECT * 
		FROM users 
		INNER JOIN sectors 
		ON users.sector_id=sectors.id
		WHERE email = '$email' AND pass = '$pass' 
	;";

	$stmt = $db->prepare($sql);
	$stmt->execute();
	$emailBdd = ($stmt->fetch(PDO::FETCH_ASSOC));

	if ($emailBdd) {


		if ($emailBdd['rol'] === 'admin') {
			createVarialbesSession($emailBdd);
			header('Location: listado-newsletters.php');
		} else {
			createVarialbesSession($emailBdd);
			header('Location: '.$emailBdd['code'].'.php');
		}
		
	}	else {
		$errors['match'] = 'usuario o Contraseña incorrecta.';
	}


?>