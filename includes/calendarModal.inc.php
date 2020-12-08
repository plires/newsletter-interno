<!-- Modal Nuevo Evento -->
<div class="modal fade" id="modalNewEvent">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div :class="['modal-header', calendarEditMode ? 'bg-warning' : 'bg-primary']">
        <h4 class="modal-title">Nueva Fecha Calendario</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <!-- form start -->
      <form method="post" @submit.prevent="validInputsFromCalendar(currentNewsletter, calendarEditMode ? 'edit' : 'add', 'comment_calendar')">
        <input type="hidden" id="idEventCalendar" name="idEventCalendar" value="">
        <div class="modal-body">

          <div class="row">

            <div class="col-md-4">
              <label for="datetimepicker">Fecha</label>
              <div class="input-group date" id="datetimepicker" data-target-input="nearest">
                  <input id="inputDate" name="datetimepicker" type="text" class="form-control datetimepicker-input" data-target="#datetimepicker"/>
                  <div class="input-group-append" data-target="#datetimepicker" data-toggle="datetimepicker">
                      <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                  </div>
              </div>
            </div>

            <div class="col-md-4">
              <label for="timePickerInit">Horario de Inicio</label>
              <div class="input-group date" id="timePickerInit" data-target-input="nearest">
                  <input id="inputTimeInit" name="timePickerInit" type="text" class="form-control datetimepicker-input" data-target="#timePickerInit"/>
                  <div class="input-group-append" data-target="#timePickerInit" data-toggle="datetimepicker">
                      <div class="input-group-text"><i class="fa fa-clock"></i></div>
                  </div>
              </div>
            </div>
            <div class="col-md-4">
              <label for="timePickerEnd">Horario de Cierre</label>
              <div class="input-group date" id="timePickerEnd" data-target-input="nearest">
                  <input id="inputTimeEnd" name="timePickerEnd" type="text" class="form-control datetimepicker-input" data-target="#timePickerEnd"/>
                  <div class="input-group-append" data-target="#timePickerEnd" data-toggle="datetimepicker">
                      <div class="input-group-text"><i class="fa fa-clock"></i></div>
                  </div>
              </div>
            </div>
          </div>

          <div class="form-group row mt-4">
            <div class="col-md-12">
              <textarea id="comment_calendar" name="comment_calendar" class="form-control summernote" rows="3"></textarea>
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
          <button id="btnGuardar" type="submit" :class="['btn', calendarEditMode ? 'btn-warning' : 'btn-primary',  'ml-3']">Guardar Fecha</button>
        </div>

      </form>
      <!-- form start end -->

    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- Modal Nuevo Evento end