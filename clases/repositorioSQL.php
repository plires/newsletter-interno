<?php

require_once("repositorio.php");
require_once("repositorioTablesSQL.php");
require_once("repositorioNewslettersSQL.php");
require_once("repositorioCalendarsSQL.php");
require_once("repositorioUsersSQL.php");

class RepositorioSQL extends Repositorio {

  protected $db;

  /**
   * [__construct Establece la db con la base]
   */
  public function __construct() {

    try {
      $this->db = new PDO(DSN, DB_USER, DB_PASS);
    } catch (Exception $e) {
      echo 'No se pudo conectar a la base de datos. Intente en un momento por favor...';
    }

    $this->repositorioTables = new RepositorioTablesSQL($this->db);
    $this->repositorioNewsletters = new RepositorioNewslettersSQL($this->db);
    $this->repositorioCalendars = new RepositorioCalendarsSQL($this->db);
    $this->repositorioUsers = new RepositorioUsersSQL($this->db);

  }
}

?>
