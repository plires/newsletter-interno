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

$sql = "SELECT * FROM newsletters where year = '$currentYear' ORDER BY month ASC";
$stmt = $db->prepare($sql);
$stmt->execute();
$newsletters = $stmt->fetchAll(PDO::FETCH_ASSOC);

$newsletterFinal = [];

// Modificamos el array para guardar el nombre del mes y no el numero del mes
foreach ($newsletters as $newsletter) {
  $dateCarbon = Carbon::parse('01-' .$newsletter['month']. '-2020'); // Cualquier fecha, solo importa el mes
  $nameMonth = $dateCarbon->shortLocaleMonth;
  $newsletter['name_month'] = ucfirst($nameMonth);

  array_push($newsletterFinal,$newsletter);
}

echo json_encode($newsletterFinal);

?>