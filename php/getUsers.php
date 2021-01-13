<?php

	include('../includes/config.inc');
	include('con.php');

	$sql = "SELECT * FROM users";
	$stmt = $db->prepare($sql);
	$stmt->execute();
	$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

	echo json_encode($users);

?>