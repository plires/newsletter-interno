<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="./" class="brand-link d-flex justify-content-center align-items-center">
    <img class="img-fluid" src="img/vistage.png" alt="vistage Logo">
    <!-- <span class="brand-text font-weight-light">AdminLTE 3</span> -->
  </a>
  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="logout.php" class="d-block"><i class="mr-2 fas fa-sign-out-alt"></i>{{ currentSector.name }}</a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        
        <li class="nav-header">SECTORES</li>

        <li v-if="currentSector.code == 'administracion-finanzas' || currentSector.code == 'all'" class="nav-item">
          <a href="carga-tabla.php" class="nav-link">
            <i class="nav-icon far fa-calendar-alt"></i>
            <p>
              Carga de Tabla
              <span class="badge badge-info right">2</span>
            </p>
          </a>
        </li>

        <li v-if="currentSector.code == 'all'" class="nav-item">
          <a href="calendarios.php" class="nav-link">
            <i class="nav-icon far fa-image"></i>
            <p>
              Calendarios
            </p>
          </a>
        </li>

        <li v-if="currentSector.code == 'gerencia-general' || currentSector.code == 'all'" class="nav-item">
          <a href="gerencia-general.php" class="nav-link">
            <i class="nav-icon far fa-image"></i>
            <p>
              Gerencia General
            </p>
          </a>
        </li>

        <li v-if="currentSector.code == 'gerencia-talento' || currentSector.code == 'all'" class="nav-item">
          <a href="gerencia-talento.php" class="nav-link">
            <i class="nav-icon far fa-image"></i>
            <p>
              Gerencia de Talento y Negocios
            </p>
          </a>
        </li>

        <li v-if="currentSector.code == 'administracion-finanzas' || currentSector.code == 'all'" class="nav-item">
          <a href="administracion-finanzas.php" class="nav-link">
            <i class="nav-icon far fa-image"></i>
            <p>
              Administracion y Finanzas
            </p>
          </a>
        </li>

        <li v-if="currentSector.code == 'marketing' || currentSector.code == 'all'" class="nav-item">
          <a href="marketing.php" class="nav-link">
            <i class="nav-icon far fa-image"></i>
            <p>
              Marketing
            </p>
          </a>
        </li>

        <li v-if="currentSector.code == 'operaciones' || currentSector.code == 'all'" class="nav-item">
          <a href="operaciones.php" class="nav-link">
            <i class="nav-icon far fa-image"></i>
            <p>
              Operaciones
            </p>
          </a>
        </li>

      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>