<?php 

require('../includes/config.inc');

$name = randomString();

$ext = explode('.',$_FILES['file']['name']);

$filename = $name.'.'.$ext[1];

$destination = SITE_ROOT . '/uploads/'.$filename;

$location =  $_FILES["file"]["tmp_name"];

move_uploaded_file($location,$destination);

echo PATH_ROOT .'/uploads/'.$filename;

function randomString() {
    return md5(rand(100, 200));
}

 ?>