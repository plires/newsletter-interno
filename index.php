<?php 
  
  session_start();

  if ($_SESSION) {
    header('Location: ' . $_SESSION['sector_code'] .'.php');
  }

  include_once('includes/config.inc');

  $email = '';
  $password = '';
  $errors = [];

  if (isset($_POST['send'])) {
  
    if ($_POST['email'] == '') {
      $errors['email'] = 'Ingresá un usuario';
    } else {
      $email = $_POST['email'];
    }

    if ($_POST['password'] == '') {
      $errors['password'] = 'Ingresá la contraseña';
    } else {
      $password = $_POST['password'];
    }
    
    if (count($errors) === 0) {
      include('php/login.php');
    }

  }
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Dashboard</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- CSS Custom -->
  <link rel="stylesheet" href="css/app.css">
</head>
<body class="login hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Login</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form id="login" method="post">
          <div class="card-body">

            <?php if ($errors): ?>
              <div id="error" class="alert alert-danger alert-dismissible fade show fadeInLeft" role="alert">
                <strong>¡Por favor verificá los datos!</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>

                <ul style="padding: 0;">
                  <?php foreach ($errors as $error) { ?>
                    <li> <?php echo $error; ?></li>
                  <?php } ?>
                </ul>

              </div>
            <?php endif ?>

            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" class="form-control" id="email" name="email" value="<?= $email ?>">
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" class="form-control" id="password" name="password">
            </div>
          </div>
          <!-- /.card-body -->

          <div class="card-footer">
            <button type="submit" name="send" class="btn btn-primary float-right">Enviar</button>
            <a class="reset_pass transition" href="reset_pass.php">Olvide mi contraseña</a>   
          </div>
        </form>
      </div>
    </section>
    <!-- /.content -->

  </div>
  <!-- /.content-wrapper -->
  
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="node_modules/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE -->
<script src="dist/js/adminlte.min.js"></script>
<!-- Scripts custom -->
<!-- <script src="js/app.js"></script> -->
</body>
</html>
