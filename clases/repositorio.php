<?php

abstract class Repositorio {
  protected $repositorioTables;
  protected $repositorioNewsletters;
  protected $repositorioCalendars;
  protected $repositorioUsers;

  public function getRepositorioTables() {
    return $this->repositorioTables;
  }

  public function getRepositorioNewsletters() {
    return $this->repositorioNewsletters;
  }

  public function getRepositorioCalendars() {
    return $this->repositorioCalendars;
  }

  public function getRepositorioUsers() {
    return $this->repositorioUsers;
  }

}

?>