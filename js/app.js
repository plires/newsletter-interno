const root = 'http://localhost:8888/vistage/propuestas/newsletter-dinamico/';
// const root = 'https://vistage.com.ar/newsletter-dinamico/';

let app = new Vue({
  el: '#app',

  /**
    * @return newslettersCurrentYear {array} - Array vacio (contendrá los newsletters del año en curso)
    * @return currentNewsletter {object} - objecto vacio (contendrá datos del newsletter activo en ese momento)
    * @return currentSector {object} - objecto vacio (contendrá datos del sector en curso que esta editando el newsletter)
    * @return editorName {string} - String vacio (contendra el nombre del editor summernote que se esta editando en ese momento)
    */
  data: function() {
    return {
      newslettersCurrentYear: [],
      tablesCurrentYear: [],
      calendarsCurrentYear: [],
      currentNewsletter: {},
      currentSector: {},
      editorName: '',
      fileInvalid: '',
      tableFile: '',
      idCalendarToDelete: '',
      idNewsletterToDelete: '',
      urlNewsletterToshare: '',
      calendarEditMode: false,
      newsletterEditMode: false,
      errors: [],
      user: {},
      changePass: false,
      errorsUser: []
    }
  },
  mounted() {
    this.getNewslettersCurrentYear()
    this.getTablesCurrentYear()
    this.getCalendarsCurrentYear()
    this.getUsers()
    this.setCurrentSector()
  },
  methods: {

    /**
    * Funcion que trae al usuario en curso y lo asigna a una variable global
    * @return this.user {object} - objecto con los datos del usuario
    */
    getUsers() { 
      loader();

      this.user = {}; // Inicializo con el objeto vacio.

      axios.all([
          axios.get(root + 'php/getUsers.php')
        ])
        .then(axios.spread((users) => {

          //Convertimos los tipos de datos
          users.data.forEach( function(element) {

            if (element.id == userId) {
              app.user = element
            }
            
          });
          delete this.user['pass'];

        $('#loader').fadeOut(500);

      }));
    },

    /**
    * Funcion que trae las tablas asociadas a los newsletters del año en curso 
    * @return this.tablesCurrentYear {object} - objecto con las tablas de los newsletters del año en curso
    */
    getTablesCurrentYear() { 
      loader();

      this.tablesCurrentYear = []; // Inicializo con el array vacio.

      axios.all([
          axios.get(root + 'php/getTablesCurrentYear.php')
        ])
        .then(axios.spread((tables) => {

          //Convertimos los tipos de datos
          tables.data.forEach( function(element) {
            element.id = parseInt(element.id)
            element.month = parseInt(element.month)
            element.newsletter_id = parseInt(element.newsletter_id)
            app.tablesCurrentYear.push(element);
          });

        $('#loader').fadeOut(500);
      }));
    },

    /**
    * Funcion que trae los calendarios asociados a los newsletters del año en curso 
    * @return this.calendarsCurrentYear {object} - objecto con las tablas de los newsletters del año en curso
    */
    getCalendarsCurrentYear() { 
      loader();

      this.calendarsCurrentYear = []; // Inicializo con el array vacio.

      axios.all([
          axios.get(root + 'php/getCalendarsCurrentYear.php')
        ])
        .then(axios.spread((tables) => {

          //Convertimos los tipos de datos
          tables.data.forEach( function(element) {
            element.id = parseInt(element.id)
            element.month = parseInt(element.month)
            element.newsletter_id = parseInt(element.newsletter_id)
            app.calendarsCurrentYear.push(element);
          });

        $('#loader').fadeOut(500);
      }));
    },

    /**
    * Funcion que trae los newsletter del año en curso 
    * @return this.newslettersCurrentYear {object} - objecto con los newsletters del año en curso
    */
    getNewslettersCurrentYear() { 
      loader();

      this.newslettersCurrentYear = []; // Inicializo con el array vacio.

      axios.all([
          axios.get(root + 'php/getNewslettersCurrentYear.php')
        ])
        .then(axios.spread((newsletters) => {

        // Convertimos los tipos de datos
        newsletters.data.forEach( function(element) {
          element.id = parseInt(element.id)
          element.execute = parseInt(element.execute)
          element.year = parseInt(element.year)
          element.month = parseInt(element.month)
          app.newslettersCurrentYear.push(element);
        });

        this.setNewsletterToEdit() // Setea el newsletter a editar o al ultimo del año en caso que todos esten publicados ya        

        $('#loader').fadeOut(500);
      }));
    },

    checkFormUser: function() {

      this.errorsUser = [];

      if (!this.user.email) {
        this.errorsUser.push('El email de contacto obligatorio.');
      }

      if (this.changePass) {

        let pass = $('#pass').val();
        let cpass = $('#cpass').val();

        if (!pass || !cpass ) {
          this.errorsUser.push('Ingresa la contraseña.');
        }

        if (pass != cpass ) {
          this.errorsUser.push('Las contraseñas no coinciden.');
        } 

        if (pass.length < 6 || cpass.length < 6 ) {
          this.errorsUser.push('Las contraseñas deben tener al menos 6 caracteres.');
        } 

      }

    return this.errorsUser;
    },

    submitFormUser(e){
      e.preventDefault();
      this.checkFormUser();

      if (this.errorsUser.length === 0) {

        let data = $('#formUser').serialize();

        let url = root + 'php/editUser.php';

        loader();
        $.ajax({
          type: 'POST',
          url: url,
          data: data,
          success: function(response) {
            if (response) {
              $('#modalUser').modal('hide');
              createToasts('bg-success', 'Usuario', 'Edición', 'El usuario se editó existosamente.')
              app.getUsers();
              $('#loader').fadeOut(500);
            } else {
              createToasts('bg-danger', 'Newsletter', 'Accion', 'Hubo un error, intente nuevamente.')
            }
          },
          fail: function() {
            $('#loader').fadeOut(500);
            createToasts('bg-danger', 'Newsletter', 'Accion', 'Hubo un error, intente nuevamente.')
          }
        });

      }
    },

    rememberPassword() {
      this.changePass = !this.changePass;
    },

    /**
    * Funcion que Trae el newsleter proximo a publicarse ( el que se encuentra en edicion ) 
    * @return this.currentNewsletter {object} - objecto con el newsletter activo en ese momento
    */
    setNewsletterToEdit: function() {
      let currentNewsletter = this.newslettersCurrentYear.filter(function (element) { 
          return element.execute == 0; // Si el newsletter aun no se ejecuto
      });

      if (currentNewsletter.length === 0) { // No deberia pero si todos los newsletter del año estan publicados, se sellecciona por default como "currentNewsletter" el ultimo del año
        let index = this.newslettersCurrentYear.length;
        this.currentNewsletter = this.newslettersCurrentYear[index-1]; //se sellecciona por default como "currentNewsletter" el ultimo del año
      } else {
        this.currentNewsletter = currentNewsletter[0]; //si hay un newsletter por editar se asigna a "this.currentNewsletter"
      }
    },

    /**
    * Funcion para agregar clase "active" al menu superior de meses
    * @param month {Number} - Numero del mes
    * @return {string} - nombre de la clase que se agrega al li del mes activo en el menu de meses
    */
  	newsletterActive: function(month, year) { 
      if ( month === this.currentNewsletter.month && year === this.currentNewsletter.year ) {
      	return 'active';
      }
    },

    /**
    * Funcion que setea el newsletter en curso (al cambiar los meses en el menu superior)
    * @param id {Number} - id del newsletter
    * @return this.currentNewsletter {array} - array activo
    */
    setCurrentNewsletter: function(id, sectionOut, sectionIn) { 
      $('#'+sectionOut).css('display','none');
      $('#'+sectionIn).css('display','flex');
      this.currentNewsletter = {} // Inicializo con el array vacio.
    	let currentNewsletter = this.newslettersCurrentYear.filter(function (element) {
		    return element.id === id;
			});

      this.currentNewsletter = currentNewsletter[0]; // Asigno el newsletter activo
    },

    /**
    * Funcion que setea el sector del usuario en curso
    * @return this.currentSector.name {string} - Nombre del sector
    * @return this.currentSector.code {string} - Codigo del sector
    */
    setCurrentSector: function() { 
      this.currentSector.name = sectorName; // variable "sectorName" viene de la variable de session de PHP que se asigna en el login.
      this.currentSector.code = sectorCode; // variable "sectorCode" viene de la variable de session de PHP que se asigna en el login.
    },

    /**
    * Funcion que inicia el SummerNote a editar.
    * @param editorName {string} - Nombre del editor summernote a editar.
    * @param fieldDB {string} - Nombre del campo de la base de datos a editar
    */
    initSummerNote: function(editorName, fieldDB, sectionPreview) { 
      this.editorName = editorName // Se asigna el campo a editar.

      console.log(editorName)

      $('#'+fieldDB).css('display','flex'); // Se muestra el editor
      $('#'+sectionPreview).css('display','none'); // Se oculta el preview

      if ( editorName === 'comment_calendar' || 
        editorName === 'comment_comment_table_a' || 
        editorName === 'comment_comment_table_b' || 
        editorName === 'comment_comment_table_c' ||
        editorName === 'comment_observations_table' ) { //Sacamos el video y las imagenes del summernote si se trata de 
                                                        //los comentarios del calendario y las observaciones de tablas
        var insert = ['link']
      } else {
        var insert = ['link', 'picture', 'video']
      }

      $('#'+editorName).summernote({
        toolbar: [
          ['style', ['style']],
          ['font', ['bold', 'underline', 'clear']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['table', ['table']],
          ['insert', insert],
          ['view', ['fullscreen', 'codeview', 'help']],
        ],
        placeholder: 'Escribir aquí...',
        lang: 'es-ES',
        focus: true,
        dialogsInBody: true,
        dialogsFade: true,  // Add fade effect on dialogs
        disableDragAndDrop: true,
        callbacks: {
          onImageUpload: function(files) { // Funcion que se ejecuta cuando se carga una imagen
            app.sendFile(files[0],app.editorName);
          },
          onInit: function() { // Funcion que se ejecuta al inicializarse summernote
            // console.log('Summernote is launched');
          }
        }
      });

      $('#'+editorName).summernote('code', eval(`this.currentNewsletter.${fieldDB}`));  // Se asigna el codigo que viene de la base de datos
      $('#'+editorName).summernote('enable'); // Se habilita el editor
      $('#preview').css('display','none'); // Deshabilitamos la seccion de Preview
    },

    /**
    * Funcion para guardar los datos en la base de datos y activa o deshabilita 
    * elementos en funcion del exito o error de la operacion
    * @param currentNewsletter {Object} - Objeto con el newsletter a guardar
    * @param field {string} - nombre del summernote que se esta editando
    * @param column {string} - nombre del campo de la base de datos a editar
    * @param sectionPreview {string} - seccion de preview para el campo editado
    */
    submitForm(currentNewsletter, field, column, sectionPreview){
      loader();

      // Grabar en base de datos
      let updateNewsletter = this.updateNewsletter(currentNewsletter.id, field, column);

      updateNewsletter.then(function(result) {
        if (result) {
          app.getNewslettersCurrentYear()
          $('.summernote').summernote('destroy');
          createToasts('bg-success', 'Newsletter', 'Accion', 'Evento guardado con éxito.')
          $('#'+column).css('display','none'); // Se oculta  el summernote editado

          $('#'+sectionPreview).css('display','flex'); // Se muestra el preview

        } else {
          createToasts('bg-danger', 'Newsletter', 'Accion', 'Hubo un error al guardar el dato.')
          app.getNewslettersCurrentYear()
        }
      });

      $('#loader').fadeOut(500);

    },

    /**
    * Funcion para actualizar los datos en la base de datos a traves de ajax
    * @param idNewsletter {number} - id del newsletter a editar
    * @param field {string} - nombre del summernote que se esta editando
    * @param column {string} - nombre del campo de la base de datos a editar
    */
    updateNewsletter: function(idNewsletter, field, column ) {
      loader();

      let url = root + 'php/updateNewsletter.php';

      let fieldSector = $('#'+field).summernote('code');

      let promise = new Promise(function(resolve, reject) {
        $.ajax({
          url,
          data: {
            'idNewsletter': idNewsletter,
            'fieldSector': fieldSector,
            'column': column,
          },
          type: "POST",
          success: function(response) {
            resolve(response);
          },
          error: function() {
            reject('Ocurrió un error, intente mas tarde por favor.');
          }
        });
      });

      $('#loader').fadeOut(500);

      return promise;
    },

    /**
    * Funcion para validar inputs de eventos de calendario
    * @param currentNewsletter {object} - newsletter actual
    * @param action {string} - accion (add/edit/delete)
    * @param column {string} - nombre del ID del summerNote a editar
    */
    validInputsFromCalendar(currentNewsletter, action, summerNoteID){

      this.errors = [];

      if ( $('#'+summerNoteID).summernote('isEmpty') ) {
        this.errors.push('Ingrese una descripción del evento');
      }

      let inputs = this.getInputsFromDateCalendar()

      if (!inputs[0]) {
        if (!this.isValidDate(inputs[0])) {
          this.errors.push('Debe ingresar una fecha váilda');
        }
      }

      if (!inputs[1]) {
        if (!this.validateFormatTime(inputs[1])) {
          this.errors.push('Debe ingresar un horario de inicio');
        }
      }

      if (!inputs[2]) {
        if (!this.validateFormatTime(inputs[2])) {
          this.errors.push('Debe ingresar un horario de cierre');
        }
      }

      let init = moment(inputs[1],'HH:mm');
      let end = moment(inputs[2],'HH:mm');

      if ( Math.sign(moment.duration( init - end )) != -1 ) { // Verifica si el horario de inicio es posterior al de fin
        this.errors.push('Verifique Horario de inicio y cierre');
      }

      if (this.errors.length === 0) {
        this.alterCalendar(currentNewsletter, action, summerNoteID)
      }

    },

    /**
    * Funcion para validar inputs del formulario de newsletters
    * @param action {string} - accion (add/edit/delete)
    */
    validInputsFromNewsletter(action){

      this.errors = [];

      let inputs = this.getInputsFromFormNewsletter()

      if (!inputs[0]) {
        if (!this.isValidDate(inputs[0])) {
          this.errors.push('Debe ingresar un nombre/título');
        }
      }

      if (!inputs[1]) {
        if (!this.validateFormatTime(inputs[1])) {
          this.errors.push('Debe ingresar un mes');
        }
      }

      if (!inputs[2]) {
        if (!this.validateFormatTime(inputs[2])) {
          this.errors.push('Debe ingresar un año');
        }
      }
      this.newslettersCurrentYear.forEach( function(element) {

        if ( element.month === parseInt(inputs[1]) && element.year === parseInt(inputs[2])) {
          if (app.newsletterEditMode === false) {
            app.errors.push('Ya existe un newsletter para este mes y año. Para remplazarlo debe eliminarlo previamente.');
          }
        }

      });

      if (this.errors.length === 0) {
        this.alterNewsletter(action)
      }

    },

    /**
    * Funcion para editar un newsletter
    * @param action {string} - accion (add/edit/delete)
    */
    alterNewsletter(action){
      loader();

      if (app.newsletterEditMode) {
        action = 'edit'
        var id = $('#newsletterId').val()
      } else {
        var id = 0;
      }

      let url = root + 'php/newsletter.php';

      let inputs = this.getInputsFromFormNewsletter()

      $.ajax({
        url,
        data: {
          'id': id,
          'action': action,
          'name': inputs[0],
          'month': inputs[1],
          'year': inputs[2],
        },
        type: "POST",
        success: function(response) {
          if (response == 'true') {
            app.getNewslettersCurrentYear()
            $('#modalNewNewsletter').modal('hide')
            createToasts('bg-success', 'Newsletter', 'Accion', 'Newsletter agregado / editado con éxito.')
            app.resetInputsFromFormNewsletter();
          } else {
            createToasts('bg-danger', 'Newsletter', 'Accion', 'Ocurrió un error, intente mas tarde por favor.')
          }
        },
        error: function() {
          createToasts('bg-danger', 'Newsletter', 'Accion', 'Ocurrió un error, intente mas tarde por favor.')
        }
      });

      $('#loader').fadeOut(500);

    },

    /**
    * Funcion para editar un evento calendario
    * @param currentNewsletter {object} - newsletter actual
    * @param action {string} - accion (add/edit/delete)
    * @param summerNoteID {string} - nombre del ID del summerNote a editar
    */
    alterCalendar(currentNewsletter, action, summerNoteID){
      loader();

      let url = root + 'php/calendar.php';
      let fieldSector = $('#'+summerNoteID).summernote('code');

      let inputs = this.getInputsFromDateCalendar()

      $.ajax({
        url,
        data: {
          'action': action,
          'idNewsletter': currentNewsletter.id,
          'idEventCalendar': inputs[3],
          'description': fieldSector,
          'inputDate': inputs[0],
          'inputTimeInit': inputs[1],
          'inputTimeEnd': inputs[2]
        },
        type: "POST",
        success: function(response) {
          if (response) {
            app.getCalendarsCurrentYear()
            $('#modalNewEvent').modal('hide')
            $('.summernote').summernote('destroy');
            createToasts('bg-success', 'Newsletter', 'Accion', 'El evento se agregó con éxito')
            app.resetInputsFromDateCalendar();
          } else {
            createToasts('bg-danger', 'Evento', 'Accion', 'Ocurrió un error, intente mas tarde por favor.')
          }
        },
        error: function() {
          createToasts('bg-danger', 'Evento', 'Accion', 'Ocurrió un error, intente mas tarde por favor.')
        }
      });

      $('#loader').fadeOut(500);

    },

    /**
    * Funcion para validar inputs de fecha con formato "mm/dd/yyyy"
    * @param dateString {string} - id del newsletter a editar
    */
    isValidDate(dateString){

      // First check for the pattern
      if(!/^\d{1,2}\/\d{1,2}\/\d{4}$/.test(dateString))
          return false;

      // Parse the date parts to integers
      var parts = dateString.split("/");
      var day = parseInt(parts[1], 10);
      var month = parseInt(parts[0], 10);
      var year = parseInt(parts[2], 10);

      // Check the ranges of month and year
      if(year < 1000 || year > 3000 || month == 0 || month > 12)
          return false;

      var monthLength = [ 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31 ];

      // Adjust for leap years
      if(year % 400 == 0 || (year % 100 != 0 && year % 4 == 0))
          monthLength[1] = 29;

      // Check the range of the day
      return day > 0 && day <= monthLength[month - 1];
    },

    /**
    * Funcion para validar inputs de time con formato "hh:mm"
    * @param timeString {string} - id del newsletter a editar
    */
    validateFormatTime(timeString) {
      let isValid = /^([0-1]?[0-9]|2[0-4]):([0-5][0-9])(:[0-5][0-9])?$/.test(timeString.value);

      return isValid;
    },

    /**
    * Funcion para obtener los valores de los inputs del formulario de Calendario
    */
    getInputsFromDateCalendar(){
      
      let inputDate = $('#inputDate')[0].value
      let inputTimeInit = $('#inputTimeInit')[0].value
      let inputTimeEnd = $('#inputTimeEnd')[0].value
      let inputIdEventCalendar = $('#idEventCalendar')[0].value

      return [inputDate, inputTimeInit, inputTimeEnd, inputIdEventCalendar]

    },

    /**
    * Funcion para obtener los valores de los inputs del formulario de Calendario
    */
    getInputsFromFormNewsletter(){
      
      let inputName = $('#name')[0].value
      let inputMonth = $('#selectMonth')[0].value
      let inputYear = $('#selectYear')[0].value

      return [inputName, inputMonth, inputYear]

    },

    /**
    * Funcion para setear los valores de los inputs del formulario de Calendario
    */
    setInputsFromDateCalendar(event){

      this.initSummerNote('comment_calendar', 'description', null);

      $('#comment_calendar').summernote('code', eval(`event[0].description`));  // Se asigna el codigo que viene de la base de datos
      
      $('#idEventCalendar')[0].value = event[0].id

      $('#inputDate')[0].value = moment(event[0].date).format("DD/MM/YYYY")

      let timeInit = event[0].time_init
      $('#inputTimeInit')[0].value = timeInit.slice(0, -3) //quitamos los segundos del campo que recibimos de la base de datos.

      let timeEnd = event[0].time_end
      $('#inputTimeEnd')[0].value = timeEnd.slice(0, -3) //quitamos los segundos del campo que recibimos de la base de datos.

    },

    /**
    * Funcion para resetear los valores de los inputs del formulario de Calendario
    */
    resetInputsFromDateCalendar(){
      $('#inputDate')[0].value = '';
      $('#inputTimeInit')[0].value = '';
      $('#inputTimeEnd')[0].value = '';
      $('.summernote').summernote('reset');
      $('.summernote').summernote('destroy');
    },

    /**
    * Funcion para resetear los valores de los inputs del formulario de alta del newsletter
    */
    resetInputsFromFormNewsletter(){
      $('#name')[0].value = '';
      $('#selectMonth')[0].value = '';
      $('#selectYear')[0].value = '';
    },

    /**
    * Funcion para setear el id del newsletter que sera eliminado en caso que se 
    * confirme la accion en el modal de confirmacion posteriormente
    */
    setIdNewsletterToDelete(id){
      this.idNewsletterToDelete = id; 
    },

    /**
    * Funcion para cancelar la eliminacion de un newsletter
    */
    cancelDeleteNewsletter(){
      this.idNewsletterToDelete = ''; 
    },

    /**
    * Funcion para eliminar un newsletter
    */
    deleteNewsletter(id){

      loader();

      let url = root + 'php/newsletter.php';

      $.ajax({
        type: 'POST',
        url: url,
        data: { 
          'id': id,
          'action': 'delete'
        },
        success: function(response) {
          if (response == 'true') {
            app.idNewsletterToDelete = '';
            $('#modalDelNewsletter').modal('hide')
            createToasts('bg-success', 'Newsletter', 'Accion', 'El newsletter se eliminó con éxito')
            app.getNewslettersCurrentYear()
          } else {
            createToasts('bg-danger', 'Newsletter', 'Accion', 'Hubo un error, intente nuevamente.')
          }
        }

      });

      $('#loader').fadeOut(500);
    },

    /**
    * Funcion para setear el id del evento de calendario que sera eliminado en caso que se 
    * confirme la accion en el modal de confirmacion posteriormente
    */
    setIdCalendarToDelete(id){
      this.idCalendarToDelete = id; 
    },

    /**
    * Funcion para cancelar la eliminacion de un evento calendario
    */
    cancelDeleteCalendar(){
      this.idCalendarToDelete = ''; 
    },

    /**
    * Funcion para eliminar un evento de calendario
    */
    deleteCalendar(id){

      loader();

      let url = root + 'php/calendar.php';

      $.ajax({
        type: 'POST',
        url: url,
        data: { 
          'id': id,
          'action': 'delete'
        },
        success: function(response) {
          if (response == 'true') {
            app.idCalendarToDelete = '';
            $('#modalDelEvent').modal('hide')
            app.getCalendarsCurrentYear()
            app.resetInputsFromDateCalendar()
          } else {
            createToasts('bg-danger', 'Newsletter', 'Accion', 'Hubo un error, intente nuevamente.')
          }
        }

      });

      $('#loader').fadeOut(500);
    },

    /**
    * Funcion que guarda la imagen en el servidor
    * @param file {File} - Datos de la imagen subida (name, size, tyoe, etc)
    * @param string {editorName} - Nombre del summernote que se esta editando
    */
    sendFile(file,editorName) {
      loader();
      data = new FormData();
      data.append("file", file);
      $.ajax({
        data: data,
        type: "POST",
        url: root + "/php/uploadImage.php",
        cache: false,
        contentType: false,
        processData: false,
        success: function(url) {
          let image = $('<img>').attr('src', url);
          $('#'+editorName).summernote("insertNode", image[0]);
        }
      });
      $('#loader').fadeOut(500);
    },

    /**
    * Funcion que cancela la edicion del newsletter
    */
    cancelEditNewsletter: function(sectionOut, sectionIn) {
      $('#'+sectionOut).css('display','none');
      $('#'+sectionIn).css('display','flex');
    },

    /**
    * Funcion que guarda la tabla en base de datos
    * @param evento {e} - datos del evento
    */
    submitUploadTable:function(e){
      e.preventDefault();

      loader();

      let formData = new FormData();
      formData.append('file', this.tableFile);
      formData.append('id', this.currentNewsletter.id);
      formData.append('month', this.currentNewsletter.month);
      formData.append('year', this.currentNewsletter.year);

      let url = root + 'php/processTable.php';

      $.ajax({
        data: formData,
        type: "POST",
        url: url,
        // cache: false,
        contentType: false,
        processData: false,
        success: function(response) {

          if (response == 1) {
            app.tableFile = '';
            $('.custom-file-label').text('Elegir Tabla');
            $('.custom-file-label').css('background-color','transparent');
            $('.custom-file-label').css('color','#212529');
            createToasts('bg-success', 'Tabla', 'Accion', 'La tabla se subio correctamente')
            app.getTablesCurrentYear()
          } else {
            createToasts('bg-danger', 'Tabla', 'Accion', 'Hubo un error al cargar la tabla. Por favor intente nuevamente')
          }
        }
      });

      $('#loader').fadeOut(500);

    },

    /**
    * Funcion para validar el input file de la subida de tabla
    */
    validInputFile() {

      this.fileInvalid = ''
      
      let file = this.$refs.myFileTable.files[0];
      if(
          !file || 
          file.type !== 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' || 
          file.size > 2000000
        )
      {
          this.fileInvalid = 'Archivos Permitidos Excel (.XLSX). Máx: 2mb'
          $('.custom-file-label').text('Elegir Tabla');
          $('.custom-file-label').css('background-color','red');
          $('.custom-file-label').css('color','white');
          $('.invalid-feedback').css('display','flex');
          return;
      } else {
          $('.custom-file-label').text(file.name);
          $('.custom-file-label').css('background-color','green');
          $('.custom-file-label').css('color','white');
          this.tableFile = file;
      }      
      
    },

    /**
    * Funcion para editar un evento del calendario en curso
    * @param int {id} - id del evento del calendario a editar
    * @param string {action} - nombre de la accion (add/edit/delete)
    */
    calendarEventToEdit(id, action) {

      this.calendarEditMode = true

      function getCalendar(element) { 
        return element.id === id;
      }

      let event = this.currentCalendarEvents.filter(getCalendar);

      this.setInputsFromDateCalendar(event)
      
    },

    /**
    * Funcion para enviar mails a todos los sectores avisando que hay un nuevo newsletter para editar / completar
    */
    sendEmailsToAllSectors() {
      loader();

      let id = $('#newsletterId').val();

      axios.post(root + 'php/sendEmailsToAllSectors.php', {
          id: id
      }).then(response => {

        $('#contentNotificationes').css('display','inline-block');
        $('.alert').css('display','flex');
        $('.alert').css('flex-direction','column');

        if (response.data) {

          $('.alert').removeClass('alert-danger');
          $('.alert').addClass('alert-success');
          var message = `<p>Se enviaron los avisos a todas las casillas de email</p>`
          setTimeout(function(){ 
            $('#modalSendEmails').modal('hide')
          }, 3000);
        } else {

          $('.alert').removeClass('alert-success');
          $('.alert').addClass('alert-danger');
          var message = `<p>Error al enviar los avisos. Intente nuevamente</p>`

        }
        
        $('#successSend').html(message);
        $('#loader').fadeOut(500);
      }).catch(e => {
          alert(e);
      });
    },

    /**
    * Funcion para preparar el envio por mail del nuevo nuesletter a edita
    * @param int {id} - id del newsletter a editar
    */
    newsletterToSend(id) {

      function getNewsletter(element) { 
        return element.id === id;
      }

      let newsletter = this.newslettersCurrentYear.filter(getNewsletter);

      $('#newsletterId').val(newsletter[0].id);
      $('#title').text(newsletter[0].name);
      $('#month').text(newsletter[0].name_month);
      $('#year').text(newsletter[0].year);
      $('#contentNotificationes').css('display','none');
      
    },

    /**
    * Funcion para editar un newsletter
    * @param int {id} - id del newsletter a editar
    * @param string {action} - nombre de la accion (add/edit/delete)
    */
    newsletterToEdit(id, action) {

      this.newsletterEditMode = true

      function getNewsletter(element) { 
        return element.id === id;
      }

      let newsletter = this.newslettersCurrentYear.filter(getNewsletter);

      $('#newsletterId').val(newsletter[0].id);
      $('#name')[0].value = newsletter[0].name;
      $('#selectMonth').val(newsletter[0].month);
      
      let x = document.getElementById("selectYear");
      let option = document.createElement("option");
      option.text = newsletter[0].year;
      x.add(option);

      $('#selectYear').val(newsletter[0].year);
      
    },

    /**
    * Funcion para compartir un newsletter
    * @param int {id} - id del newsletter a compartir
    */
    shareUrlNewsletter(id) {

      function getNewsletter(element) { 
        return element.id === id;
      }

      let newsletter = this.newslettersCurrentYear.filter(getNewsletter);
      this.urlNewsletterToshare = newsletter[0].url

    },

    /**
    * Funcion para cambiar el estado del newsletter (publicado / borrador)
    * @param int {id} - id del newsletter a cambiar el estado
    * @param status {int} - valor 1 / 0 en el campo "execute" de la base de datos
    */
    changeStatus: function(id, status) {
      loader();

      let url = root + 'php/changeStatusNewsletter.php';

      $.ajax({
        type: 'POST',
        url: url,
        data: {id: id, status: status},
        success: function(response) {
          if (response == 'true') {
            createToasts('bg-success', 'Newsletter', 'Estado', 'El newsletter cambió su estado con éxito')  
            app.getNewslettersCurrentYear();
          } else {
            createToasts('bg-danger', 'Newsletter', 'Accion', 'Hubo un error, intente nuevamente.')
            $('#loader').fadeOut(500);
          }
        },
        fail: function() {
          $('#loader').fadeOut(500);
          createToasts('bg-danger', 'Newsletter', 'Accion', 'Hubo un error, intente nuevamente.')
        }
      });
    }

  },

  computed: {
     /**
    * Funcion que devuelve la tabla del newsletter en curso
    */
    currentTable: function() {

      let currentNewsletterId = this.currentNewsletter.id

      function checkTable(element) { 
        return element.newsletter_id === currentNewsletterId;
      }

      let table = this.tablesCurrentYear.filter(checkTable);

      return table;
    },

    /**
    * Funcion que devuelve los eventos del calendario en curso
    */
    currentCalendarEvents: function() {

      let currentNewsletterId = this.currentNewsletter.id

      function checkCalendar(element) { 
        return element.newsletter_id === currentNewsletterId;
      }

      let calendar = this.calendarsCurrentYear.filter(checkCalendar);

      return calendar;
    }
  }

});

/**
* Funcion para mostrar el spin de load cuando se ejecuta al guna operacion asyncronica
*/
function loader() {
  $('#loader').css('display','flex');
  return;
}

$('#modalNewEvent').on('hide.bs.modal', function () {
  app.resetInputsFromDateCalendar();
  app.calendarEditMode = false;
  app.errors = [];
})

$('#modalNewNewsletter').on('hide.bs.modal', function () {
  app.newsletterEditMode = false;
  app.errors = [];
})

function createToasts(clase, title, subtitle, body) {
  $('#toastsContainerTopRight').show();
  $(document).Toasts('create', {
    class: clase,
    title: title,
    subtitle: subtitle,
    autohide: true,
    autoremove: true,
    delay: 1500,
    body: body
  })
}