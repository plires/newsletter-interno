<!-- Modal Confirmacion de eleminacion de evento -->
<div class="modal fade" id="modalDelEvent" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-danger">
        <h5 class="modal-title" id="modalDelEventLabel">Confirmar Eliminación</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="cancelDeleteCalendar()">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Esta seguro que desea eliminar este evento de manera permanente?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" @click="cancelDeleteCalendar()" data-dismiss="modal">No</button>
        <button type="button" class="btn btn-danger" @click="deleteCalendar(idCalendarToDelete)">Sí</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal Confirmacion de eleminacion de evento end