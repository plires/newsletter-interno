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

  <title>Vistage - Newsletter, Calendarios del Newsletter</title>

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
  <!-- Tempusdominus -->
  <link rel="stylesheet" href="node_modules/tempusdominus-bootstrap-4/build/css/tempusdominus-bootstrap-4.min.css">
  <!-- CSS Custom -->
  <link rel="stylesheet" href="css/app.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
  <div id="app" class="wrapper calendarios">

    <?php $current = 'calendario'; ?>

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

        <div class="container">

          <div class="row">
            <div class="col-md-12 text-center">
              <h1>Calendario de Eventos</h1>
            </div>
          </div>

          <!-- Lista de los ultimos 15 Newsletters -->
          <?php require('includes/header_list_newsletters.inc.php'); ?>
          <!-- Lista de los ultimos 15 Newsletters end -->

          <!-- Preview -->
          <section v-if="currentNewsletter.execute == 0" class="row">
            <div id="preview_calendar" class="col-md-12">
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Preview Calendarios {{ currentNewsletter.name }}</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">

                  <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                      <thead>
                        <tr>
                          <th style="width: 10px">#</th>
                          <th>Fecha</th>
                          <th>Horario Inicio</th>
                          <th>Horario Finalización</th>
                          <th>Descripción</th>
                          <th class="text-center">Acciones</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="(row, index) in currentCalendarEvents" :key="row.id">
                          <td>{{ index + 1 }}</td>
                          <td>{{ row.day }} {{ row.number }}</td>
                          <td>{{ row.init }}</td>
                          <td>{{ row.end }}</td>
                          <td v-html="row.description"></td>
                          <td class="text-center">
                            <div class="btn-group">
                              <button title="Editar" type="button" class="btn btn-default btn-flat" @click="calendarEventToEdit(row.id, 'edit')" data-toggle="modal" data-target="#modalNewEvent">
                                <i class="fas fa-edit"></i>
                              </button>
                              <button title="Eliminar" type="button" class="btn btn-default btn-flat" data-toggle="modal" data-target="#modalDelEvent" @click="setIdCalendarToDelete(row.id)">
                                <i class="fas fa-trash-alt"></i>
                              </button>
                            </div>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="button" class="btn btn-primary float-right" @click="initSummerNote('comment_calendar', 'description', null)" data-toggle="modal" data-target="#modalNewEvent">
                    Nuevo Evento
                  </button>
                </div>
                <!-- /.card-footer -->
              </div>
            </div>

          </section>
          <!-- Preview end -->

          <!-- Bloque que muestra el newsletter ya publicado -->
          <section id="newsletter_publicado" v-else class="row"> 
            <div class="col-md-12">

              <div class="card card-secondary">
                <div class="card-header">
                  <h3 class="card-title">Preview Calendarios {{ currentNewsletter.name }}</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">

                  <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                      <thead>
                        <tr>
                          <th style="width: 10px">#</th>
                          <th>Fecha</th>
                          <th>Horario Inicio</th>
                          <th>Horario Finalización</th>
                          <th>Descripción</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="(row, index) in currentCalendarEvents" :key="row.id">
                          <td>{{ index + 1 }}</td>
                          <td>{{ row.day }} {{ row.number }}</td>
                          <td>{{ row.init }}</td>
                          <td>{{ row.end }}</td>
                          <td v-html="row.description"></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>

                </div>
                <!-- /.card-body -->
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

    <!-- Modal formulario calendario -->
    <?php require('includes/calendarModal.inc.php'); ?>
    <!-- Modal formulario calendario end -->

    <!-- Modal Confirmacion de eliminacion de de evento calendario -->
    <?php require('includes/confirmDelCalendarModal.inc.php'); ?>
    <!-- Modal Confirmacion de eliminacion de de evento calendario end -->

  </div>
  <!-- ./wrapper -->

<!-- jQuery -->
<script src="node_modules/jquery/dist/jquery.min.js"></script>

<!-- Momment.js -->
<script src="node_modules/moment/min/moment.min.js"></script>
<script src="js/es.js"></script>

<!-- Tempusdominus -->
<script src="node_modules/tempusdominus-bootstrap-4/build/js/tempusdominus-bootstrap-4.min.js"></script>

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

<script type="text/javascript">
    $(function () {
        var CurrentDate = moment();
        $('#datetimepicker').datetimepicker({
          locale: 'es',
          defaultDate: CurrentDate,
          minDate: CurrentDate,
          format: 'L'
        });

        $('#timePickerInit').datetimepicker({
          locale: 'es',
          format: 'LT'
        });

        $('#timePickerEnd').datetimepicker({
          locale: 'es',
          format: 'LT'
        });

    });
</script>

<!-- Scripts custom -->
<script src="js/app.js"></script>

</body>
</html>
