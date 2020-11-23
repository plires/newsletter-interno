<?php 

require('../includes/config.inc');

$name = randomString();
$ext = explode('.',$_FILES['file']['name']);
$filename = $name.'.'.$ext[1];
$destination = '/Users/admin/Dropbox/Proyectos/vistage/propuestas/newsletter-dinamico/uploads/'.$filename;
$location =  $_FILES["file"]["tmp_name"];
move_uploaded_file($location,$destination);
echo 'http://localhost:8888/vistage/propuestas/newsletter-dinamico/uploads/'.$filename;

function randomString() {
    return md5(rand(100, 200));
}

 ?>