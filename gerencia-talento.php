<?php 
  
  session_start();

  // Acceso permitido a sector Gerencia de Talentos y Admin unicamente.
  if (!$_SESSION || $_SESSION['sector_code'] != 'gerencia-talento' && $_SESSION['sector_code'] != 'all') { 
    session_destroy();
    header('Location: ./');
  } else {
  ?>

    <script>
      let sectorName='<?php echo $_SESSION["sector_name"];?>';
      let sectorCode='<?php echo $_SESSION["sector_code"];?>';
    </script>

  <?php 
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

  <title>Vistage - Newsletter, Gerencia de Talento</title>

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
  <div id="app" class="wrapper gerencia_talento">

    <!-- Notificacion de exito -->
    <?php require('includes/notificationSuccess.inc.php'); ?>
    <!-- Notificacion de exito end -->

    <!-- Nav -->
    <?php require('includes/admin/nav.inc'); ?>
    <!-- Nav end -->

    <!-- Aside -->
    <?php require('includes/admin/aside.inc.php'); ?>
    <!-- Aside end -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

      <!-- Main content -->
      <section class="content">

        <div id="loader" class="text-center">
          <div class="spinner-border" role="status">
            <span class="sr-only">Cargando...</span>
          </div>
        </div>

        <div class="container">

          <div class="row">
            <div class="col-md-12 text-center">
              <h1>Sector de Gerencia de Talento</h1>
            </div>
          </div>

          <!-- Listado de Newsletters del año actual -->
          <section class="row">
            <div class="col-md-12">

              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Newsletters del <?= date('Y'); ?></h3>
                </div>

                <div class="card-body">
                  <ul v-if="newslettersCurrentYear" class="pagination pagination-month justify-content-center">

                    <li v-for="newsletter in newslettersCurrentYear" :key="newsletter.id" :class="['page-item', newsletterActive(newsletter.month)]">
                      <button class="page-link" @click="setCurrentNewsletter(newsletter.id, 'gerencia_talento', 'preview_gerencia_talento')">
                          <p class="page-month">{{ newsletter.name_month }}</p>
                          <p class="page-year">{{ newsletter.year }}</p>
                      </button>
                    </li>
                  
                  </ul>

                  <p v-else>Aún no hay Newsletters cargados en el <?= date('Y'); ?></p>
                </div>
                
              </div>

            </div>
          </section>
          <!-- Listado de Newsletters del año actual end -->

          <!-- Preview -->
          <section v-if="currentNewsletter.execute == 0" class="row">
            <div id="preview_gerencia_talento" class="col-md-12">
              <div class="card card-primary">

                <div class="card-header">
                  <h3 class="card-title">Preview. {{ currentNewsletter.name }}</h3>
                </div>

                <div v-html="currentNewsletter.gerencia_talento" class="card-body">
                </div>

                <div class="card-footer">
                  <button id="btnEditar" type="button" @click="initSummerNote('comment_gerencia_talento', 'gerencia_talento', 'preview_gerencia_talento')" class="btn btn-primary float-right">Editar</button>
                </div>
                
              </div>
            </div>

            <div id="gerencia_talento" class="col-md-12">

              <div class="card card-warning">

                <div class="card-header">
                  <h3 class="card-title">Edición habilitada. {{ currentNewsletter.name }}</h3>
                </div>

                <!-- form start -->
                <form method="post" @submit.prevent="submitForm(currentNewsletter, 'comment_gerencia_talento', 'gerencia_talento', 'preview_gerencia_talento')">

                  <div class="card-body">
                    <div class="form-group">
                      <textarea id="comment_gerencia_talento" name="comment_gerencia_talento" class="form-control summernote" rows="3"></textarea>
                    </div>
                  </div>

                  <div class="card-footer">
                    <button id="btnGuardar" type="submit" class="btn btn-warning float-right ml-3">Guardar</button>
                    <button id="btnCancelar" type="button" @click="cancelEditNewsletter('gerencia_talento', 'preview_gerencia_talento')" class="btn btn-default float-right">Cancelar</button>
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
                <div v-html="currentNewsletter.gerencia_talento" class="card-body">
                </div>
              </div>
            </div>
          </section>
          <!-- Bloque que muestra el newsletter ya publicado -->
          <!-- Datos de gerencia_talento end -->

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
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/vue"></script> -->

<!-- Scripts custom -->
<script src="js/app.js"></script>

</body>
</html>
