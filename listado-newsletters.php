<?php 
  
  session_start();

  // Acceso permitido a Admin unicamente.
  if ($_SESSION['sector_code'] != 'all') { 
    session_destroy();
    header('Location: ./');
  } else {
  ?>

    <script>
      let sectorName='<?php echo $_SESSION["sector_name"];?>';
      let sectorCode='<?php echo $_SESSION["sector_code"];?>';
      let userId='<?php echo $_SESSION["user_id"];?>';
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

  <title>Vistage - Newsletter, Listados de Newsletters</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="node_modules/@fortawesome/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="node_modules/overlayscrollbars/css/OverlayScrollbars.min.css">
  <!-- CSS Custom -->
  <link rel="stylesheet" href="css/app.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
  <div id="app" class="wrapper listado">

    <?php $current = 'newsletters'; ?>

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
        <?php require_once('includes/userModal.inc.php'); ?>
        <!-- Modal formulario usuario end -->

        <div class="container">

          <div class="row">
            <div class="col-md-12 text-center">
              <h1>Últimos 15 Newsletters</h1>
            </div>
          </div>

          <!-- Preview -->
          <section  class="row">
            <div id="preview_newsletter" class="col-md-12">
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Newsletters {{ currentNewsletter.name }}</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">

                  <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                      <thead>
                        <tr>
                          <th style="width: 10px">#</th>
                          <th>Nombre</th>
                          <th>Mes</th>
                          <th>Año</th>
                          <th class="text-center">Acciones</th>
                          <th class="text-center">Publicado</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="(newsletter, index) in newslettersCurrentYear" :key="newsletter.id">
                          <td>{{ index + 1 }}</td>
                          <td>{{ newsletter.name }}</td>
                          <td>{{ newsletter.name_month }}</td>
                          <td>{{ newsletter.year }}</td>
                          <td class="text-left">
                            <div class="btn-group">

                              <button title="Editar" type="button" class="btn btn-default btn-flat" @click="newsletterToEdit(newsletter.id, 'edit')" data-toggle="modal" data-target="#modalNewNewsletter">
                                <i class="fas fa-edit"></i>
                              </button>

                              <button title="Eliminar" type="button" class="btn btn-default btn-flat" data-toggle="modal" data-target="#modalDelNewsletter" @click="setIdNewsletterToDelete(newsletter.id)">
                                <i class="fas fa-trash-alt"></i>
                              </button>

                              <button title="Enviar Mail de aviso a todos los sectores" type="button" class="btn btn-default btn-flat" @click="newsletterToSend(newsletter.id)" data-toggle="modal" data-target="#modalSendEmails">
                                <i class="far fa-envelope"></i>
                              </button>

                              <button v-if="newsletter.url != 0" title="Obtener Link del Newsletter para Compartir" type="button" class="btn btn-default btn-flat" @click="shareUrlNewsletter(newsletter.id)" data-toggle="modal" data-target="#modalShareUrlNewsletter">
                                <i class="fas fa-share-alt"></i>
                              </button>

                            </div>
                          </td>

                          <td class="text-center">
                            <div class="custom-control custom-switch status">
                              <div class="togglebutton">
                                <div class="custom-control custom-switch">
                                  <input @click="changeStatus(newsletter.id, newsletter.execute)" :checked="newsletter.execute" type="checkbox" class="custom-control-input" :id=newsletter.id>
                                  <label title="habilitar / deshabilitar" class="custom-control-label" :for="newsletter.id"></label>
                                </div>
                              </div>
                            </div>
                          </td>

                        </tr>
                      </tbody>
                    </table>
                  </div>
                  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modalNewNewsletter">
                    Nuevo Newsletter
                  </button>
                </div>
                <!-- /.card-footer -->
              </div>
            </div>

          </section>
          <!-- Preview end -->

        </div>

      </section>
      <!-- /.content -->

    </div>
    <!-- /.content-wrapper -->
    
    <!-- Footer -->
    <?php require('includes/admin/footer.inc'); ?>

    <!-- Compartir url newsletter -->
    <?php require('includes/modalShareUrlNewsletter.inc.php'); ?>
    <!-- Compartir url newsletter end -->

    <!-- Modal Envio de emails a sectores -->
    <?php require('includes/sendEmailsModal.inc.php'); ?>
    <!-- Modal Envio de emails a sectores end -->

    <!-- Modal formulario Newsletter -->
    <?php require('includes/newsletterModal.inc.php'); ?>
    <!-- Modal formulario Newsletter end -->

    <!-- Modal Confirmacion de eliminacion de de evento calendario -->
    <?php require('includes/confirmDelNewsletterModal.inc.php'); ?>
    <!-- Modal Confirmacion de eliminacion de de evento calendario end -->

  </div>
  <!-- ./wrapper -->

<!-- jQuery -->
<script src="node_modules/jquery/dist/jquery.min.js"></script>

<!-- Momment.js -->
<script src="node_modules/moment/min/moment.min.js"></script>
<script src="js/es.js"></script>

<!-- Bootstrap 4 -->
<script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="node_modules/overlayscrollbars/js/jquery.overlayScrollbars.min.js"></script>

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
