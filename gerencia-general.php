<?php 
  
  session_start();

  // Acceso permitido a sector Gerencia General y Admin unicamente.
  if (!$_SESSION || $_SESSION['sector_code'] != 'gerencia-general' && $_SESSION['sector_code'] != 'listado-newsletters') { 
    session_destroy();
    header('Location: ./');
  } else {
    include_once('includes/variables-session.inc'); 
  }

  include_once('includes/config.inc');

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Favicons -->
  <?php include('includes/favicon.inc.php'); ?>

  <title>Vistage - Newsletter, Gerencia General</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="node_modules/@fortawesome/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="node_modules/overlayscrollbars/css/OverlayScrollbars.min.css">
  <!-- Summernote -->
  <link rel="stylesheet" href="node_modules/summernote/dist/summernote-bs4.min.css">
  <!-- CSS Custom -->
  <link rel="stylesheet" href="css/app.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
  <div id="app" class="wrapper gerencia_general">

    <?php $current = 'gerencia-general'; ?>

    <!-- Aside -->
    <?php require('includes/admin/aside.inc.php'); ?>
    <!-- Aside end -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

      <!-- Main content -->
      <section class="content">

        <!-- Loader -->
        <?php require('includes/loader.inc.php'); ?>
        <!-- Loader end -->

        <!-- Modal formulario usuario -->
        <?php require('includes/userModal.inc.php'); ?>
        <!-- Modal formulario usuario end -->

        <div class="container">

          <div class="row">
            <div class="col-md-12 text-center">
              <h1>Sector de Gerencia General</h1>
            </div>
          </div>

          <!-- Lista de los ultimos 15 Newsletters -->
          <?php require('includes/header_list_newsletters.inc.php'); ?>
          <!-- Lista de los ultimos 15 Newsletters end -->

          <!-- Preview -->
          <section v-if="currentNewsletter.execute == 0" class="row">
            <div id="preview_gerencia_general" class="col-md-12">
              <div class="card card-primary">

                <div class="card-header">
                  <h3 class="card-title">Preview. {{ currentNewsletter.name }}</h3>
                </div>

                <div v-html="currentNewsletter.gerencia_general" class="card-body">
                </div>

                <div class="card-footer">
                  <button id="btnEditar" type="button" @click="initSummerNote('comment_gerencia_general', 'gerencia_general', 'preview_gerencia_general')" class="btn btn-primary float-right">Editar</button>
                </div>
                
              </div>
            </div>

            <div id="gerencia_general" class="col-md-12">

              <div class="card card-warning">

                <div class="card-header">
                  <h3 class="card-title">Edición habilitada. {{ currentNewsletter.name }}</h3>
                </div>

                <!-- form start -->
                <form method="post" @submit.prevent="submitForm(currentNewsletter, 'comment_gerencia_general', 'gerencia_general', 'preview_gerencia_general')">

                  <div class="card-body">
                    <div class="form-group">
                      <textarea id="comment_gerencia_general" name="comment_gerencia_general" class="form-control summernote" rows="3"></textarea>
                    </div>
                  </div>

                  <div class="card-footer">
                    <button id="btnGuardar" type="submit" class="btn btn-warning float-right ml-3">Guardar</button>
                    <button id="btnCancelar" type="button" @click="cancelEditNewsletter('gerencia_general', 'preview_gerencia_general')" class="btn btn-default float-right">Cancelar</button>
                  </div>

                </form>

              </div>

            </div>
          </section>
          <!-- Preview end -->

          <!-- Bloque que muestra el newsletter ya publicado -->
          <section id="newsletter_publicado" v-else class="row"> 
            <div class="col-md-12">
              <div class="card card-secondary">
                <div class="card-header">
                  <h3 class="card-title">{{ currentNewsletter.name }}</h3>
                </div>
                <div v-html="currentNewsletter.gerencia_general" class="card-body">
                </div>
              </div>
            </div>
          </section>
          <!-- Bloque que muestra el newsletter ya publicado -->
          <!-- Datos de gerencia_general end -->

        </div>

      </section>
      <!-- /.content -->

    </div>
    <!-- /.content-wrapper -->
    
    <!-- Footer -->
    <?php require('includes/admin/footer.inc'); ?>
    <!-- Footer end -->

  </div>
  <!-- ./wrapper -->

<!-- jQuery -->
<script src="node_modules/jquery/dist/jquery.min.js"></script>

<!-- Bootstrap 4 -->
<script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

<!-- overlayScrollbars -->
<script src="node_modules/overlayscrollbars/js/jquery.overlayScrollbars.min.js"></script>

<!-- Summernote -->
<script src="node_modules/summernote/dist/summernote-bs4.js"></script>

<!-- Lang Summernote -->
<script src="js/summernote-es-ES.js"></script>

<!-- AdminLTE -->
<script src="dist/js/adminlte.min.js"></script>

<!-- axios -->
<script src="js/axios.min.js"></script>

<!-- versión de desarrollo, incluye advertencias de ayuda en la consola -->
<!-- <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/vue"></script>

<!-- Scripts custom -->
<script src="js/app.js"></script>

</body>
</html>
