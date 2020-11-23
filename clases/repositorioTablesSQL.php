<?php

require_once("repositorioTables.php");
require 'vendor/autoload.php';

use Carbon\Carbon;

class RepositorioTablesSQL extends repositorioTables
{
  protected $db;

  public function __construct($db) 
  {
    $this->db = $db;
  }

  public function getAllTables() 
  {

    $sql = "SELECT * FROM tables";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    $tables = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $tables;

  }

  public function getTableCurrentMonth() 
  {

    $date = Carbon::now();
    $currentYear = $date->year;
    $currentMonth = $date->month;

    $sql = "SELECT * FROM tables WHERE month = '$currentMonth' AND year = '$currentYear'";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    $table = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $table;

  }

  public function getTableByNewsletterId($newsletterId) 
  {

    $sql = "SELECT * FROM tables WHERE newsletter_id = '$newsletterId'";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    $table = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $table;

  }

}

?>
