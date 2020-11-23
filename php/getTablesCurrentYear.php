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

$sql = "SELECT * FROM tables where year = '$currentYear' ORDER BY month ASC";
$stmt = $db->prepare($sql);
$stmt->execute();
$tables = $stmt->fetchAll(PDO::FETCH_ASSOC);

$tableFinal = [];

// Modificamos el array para guardar el nombre del mes y no el numero del mes
foreach ($tables as $table) {
  $dateCarbon = Carbon::parse('01-' .$table['month']. '-2020'); // Cualquier fecha, solo importa el mes
  $nameMonth = $dateCarbon->shortLocaleMonth;
  $table['name_month'] = ucfirst($nameMonth);

  array_push($tableFinal,$table);
}

echo json_encode($tableFinal);

?>