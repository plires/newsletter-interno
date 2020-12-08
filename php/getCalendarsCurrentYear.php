<?php

include('../includes/config.inc');
include('con.php');
require '../vendor/autoload.php';

use Carbon\Carbon;
carbon::setLocale('es');
carbon::setUTF8(true);
setlocale(LC_TIME, 'es_ES');
date_default_timezone_set('America/Argentina/Buenos_Aires');

$date = Carbon::now();
$currentYear = $date->year;

$sql = "SELECT * FROM calendars where year = '$currentYear' ORDER BY month ASC";
$stmt = $db->prepare($sql);
$stmt->execute();
$calendars = $stmt->fetchAll(PDO::FETCH_ASSOC);

$calendarFinal = [];


// Modificamos el array para guardar el nombre del mes y no el numero del mes
foreach ($calendars as $calendar) {

  $dateCarbon = Carbon::parse('01-' .$calendar['month']. '-2020'); // Cualquier fecha, solo importa el mes
  $nameMonth = $dateCarbon->shortLocaleMonth;
  $calendar['name_month'] = ucfirst($nameMonth);
  $calendar['day'] = ucfirst(Carbon::parse($calendar['date'])->dayName);
  $calendar['number'] = Carbon::parse($calendar['date'])->day;

  $calendar['init'] = Carbon::parse($calendar['time_init'])->format('H:i');
  $calendar['end'] = Carbon::parse($calendar['time_end'])->format('H:i');

  array_push($calendarFinal,$calendar);
}

echo json_encode($calendarFinal);

?>