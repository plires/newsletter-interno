<?php

	include('../includes/config.inc');
	include('con.php');

	if ( isset($_POST['id']) && isset($_POST['status']) ) {
		
		$id = $_POST['id'];
		$status = (int)$_POST['status'];

		if ($status) {
			$status = 0;
		} else {
			$status = 1;
		}

	} else {
		return false;exit;
	}

	$sql = "UPDATE newsletters SET execute = :execute WHERE id = '$id' ";

  $stmt = $db->prepare($sql);
  $stmt->bindValue(":execute", $status, PDO::PARAM_STR);
  $result = $stmt->execute();

  echo json_encode($result);
  
?>