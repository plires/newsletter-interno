<?php

	include('../includes/config.inc');
	include('con.php');

	$id = $_POST['idNewsletter'];
	$fieldSector = $_POST['fieldSector'];
	$column = $_POST['column'];
	$today = date("Y-m-d H:i:s");

	$sql = "UPDATE newsletters SET " .$column. " = '" .$fieldSector. "', updated_at = '" .$today. "' WHERE id = ".$id." ";
	$stmt = $db->prepare($sql);
	$newsletter = $stmt->execute();
	
	echo $newsletter;

?>