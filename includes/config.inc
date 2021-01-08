<?php 

////////////////////////
///Valores Server
////////////////////////
define ('SITE_ROOT', realpath(dirname(__FILE__) . '/../') );
define ('LOCAL_FOLDER', 'vistage/propuestas/newsletter-dinamico');
define ('PATH_ROOT', (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/' . LOCAL_FOLDER );

////////////////////////
///Valores de DB Local
////////////////////////
define('DSN', 'mysql:host=localhost;dbname=vistage;charset=utf8;port:3306');
define('DB_USER', 'root');
define('DB_PASS', 'root');

//////////////////////////////
///Valores de Envio de emails
//////////////////////////////
define('SMTP', 'smtp.librecomunicacion.net');
define('USER_SMTP', 'pruebas@librecomunicacion.net');
define('PASS_SMTP', 'Perezzs$7478');
define('EMAIL_SENDER_SHOW', 'pruebas@librecomunicacion.net');
define('NAME_SENDER_SHOW', 'Vistage Newsletter');
define('EMAIL_PORT', 587);
define('EMAIL_SUBJECT', 'Nuevo Newsletter Vistage para completar');
define('EMAIL_CHARSET', 'utf-8');

?>