<?php

require_once("repositorioUsers.php");

class RepositorioUsersSQL extends repositorioUsers
{
  protected $db;

  public function __construct($db) 
  {
    $this->db = $db;
  }

  public function getAllUsers() 
  {

    $sql = "SELECT * FROM users";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $users;

  }

}

?>
