<?php

	include('../includes/config.inc');
	include('con.php');

	if ( isset($_POST['id']) && isset($_POST['status']) ) {
		
		$id = $_POST['id'];
		$status = (int)$_POST['status'];

		if ($status) {
			$status = 0;
			$url = 0;
		} else {
			$status = 1;
			$url = PATH_ROOT . '/newsletter.php?id=' . $id;
		}

	} else {
		return false;exit;
	}

	$sql = "UPDATE newsletters SET execute = :execute, url = :url, updated_at = :updated_at WHERE id = '$id' ";

  $stmt = $db->prepare($sql);
  $stmt->bindValue(":execute", $status, PDO::PARAM_STR);
  $stmt->bindValue(":url", $url, PDO::PARAM_STR);
  $stmt->bindValue(":updated_at", date("Y-m-d H:i:s"), PDO::PARAM_STR);
  $result = $stmt->execute();

  echo json_encode($result);
  
?>