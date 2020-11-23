<?php

try {
  $db = new PDO(DSN, DB_USER, DB_PASS);
} catch (Exception $e) {
  echo 'No se pudo conectar a la base de datos, intente mas tarde...';
}

?>