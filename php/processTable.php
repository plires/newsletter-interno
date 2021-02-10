<?php

    include('../includes/config.inc');
    include('con.php');
    include '../clases/simplexlsx.class.php';

    function randomString() {
        return md5(rand(100, 200));
    }

    $save = false; // inicializo a false por si algun paso sale mal
    $success = 0; // inicializo la variable de exito

    // Si no hay archivo o es diferente a un .XLSX salir
    if (!$_FILES || $_FILES['file']['type'] != 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
      echo false;
      exit;
    }

    // Guardo el excel
    
    $name = randomString();
    $ext = explode('.',$_FILES['file']['name']);
    $filename = $name.'.'.$ext[1];
    $destination = SITE_ROOT . '/tablas/' .$filename;
    $location =  $_FILES["file"]["tmp_name"];
    $upload = move_uploaded_file($location,$destination);

    // Si el archivo se subio con exito entonces borro la tabla del newsletter $id
    if ($upload) { 

      $success += 1; // se suma 1 si guardo el excel

      $id = $_POST['id'];
      $month = $_POST['month'];
      $year = $_POST['year'];
      
      $sql = "DELETE FROM tables WHERE newsletter_id = ".$id." ";
      $stmt = $db->prepare($sql);
      $deleteTableFromBDD = $stmt->execute();
    }

    // Si se borro la tabla del newsletter $id genero el archivo intermedio datos.csv con el excel ya subido
    // y luego lo grabamos en la base de datos
    if ($deleteTableFromBDD) {
      $success += 1; // se suma 1 si borro la tabla de la base de datos

      $xlsx = new SimpleXLSX( $destination );
      
      $fp = fopen( '../datos.csv', 'w');//Abrire un archivo "datos.csv", sino existe se creara
      foreach( $xlsx->rows() as $fields ) {//Itero la hoja de calculo
            fputcsv( $fp, $fields);//Doy formato CSV a una línea y le escribo los datos
      }

      fclose($fp);//Cierro el archivo "datos.csv"

      $sql = "INSERT INTO tables (month, year, name, ec, rp, cs, total, newsletter_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
      $stmt = $db->prepare($sql);
      $stmt->bindParam( 1, $month);
      $stmt->bindParam( 2, $year);
      $stmt->bindParam( 3, $name);
      $stmt->bindParam( 4, $ec);
      $stmt->bindParam( 5, $rp);
      $stmt->bindParam( 6, $cs);
      $stmt->bindParam( 7, $total);
      $stmt->bindParam( 8, $newsletterId);
      foreach ($xlsx->rows() as $fields)
      {
        $month = $month;
        $year = $year;
        $name = $fields[0];
        $ec = $fields[1];
        $rp = $fields[2];
        $cs = $fields[3];
        $total = $fields[4];
        $newsletterId = $id;
        $save = $stmt->execute();
      }

    }

    if ($save) {
      $success += 1; // se suma 1 si guardo en la base de datos la nueva tabla
      unlink($destination); // Borro el archivo subido para no juntar basura
    }

    if ($success === 3) {
      echo true;
    } else {
      echo false;
    }
