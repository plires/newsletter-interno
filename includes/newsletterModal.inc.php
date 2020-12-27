<!-- Modal Nuevo Newsletter -->
<?php 
  $yearCurrent = (int)date('Y');
  $years = [];
  for ($i=0; $i < 5 ; $i++) { 
    array_push($years,$yearCurrent);
    $yearCurrent = $yearCurrent + 1;
  }
?>

<div class="modal fade" id="modalNewNewsletter">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div :class="['modal-header', newsletterEditMode ? 'bg-warning' : 'bg-primary']">
        <h4 class="modal-title">Nuevo Newsletter</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <!-- form start -->
      <form method="post" @submit.prevent="validInputsFromNewsletter('add')">
        <input type="hidden" id="newsletterId" name="newsletterId">
        <div class="modal-body">

          <div class="row">

            <div :class="[newsletterEditMode ? 'col-md-12' : 'col-md-6']">
              <div class="form-group">
                <label for="name">Nombre / Título</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Vistage Digital - Agosto 2020">
              </div>
            </div>

            <div :class="[newsletterEditMode ? 'd-none' : 'col-md-3']">
              <div class="form-group">
                <label for="selectMonth">Mes</label>
                <select class="form-control" id="selectMonth">
                  <option value="1">Enero</option>
                  <option value="2">Febrero</option>
                  <option value="3">Marzo</option>
                  <option value="4">Abril</option>
                  <option value="5">Mayo</option>
                  <option value="6">Junio</option>
                  <option value="7">Julio</option>
                  <option value="8">Agosto</option>
                  <option value="9">Septiembre</option>
                  <option value="10">Octubre</option>
                  <option value="11">Noviembre</option>
                  <option value="12">Diciembre</option>
                </select>
              </div>
            </div>

            <div :class="[newsletterEditMode ? 'd-none' : 'col-md-3']">
              <div class="form-group">
                <label for="selectYear">Año</label>
                <select class="form-control" id="selectYear">
                  <?php foreach ($years as $key => $value): ?>
                    <option value="<?= $value ?>"><?= $value ?></option>
                  <?php endforeach ?>
                </select>
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
          <button id="btnCancelar" type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
          <button id="btnGuardar" type="submit" :class="['btn', newsletterEditMode ? 'btn-warning' : 'btn-primary',  'ml-3']">Guardar Newsletter</button>
        </div>

      </form>
      <!-- form start end -->

    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- Modal Nuevo Newsletter end