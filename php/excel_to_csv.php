<?php
//Incluyo la clase
$xlsx = new SimpleXLSX( 'tablas/septiembre.xlsx' );//Instancio la clase y le paso como parametro el archivo a leer
$fp = fopen( 'datos.csv', 'w');//Abrire un archivo "datos.csv", sino existe se creara
 foreach( $xlsx->rows() as $fields ) {//Itero la hoja de calculo
        fputcsv( $fp, $fields);//Doy formato CSV a una línea y le escribo los datos
}
fclose($fp);//Cierro el archivo "datos.csv"
?>