<?php

	include('../includes/config.inc');
	include('con.php');
	require '../vendor/autoload.php';

	use Carbon\Carbon;
	carbon::setLocale('es');
	carbon::setUTF8(true);
	setlocale(LC_TIME, 'es_ES');
	date_default_timezone_set('America/Argentina/Buenos_Aires');

	if ($_POST['action'] === 'add' || $_POST['action'] === 'edit') {
		$id = (int)$_POST['idNewsletter'];
		$idEventCalendar = (int)$_POST['idEventCalendar'];

		$dateExplode = explode('/', $_POST['inputDate']);
		$month = (int)$dateExplode[1];
		$year = (int)$dateExplode[2];
		$today = date("Y-m-d H:i:s");

		$dateFormatDB = Carbon::createFromFormat('d/m/Y', $_POST['inputDate'])->toDateString();
	}

	switch ($_POST['action']) {
		case 'add':
			
			$sql = "INSERT INTO calendars values(default, :month, :year, :date, :description, :time_init, :time_end, :newsletter_id, :created_at, :updated_at)";

		  $stmt = $db->prepare($sql);
		  
		  $stmt->bindValue(":month", $month, PDO::PARAM_INT);
		  $stmt->bindValue(":year", $year, PDO::PARAM_INT);
		  $stmt->bindValue(":date", $dateFormatDB, PDO::PARAM_STR);
		  $stmt->bindValue(":description", $_POST['description'], PDO::PARAM_STR);
		  $stmt->bindValue(":time_init", $_POST['inputTimeInit'] . ':00', PDO::PARAM_STR);
		  $stmt->bindValue(":time_end", $_POST['inputTimeEnd'] . ':00', PDO::PARAM_STR);
		  $stmt->bindValue(":newsletter_id", $id, PDO::PARAM_INT);
		  $stmt->bindValue(":created_at", $today, PDO::PARAM_STR);
		  $stmt->bindValue(":updated_at", $today, PDO::PARAM_STR);
		        
		  $save = $stmt->execute();
			
			echo $save;
			break;

			case 'edit':
			
			$sql = "
				UPDATE calendars 
				SET 
					month = :month,
					year = :year,
					date = :date,
					description = :description,
					time_init = :time_init,
					time_end = :time_end,
					newsletter_id = :newsletter_id,
					updated_at = :updated_at
				WHERE id = '$idEventCalendar' ";

		  $stmt = $db->prepare($sql);

		  $stmt->bindValue(":month", $month, PDO::PARAM_INT);
		  $stmt->bindValue(":year", $year, PDO::PARAM_INT);
		  $stmt->bindValue(":date", $dateFormatDB, PDO::PARAM_STR);
		  $stmt->bindValue(":description", $_POST['description'], PDO::PARAM_STR);
		  $stmt->bindValue(":time_init", $_POST['inputTimeInit'] . ':00', PDO::PARAM_STR);
		  $stmt->bindValue(":time_end", $_POST['inputTimeEnd'] . ':00', PDO::PARAM_STR);
		  $stmt->bindValue(":newsletter_id", $id, PDO::PARAM_STR);
		  $stmt->bindValue(":updated_at", $today, PDO::PARAM_STR);
		        
		  $save = $stmt->execute();

			echo $save;
			break;

		case 'delete':
			// Id del producto a eliminar
		  $id = (int)$_POST['id'];
		        
		  $sql = "DELETE FROM calendars WHERE id='$id'";
		  $stmt = $db->prepare($sql);
		  $result = $stmt->execute();

		  echo json_encode($result);
			break;
	}

?>