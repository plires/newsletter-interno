<?php 
//Confeccionamos el HTML con los datos del usuario
$body='
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="es_ar">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <title>Vistage</title>

  <style type="text/css">
  </style>    
</head>
<body style="margin:0; padding:0; background-color:#fff;">
  <center>
    <table bgcolor="#fff" width="95%" border="0" cellpadding="0" cellspacing="0">
      <tr>
           <td height="40" style="font-size:10px; line-height:10px;">&nbsp;</td>
       </tr>
      <tr>
      <tr>
          <td align="center" valign="top">
            <img src="https://vistage.com.ar/2020/news/diciembre/img/vistage-email.gif" style="margin:0; padding:0; border:none; display:block;" border="0" alt="logo" /> 
          </td>
      </tr>
       
      <tr>
           <td height="30" style="font-size:10px; line-height:10px;">&nbsp;</td>
      </tr>

      <tr>
          <td align="center" valign="top">
            <h1 style="font-family: Arial; color: #093c5c">Hay un nuevo Newsletter interno para completar.</h1>
          </td>
      </tr>
     
      <tr>
           <td height="20" style="font-size:10px; line-height:10px;">&nbsp;</td>
      </tr>

      <tr>
          <td align="center" valign="top">
            <h2 style="font-family: Arial; color: #969696;"><Strong>Nombre: </Strong>'.$newsletter['name'].'</h2>
            <h2 style="font-family: Arial; color: #969696;"><Strong>Mes: </Strong>'.$newsletter['month'].'</h2>
            <h2 style="font-family: Arial; color: #969696;"><Strong>Año: </Strong>'.$newsletter['year'].'</h2>
          </td>
      </tr>

      <tr>
          <td align="center" valign="top">
            <h3 style="font-family: Arial; color: #093c5c">Haga click  <a href="'.PATH_ROOT.'/listado-newsletters.php">aquí</a> para completar la información de su sector.</h3>
          </td>
      </tr>

    </table>
  </center>
</body>
</html>
';
?>