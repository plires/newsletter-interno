const root = 'http://localhost:8888/vistage/propuestas/newsletter-dinamico/';

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
      currentNewsletter: {},
      currentSector: {},
      editorName: '',
      fileInvalid: '',
      tableFile: ''
    }
  },
  mounted() {
    this.getNewslettersCurrentYear()
    this.getTablesCurrentYear()
    this.setCurrentSector()
  },
  methods: {

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

        // this.setNewsletterToEdit() // Setea el newsletter a editar o al ultimo del año en caso que todos esten publicados ya        

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
  	newsletterActive: function(month) { 
      if ( month === this.currentNewsletter.month ) {
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
      // $('.foo').css('display','flex');alert('asd')
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

      console.log(sectionPreview);
      $('#'+fieldDB).css('display','flex'); // Se muestra el editor
      $('#'+sectionPreview).css('display','none'); // Se oculta el preview

      $('#'+editorName).summernote({
        toolbar: [
          ['style', ['style']],
          ['font', ['bold', 'underline', 'clear']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['table', ['table']],
          ['insert', ['link', 'picture', 'video']],
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
    * Funcion para guardar los datos en la base de datos y activa o deshabilita elementos en funcion del exito o error de la operacion
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
          // $('#'+field).css('display','none');
          $('#notifications').modal('show')
          $('#'+column).css('display','none'); // Se oculta  el summernote editado

          $('#'+sectionPreview).css('display','flex'); // Se muestra el preview

        } else {
          alert('Hubo un error al guardar el dato.')
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

      return promise;
    },

    /**
    * Funcion que guarda la imagen en el servidor
    * @param file {File} - Datos de la imagen subida (name, size, tyoe, etc)
    * @param string {editorName} - Nombre del summernote que se esta editando
    */
    sendFile(file,editorName) {
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
    },

    cancelEditNewsletter: function(sectionOut, sectionIn) {
      $('#'+sectionOut).css('display','none');
      $('#'+sectionIn).css('display','flex');
    },

    submitUploadTable:function(e){
      e.preventDefault();

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
            app.getTablesCurrentYear()
          } else {
            alert('Hubo un error al cargar la tabla. Por favor intente nuevamente')
          }
        }
      });

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
          return;
        } else {
          $('.custom-file-label').text(file.name);
          $('.custom-file-label').css('background-color','green');
          $('.custom-file-label').css('color','white');
          this.tableFile = file;
        }      
      
    }

  },

  computed: {
    currentTable: function() {

      let currentNewsletterId = this.currentNewsletter.id

      function checkTable(element) { 
        return element.newsletter_id === currentNewsletterId;
      }

      let table = this.tablesCurrentYear.filter(checkTable);

      return table;
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

// Validacion del Formulario
(function() {
  'use strict';
  window.addEventListener('load', function() {
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();