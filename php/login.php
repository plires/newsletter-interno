<?php

	include('con.php');

	function createVarialbesSession($user){
		
		$_SESSION['user_id'] = (int)$user['user_id'];
		$_SESSION['user_name'] = $user['user_name'];
		$_SESSION['email'] = $user['email'];
		$_SESSION['rol'] = $user['rol'];
		$_SESSION['sector_id'] = (int)$user['sector_id'];
		$_SESSION['sector_code'] = $user['code'];
		$_SESSION['sector_name'] = $user['sector_name'];

		return $user;
	}

	$email = $_POST['email'];
	$pass = md5($_POST['password']);

	$sql = "
		SELECT u.id AS user_id, u.name AS user_name , u.email, u.rol, s.id AS sector_id, s.code, s.name AS sector_name
		FROM users AS u
		INNER JOIN sectors AS s
		ON u.sector_id=s.id
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