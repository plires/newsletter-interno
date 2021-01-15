<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a  href="./" class="transition brand-link d-flex justify-content-center align-items-center">
    <img class="img-fluid" src="img/vistage.png" alt="vistage Logo">
    <!-- <span class="brand-text font-weight-light">AdminLTE 3</span> -->
  </a>
  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="img/logo-vistage-20-anos.gif" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="logout.php" class="d-block transition aside_nombre_usuario"><i class="mr-2 fas fa-sign-out-alt"></i>{{ getNameUser }}</a>
      </div>
    </div>

    <div class="info">
      <p class="aside_datos_user">{{ currentSector.name }}</p>
      <p class="aside_datos_user">{{ getEmailUser }}</p>
    </div>

    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="info">
        <a data-toggle="modal" data-target="#modalUser" class="d-block transition configuracion_usuario"><i class="mr-2 fas fa-user-cog"></i>Configuracion Usuario</a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
         with font-awesome or any other icon font library -->
        
        <li class="nav-header">SECTORES</li>

        <li v-if="currentSector.code == 'gerencia-general' || currentSector.code == 'listado-newsletters'" class="nav-item">
          <a href="gerencia-general.php" class="nav-link transition <?php if ($current === 'gerencia-general') echo ' active'; ?>">
            <i class="nav-icon fas fa-users"></i>
            <p>
              Gerencia General
            </p>
          </a>
        </li>

        <li v-if="currentSector.code == 'gerencia-talento' || currentSector.code == 'listado-newsletters'" class="nav-item">
          <a href="gerencia-talento.php" class="nav-link transition <?php if ($current === 'gerencia-talento') echo ' active'; ?>">
            <i class="nav-icon fas fa-users"></i>
            <p>
              Gerencia de Talento <br>y Negocios
            </p>
          </a>
        </li>

        <li v-if="currentSector.code == 'administracion-finanzas' || currentSector.code == 'listado-newsletters'" class="nav-item">
          <a href="administracion-finanzas.php" class="nav-link transition <?php if ($current === 'administracion-finanzas') echo ' active'; ?>">
            <i class="nav-icon fas fa-users"></i>
            <p>
              Administracion y <br>Finanzas
            </p>
          </a>
        </li>

        <li v-if="currentSector.code == 'marketing' || currentSector.code == 'listado-newsletters'" class="nav-item">
          <a href="marketing.php" class="nav-link transition <?php if ($current === 'marketing') echo ' active'; ?>">
            <i class="nav-icon fas fa-users"></i>
            <p>
              Marketing
            </p>
          </a>
        </li>

        <li v-if="currentSector.code == 'operaciones' || currentSector.code == 'listado-newsletters'" class="nav-item">
          <a href="operaciones.php" class="nav-link transition <?php if ($current === 'operaciones') echo ' active'; ?>">
            <i class="nav-icon fas fa-users"></i>
            <p>
              Operaciones
            </p>
          </a>
        </li>

        <li v-if="currentSector.code == 'listado-newsletters'" class="nav-item">
          <a href="listado-newsletters.php" class="nav-link transition <?php if ($current === 'newsletters') echo ' active'; ?>">
            <i class="nav-icon fas fa-list"></i>
            <p>
              Listado de <br>Newsletters
            </p>
          </a>
        </li>

        <li v-if="currentSector.code == 'carga-tabla' || currentSector.code == 'listado-newsletters'" class="nav-item">
          <a href="carga-tabla.php" class="nav-link transition <?php if ($current === 'tabla') echo ' active'; ?>">
            <i class="nav-icon fas fa-table"></i>
            <p>
              Carga de Tabla
            </p>
          </a>
        </li>

        <li v-if="currentSector.code == 'listado-newsletters'" class="nav-item">
          <a href="calendarios.php" class="nav-link transition <?php if ($current === 'calendario') echo ' active'; ?>">
            <i class="nav-icon fas fa-calendar-alt"></i>
            <p>
              Calendarios
            </p>
          </a>
        </li>

      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>