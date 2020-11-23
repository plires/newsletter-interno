<?php

require_once("repositorioNewsletters.php");
require 'vendor/autoload.php';

use Carbon\Carbon;
carbon::setLocale('es');
carbon::setUTF8(true);
setlocale(LC_TIME, 'es_ES');
date_default_timezone_set('America/Argentina/Buenos_Aires');

class RepositorioNewslettersSQL extends repositorioNewsletters
{
  protected $db;

  public function __construct($db) 
  {
    $this->db = $db;
  }

  public function getAllNewsletters() 
  {

    $sql = "SELECT * FROM newsletters";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    $newsletters = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $newsletters;

  }

  public function getNewslettersCurrentYear() 
  {

    $date = Carbon::now();
    $currentYear = $date->year;

    $sql = "SELECT * FROM newsletters where year = '$currentYear'";
    $stmt = $this->db->prepare($sql);
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

    return $newsletterFinal;

  }

  public function getCurrentNewsletter()
  {

    $date = Carbon::now();
    $currentYear = $date->year;

    $sql = "SELECT * FROM newsletters WHERE year = '$currentYear' AND execute = 0 ";
    $stmt = $this->db->prepare($sql);
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

    return $newsletterFinal[0];

  }

}

?>
