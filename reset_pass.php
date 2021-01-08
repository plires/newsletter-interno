<?php 

  $email = '';
  $errors = [];
  $message = [];

  if (isset($_POST['send'])) {
  
    if ($_POST['email'] == '') {
      $errors['email'] = 'Ingresá el email con el que te registraste';
    } else {
      $email = $_POST['email'];
    }
    
    if (count($errors) === 0) {
      include('php/reset.php');
    }

  }
?>

<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicons -->
    <?php include('includes/favicon.inc.php'); ?>

    <title>Vistage - Newsletter, Calendarios del Newsletter</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="node_modules/@fortawesome/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- CSS Custom -->
    <link rel="stylesheet" href="css/app.css">
  </head>
  <body>
    <div id="app" class="h-100">

      <div class="reset">

        <div>
          <div class="row">
            <div class="col-md-6 offset-md-3">

              <div class="jumbotron">

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

                <?php if ($message): ?>

                  <?php $email = ''; ?>
                  
                  <div class="alert alert-success alert-dismissible fade show fadeInLeft" role="alert">
                    <strong>¡Contraseña reseteada!</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>

                    <p><?php echo $message; ?></p>

                  </div>
                <?php endif ?>

                <form id="login" method="post">

                  <div class="form-group">
                    <label for="email">Email del usuario</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?= $email ?>">
                  </div>

                  <button type="submit" name="send" class="btn btn-primary float-right">Resetear Contraseña</button>
                  <a href="./" type="button" class="btn btn-secondary float-right  mr-3">Volver</a>
                </form>
                
              </div>

            </div>
          </div>
        </div>

      </div>
      
    </div>

    <!-- jQuery -->
    <script src="node_modules/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE -->
    <script src="dist/js/adminlte.min.js"></script>
  </body>
</html>