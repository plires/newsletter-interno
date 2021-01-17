<?php

	include('includes/config.inc');
	include('con.php');
	require 'vendor/autoload.php';

	if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM newsletters WHERE id = '$id'";
		$stmt = $db->prepare($sql);
		$stmt->execute();
		$newsletter = $stmt->fetch(PDO::FETCH_ASSOC);

		if (!$newsletter || $newsletter['execute'] == 0) {
  		header('location: 404.php');
		}

  } else {
  	header('location: 404.php');
  }

	use Carbon\Carbon;
	carbon::setLocale('es');
	carbon::setUTF8(true);
	setlocale(LC_TIME, 'es_ES');
	date_default_timezone_set('America/Argentina/Buenos_Aires');

	$date = Carbon::now();
	// var_dump(carbon::setUTF8(true)) ;
	$currentYear = $date->year;

	$sql = "SELECT * FROM calendars WHERE newsletter_id = '$id'";
	$stmt = $db->prepare($sql);
	$stmt->execute();
	$calendars = $stmt->fetchAll(PDO::FETCH_ASSOC);

	$sql = "SELECT * FROM tables WHERE newsletter_id = '$id'";
	$stmt = $db->prepare($sql);
	$stmt->execute();
	$rows_table = $stmt->fetchAll(PDO::FETCH_ASSOC);

	// NEWSLETTER: Agregamos una posicion con el nombre del mes a partir del numero
	$newsletter['name_month'] = ucfirst(getNameMonth($newsletter, 'localeMonth')); // Agregamos la posicion con el nombre

	$calendars_final = [];

	foreach ($calendars as $calendar) {
		// CALENDARIOS: Agregamos diferentes posiciones con el nombre del mes a partir del numero, el numero y nombre del dia
		$day = getNameDayAndNumber($calendar); // Obtenemos el nombre y numero del dia del evento
		$calendar['name_month'] = getNameMonth($calendar, 'localeMonth'); // Obtenemos el nombre y numero del dia del evento
		$calendar['name_day'] = $day['name']; // Agregamos la posicion con el nombre del dia
		$calendar['number_day'] = $day['number']; // Agregamos la posicion con el numero del dia

		$calendar['time_init'] = substr($calendar['time_init'], 0, -3);
		$calendar['time_end'] = substr($calendar['time_end'], 0, -3);
		
		array_push($calendars_final,$calendar);
	}

	function getNameMonth($array, $method){
		$dateCarbon = Carbon::parse('01-' .$array['month']. '-2020'); // Cualquier fecha, solo importa el mes
		$nameMonth = $dateCarbon->$method;
		return $nameMonth;
	}

	function getNameDayAndNumber($array){
		$day = [];
		$dateCarbon = Carbon::parse($array['date']); // Creamos el objeto de fecha
		$day['name'] = $dateCarbon->shortLocaleDayOfWeek;
		$day['number'] = $dateCarbon->day;
		return $day;
	}
?>