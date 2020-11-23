<?php

require_once("repositorioCalendars.php");

class RepositorioCalendarsSQL extends repositorioCalendars
{
  protected $db;

  public function __construct($db) 
  {
    $this->db = $db;
  }

  public function getAllCalendars() 
  {

    $sql = "SELECT * FROM calendars";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    $calendars = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $calendars;

  }

}

?>
