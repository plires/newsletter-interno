<?php
  require_once("clases/repositorioSQL.php");

  /* Include Sistema */
  include_once('sistema.php');

  switch ($soporte) {
    case 'sql':
      $db = new RepositorioSQL();
      break;
  }

?>