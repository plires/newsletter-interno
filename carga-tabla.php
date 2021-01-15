<?php 
  
  session_start();

  // Acceso permitido a sector carga-tabla y Admin unicamente.
  if (!$_SESSION || $_SESSION['sector_code'] != 'carga-tabla' && $_SESSION['sector_code'] != 'listado-newsletters') { 
    session_destroy();
    header('Location: ./');
  } else {
    include_once('includes/variables-session.inc'); 
  }

  include_once('includes/config.inc');
  include_once('clases/simplexlsx.class.php');

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Favicons -->
  <?php include('includes/favicon.inc.php'); ?>

  <title>Vistage - Newsletter, Administración y finanzas</title>

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
  <div id="app" class="wrapper carga_tabla administracion_finanzas">

    <?php $current = 'tabla'; ?>

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
              <h1>Sector de Administración y Finanzas</h1>
            </div>
          </div>

          <!-- Lista de los ultimos 15 Newsletters -->
          <?php require('includes/header_list_newsletters.inc.php'); ?>
          <!-- Lista de los ultimos 15 Newsletters end -->

          <!-- Preview Tabla -->
          <section v-if="currentNewsletter.execute == 0" class="row">

              <!-- Tabla -->
              <div class="col-md-7">

                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">Preview Tabla {{ currentNewsletter.name }}</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th style="width: 10px">#</th>
                          <th>NOMBRE</th>
                          <th>EC</th>
                          <th>RP</th>
                          <th>CS</th>
                          <th>TOTAL</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="(row, index) in currentTable" :key="row.id">
                          <td>{{ index + 1 }}</td>
                          <td>{{ row.name }}</td>
                          <td>{{ row.ec }}</td>
                          <td>{{ row.rp }}</td>
                          <td>{{ row.cs }}</td>
                          <td>{{ row.total }}</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <!-- /.card-body -->
                  <div class="card-footer clearfix">

                    <form id="formTable" class="needs-validation" method="post" @submit="submitUploadTable" enctype="multipart/form-data" novalidate>
                      <div class="form-group">
                        <label for="tableInputFile">Remplazar actual tabla</label>
                        <div class="input-group">
                          <div class="custom-file">
                            <input required id="tableInputFile" ref="myFileTable" name="tableInputFile" @change="validInputFile" type="file" class="custom-file-input">
                            <label class="custom-file-label" for="tableInputFile">Elegir Tabla</label>

                          </div>

                          <div class="input-group-append">
                            <button id="send" ype="submit" class="input-group-text">Subir</button>
                          </div>

                        </div>
                        
                        <div class="invalid-feedback">
                          {{ fileInvalid }}
                        </div>

                      </div>
                    </form>

                  </div>
                </div>

              </div>
              <!-- Tabla end -->

              <div class="col-md-5">

                <!-- Preview Comment Table A -->
                <div id="preview_comment_table_a">
                  <div class="card card-primary">

                    <div class="card-header">
                      <h3 class="card-title">Comentarios Tabla A</h3>
                    </div>

                    <div v-html="currentNewsletter.comment_table_a" class="card-body">
                    </div>

                    <div class="card-footer">
                      <button id="btnEditar" type="button" @click="initSummerNote('comment_comment_table_a', 'comment_table_a', 'preview_comment_table_a')" class="btn btn-primary float-right">Editar</button>
                    </div>
                    
                  </div>
                </div>

                <div id="comment_table_a">

                  <div class="card card-warning">

                    <div class="card-header">
                      <h3 class="card-title">Edición habilitada. Comentarios Tabla A</h3>
                    </div>

                    <!-- form start -->
                    <form method="post" @submit.prevent="submitForm(currentNewsletter, 'comment_comment_table_a', 'comment_table_a', 'preview_comment_table_a')">

                      <div class="card-body">
                        <div class="form-group">
                          <textarea id="comment_comment_table_a" name="comment_comment_table_a" class="form-control summernote" rows="3"></textarea>
                        </div>
                      </div>

                      <div class="card-footer">
                        <button id="btnGuardar" type="submit" class="btn btn-warning float-right ml-3">Guardar</button>
                        <button id="btnCancelar" type="button" @click="cancelEditNewsletter('comment_table_a', 'preview_comment_table_a')" class="btn btn-default float-right">Cancelar</button>
                      </div>

                    </form>

                  </div>

                </div>
                <!-- Preview Comment Table A end -->

                <!-- Preview Comment Table B -->
                <div id="preview_comment_table_b">
                  <div class="card card-primary">

                    <div class="card-header">
                      <h3 class="card-title">Comentarios Tabla B</h3>
                    </div>

                    <div v-html="currentNewsletter.comment_table_b" class="card-body">
                    </div>

                    <div class="card-footer">
                      <button id="btnEditar" type="button" @click="initSummerNote('comment_comment_table_b', 'comment_table_b', 'preview_comment_table_b')" class="btn btn-primary float-right">Editar</button>
                    </div>
                    
                  </div>
                </div>

                <div id="comment_table_b">

                  <div class="card card-warning">

                    <div class="card-header">
                      <h3 class="card-title">Edición habilitada. Comentarios Tabla B</h3>
                    </div>

                    <!-- form start -->
                    <form method="post" @submit.prevent="submitForm(currentNewsletter, 'comment_comment_table_b', 'comment_table_b', 'preview_comment_table_b')">

                      <div class="card-body">
                        <div class="form-group">
                          <textarea id="comment_comment_table_b" name="comment_comment_table_b" class="form-control summernote" rows="3"></textarea>
                        </div>
                      </div>

                      <div class="card-footer">
                        <button id="btnGuardar" type="submit" class="btn btn-warning float-right ml-3">Guardar</button>
                        <button id="btnCancelar" type="button" @click="cancelEditNewsletter('comment_table_b', 'preview_comment_table_b')" class="btn btn-default float-right">Cancelar</button>
                      </div>

                    </form>

                  </div>

                </div>
                <!-- Preview Comment Table B end -->

                <!-- Preview Comment Table C -->
                <div id="preview_comment_table_c">
                  <div class="card card-primary">

                    <div class="card-header">
                      <h3 class="card-title">Comentarios Tabla C</h3>
                    </div>

                    <div v-html="currentNewsletter.comment_table_c" class="card-body">
                    </div>

                    <div class="card-footer">
                      <button id="btnEditar" type="button" @click="initSummerNote('comment_comment_table_c', 'comment_table_c', 'preview_comment_table_c')" class="btn btn-primary float-right">Editar</button>
                    </div>
                    
                  </div>
                </div>

                <div id="comment_table_c">

                  <div class="card card-warning">

                    <div class="card-header">
                      <h3 class="card-title">Edición habilitada. Comentarios Tabla C</h3>
                    </div>

                    <!-- form start -->
                    <form method="post" @submit.prevent="submitForm(currentNewsletter, 'comment_comment_table_c', 'comment_table_c', 'preview_comment_table_c')">

                      <div class="card-body">
                        <div class="form-group">
                          <textarea id="comment_comment_table_c" name="comment_comment_table_c" class="form-control summernote" rows="3"></textarea>
                        </div>
                      </div>

                      <div class="card-footer">
                        <button id="btnGuardar" type="submit" class="btn btn-warning float-right ml-3">Guardar</button>
                        <button id="btnCancelar" type="button" @click="cancelEditNewsletter('comment_table_c', 'preview_comment_table_c')" class="btn btn-default float-right">Cancelar</button>
                      </div>

                    </form>

                  </div>

                </div>
                <!-- Preview Comment Table C end -->

                <!-- Preview Observations Table -->
                <div id="preview_observations_table">
                  <div class="card card-primary">

                    <div class="card-header">
                      <h3 class="card-title">Observaciones Tabla</h3>
                    </div>

                    <div v-html="currentNewsletter.observations_table" class="card-body">
                    </div>

                    <div class="card-footer">
                      <button id="btnEditar" type="button" @click="initSummerNote('comment_observations_table', 'observations_table', 'preview_observations_table')" class="btn btn-primary float-right">Editar</button>
                    </div>
                    
                  </div>
                </div>

                <div id="observations_table" class="col-md-12">

                  <div class="card card-warning">

                    <div class="card-header">
                      <h3 class="card-title">Edición habilitada. Observaciones de la Tabla</h3>
                    </div>

                    <!-- form start -->
                    <form method="post" @submit.prevent="submitForm(currentNewsletter, 'comment_observations_table', 'observations_table', 'preview_observations_table')">

                      <div class="card-body">
                        <div class="form-group">
                          <textarea id="comment_observations_table" name="comment_observations_table" class="form-control summernote" rows="3"></textarea>
                        </div>
                      </div>

                      <div class="card-footer">
                        <button id="btnGuardar" type="submit" class="btn btn-warning float-right ml-3">Guardar</button>
                        <button id="btnCancelar" type="button" @click="cancelEditNewsletter('observations_table', 'preview_observations_table')" class="btn btn-default float-right">Cancelar</button>
                      </div>

                    </form>

                  </div>

                </div>
                <!-- Preview Observations Table end -->

              </div>
            
          </section>
          <!-- Preview Tabla end -->

          <!-- Bloque que muestra tabla del newsletter ya publicado -->
          <section id="newsletter_publicado" v-else class="row"> 
            <div class="col-md-7">

              <div class="card card-secondary">
                <div class="card-header">
                  <h3 class="card-title">Preview Tabla {{ currentNewsletter.name }}</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th style="width: 10px">#</th>
                        <th>NOMBRE</th>
                        <th>EC</th>
                        <th>RP</th>
                        <th>CS</th>
                        <th>TOTAL</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(row, index) in currentTable" :key="row.id">
                        <td>{{ index + 1 }}</td>
                        <td>{{ row.name }}</td>
                        <td>{{ row.ec }}</td>
                        <td>{{ row.rp }}</td>
                        <td>{{ row.cs }}</td>
                        <td>{{ row.total }}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>

            </div>

            <div class="col-md-5">

              <div class="card card-secondary foo">
                <div class="card-header">
                  <h3 class="card-title">Comentarios de Tabla - A</h3>
                </div>
                <div v-html="currentNewsletter.comment_table_a" class="card-body foo">
                </div>
              </div>

              <div class="card card-secondary foo">
                <div class="card-header">
                  <h3 class="card-title">Comentarios de Tabla - B</h3>
                </div>
                <div v-html="currentNewsletter.comment_table_b" class="card-body foo">
                </div>
              </div>

              <div class="card card-secondary foo">
                <div class="card-header">
                  <h3 class="card-title">Comentarios de Tabla - C</h3>
                </div>
                <div v-html="currentNewsletter.comment_table_c" class="card-body foo">
                </div>
              </div>

              <div class="card card-secondary foo">
                <div class="card-header">
                  <h3 class="card-title">Observaciones de la tabla</h3>
                </div>
                <div v-html="currentNewsletter.observations_table" class="card-body foo">
                </div>
              </div>

            </div>
              
          </section>
          <!-- Bloque que muestra tabla dell newsletter ya publicado -->
          <!-- Datos de administracion_finanzas end -->

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
