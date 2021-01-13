<!-- Modal Datos Usuario -->
<div class="modal fade" id="modalUser">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- form start -->
      <form id="formUser" method="post" @submit="submitFormUser">

        <input type="hidden" name="user_id" v-model="user.id">

        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="modalFormUserLabel">Edición del Usuario</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">

          <div class="form-row">
          
            <div class="form-group col-md-12">
              <label for="user.email">Email</label>
              <input type="text" v-model="user.email" class="form-control" id="user.email" name="user.email" placeholder="Ingresa tu email de contacto">
            </div>

            <div class="form-group form-check">
              <input type="checkbox" class="form-check-input" id="pasCheck">
              <label class="form-check-label" for="pasCheck" @click="rememberPassword">Cambiar mi contraseña actual</label>
            </div>

            <div class="col-md-12" v-if="changePass">

              <div class="form-group">
                <label for="user.pass">Contraseña</label>
                <input type="password" class="form-control" id="pass" name="pass" placeholder="Ingresa la nueva contraseña">
                <small class="form-text text-muted">Mínimo 6 caracteres</small>

              </div>

              <div class="form-group">
                <label for="user.cpass">Repeti la Contraseña</label>
                <input type="password" class="form-control" id="cpass" name="cpass" placeholder="Repeti la nueva contraseña">
              </div>
              
            </div>

          </div>

          <div v-if="errorsUser.length > 0" id="errorUser" class="alert alert-danger alert-dismissible fade show fadeInLeft" role="alert">
            <strong>Por favor, corrija el/los siguiente/s error/es:</strong>
            <button @click="errorsUser = []" type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <ul>
              <li v-for="(errorUser, index) in errorsUser" :key="index">{{ errorUser }}</li>
            </ul>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Salvar Cambios</button>
        </div>
    </form>
      <!-- form start end -->

    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- Modal Datos Usuario end