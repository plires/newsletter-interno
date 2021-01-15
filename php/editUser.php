<?php
	
	include('../includes/config.inc');
	require_once('con.php');

	$id = (int)$_POST['user_id'];
	$name = $_POST['user_name'];
	$email = $_POST['user_email'];

	if (isset($_POST['pass'])) {
		$pass = md5($_POST['pass']);

		$sql = "UPDATE users SET name = :name, email = :email, pass = :pass WHERE id = '$id' ";
		
		$stmt = $db->prepare($sql);

		$stmt->bindValue(":pass", $pass, PDO::PARAM_STR);
		
	} else {
		$sql = "UPDATE users SET name = :name, email = :email WHERE id = '$id' ";
		
		$stmt = $db->prepare($sql);
	}

	$stmt->bindValue(":name", $name, PDO::PARAM_STR);
	$stmt->bindValue(":email", $email, PDO::PARAM_STR);
	
	$result = $stmt->execute();

	echo json_encode($result);

?>