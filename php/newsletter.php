<?php

	include('../includes/config.inc');
	include('con.php');
	
	$today = date("Y-m-d H:i:s");

	switch ($_POST['action']) {
		case 'add':
		  $name = $_POST['name'];
		  $month = $_POST['month'];
		  $year = $_POST['year'];
			
			$sql = "INSERT INTO newsletters values(default, :name, :month, :year, :gerencia_general, :gerencia_talento, :administracion_finanzas, :marketing, :operaciones, :execute, :url, :comment_table_a, :comment_table_b, :comment_table_c, :observations_table, :observations_newsletter, :created_at, :updated_at)";

		  $stmt = $db->prepare($sql);
		  
		  $stmt->bindValue(":name", $name, PDO::PARAM_STR);
		  $stmt->bindValue(":month", $month, PDO::PARAM_INT);
		  $stmt->bindValue(":year", $year, PDO::PARAM_INT);
		  $stmt->bindValue(":gerencia_general", '', PDO::PARAM_STR);
		  $stmt->bindValue(":gerencia_talento", '', PDO::PARAM_STR);
		  $stmt->bindValue(":administracion_finanzas", '', PDO::PARAM_STR);
		  $stmt->bindValue(":marketing", '', PDO::PARAM_STR);
		  $stmt->bindValue(":operaciones", '', PDO::PARAM_STR);
		  $stmt->bindValue(":execute", 0, PDO::PARAM_INT);
		  $stmt->bindValue(":url", '', PDO::PARAM_STR);
		  $stmt->bindValue(":comment_table_a", '', PDO::PARAM_STR);
		  $stmt->bindValue(":comment_table_b", '', PDO::PARAM_STR);
		  $stmt->bindValue(":comment_table_c", '', PDO::PARAM_STR);
		  $stmt->bindValue(":observations_table", '', PDO::PARAM_STR);
		  $stmt->bindValue(":observations_newsletter", '', PDO::PARAM_STR);
		  $stmt->bindValue(":created_at", $today, PDO::PARAM_STR);
		  $stmt->bindValue(":updated_at", $today, PDO::PARAM_STR);
		        
		  $save = $stmt->execute();

		  echo json_encode($save);
			break;

			case 'edit':

			$id = $_POST['id'];

			$sql = "
				UPDATE newsletters 
				SET 
					name = :name,
					updated_at = :updated_at
				WHERE id = '$id' ";

		  $stmt = $db->prepare($sql);

		  $stmt->bindValue(":name", $_POST['name'], PDO::PARAM_STR);
		  $stmt->bindValue(":updated_at", $today, PDO::PARAM_STR);
		        
		  $save = $stmt->execute();

			echo json_encode($save);
			break;

		case 'delete':
			// Id del producto a eliminar
		  $id = (int)$_POST['id'];
		        
		  $sql = "DELETE FROM newsletters WHERE id='$id'";
		  $stmt = $db->prepare($sql);
		  $save = $stmt->execute();

		  echo json_encode($save);
			break;
	}

?>