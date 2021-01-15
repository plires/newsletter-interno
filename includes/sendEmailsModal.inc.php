<!-- Modal Envio de Emails -->
<div class="modal fade" id="modalSendEmails">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header bg-primary">
        <h4 class="modal-title">Aviso para sectores.</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <!-- form start -->
      <form method="post" @submit.prevent="sendEmailsToAllSectors()">
        <input type="hidden" id="newsletterId" name="newsletterId">
        <div class="modal-body">
          <div class="row">

            <div id="contentNotificationes" class="col-md-12">
              <div class="alert alert-dismissible">
                <h5><i class="icon fas fa-check"></i> Envio Exitoso!</h5>
                <span id="successSend"></span>
              </div>
            </div>

            <div class="col-md-12">
              <div class="card-body">

                <!-- Loader -->
                <?php // require('loader.inc.php'); ?>
                <!-- Loader end -->

                <div class="callout callout-info">
                  <i class="fas fa-bullhorn"></i>
                  <h5>Esta acción dara aviso a todos los sectores, para completar el newsletter con los siguientes datos:</h5>
                  <br>
                  <p><strong>Nombre del Newsletter:</strong><span id="title" class="badge bg-primary "></span></p>
                  <p><strong>Mes:</strong><span id="month" class="badge bg-primary "></span></p>
                  <p><strong>Año:</strong><span id="year" class="badge bg-primary "></span></p>
                </div>
              </div>
            </div>

          </div>

          <!-- Errores -->
          <div class="errors col-md-12 mt-2">
            <p v-if="errors.length">
              <b>Por favor, corrija el(los) siguiente(s) error(es):</b>
            </p>
            <ul>
              <li v-for="error in errors">{{ error }}</li>
            </ul>
          </div>
          <!-- Errores end -->

        </div>
     
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary ml-3]">Enviar Aviso</button>
        </div>

      </form>
      <!-- form start end -->

    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- Modal Envio de Emails end