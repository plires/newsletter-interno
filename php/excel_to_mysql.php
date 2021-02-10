<?php

    $xlsx = new SimpleXLSX( 'tablas/septiembre.xlsx' );
    
    $stmt = $conexion->prepare( "INSERT INTO tables (name, ec, rp, cs, total) VALUES (?, ?, ?, ?, ?)");
    $stmt->bindParam( 1, $name);
    $stmt->bindParam( 2, $ec);
    $stmt->bindParam( 3, $rp);
    $stmt->bindParam( 4, $cs);
    $stmt->bindParam( 5, $total);
    foreach ($xlsx->rows() as $fields)
    {
        $name = $fields[0];
        $ec = $fields[1];
        $rp = $fields[2];
        $cs = $fields[3];
        $total = $fields[4];
        $stmt->execute();
    }
