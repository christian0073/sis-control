<!-- Main Sidebar Container -->
  <aside class="main-sidebar elevation-2 sidebar-dark-navy">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="vistas/img/escudo-logo.png" alt="Escudo del instituto FIBONACCI" class="brand-image img-circle elevation-3">
      <span class="brand-text ">FIBONACCI</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="vistas/img/user.png" class="img-circle" alt="Icono del usuario">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $usuarioActivo['apellidoPaternoPersona']." ".$usuarioActivo['apellidoMaternoPersona'].' '.substr($usuarioActivo['nombresPersona'], 0,1)."."; ?></a>
        </div>
      </div>
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="inicio" class="nav-link">
              <i class="nav-icon fa-solid fa-house"></i>
              <p>Inicio</p>
            </a>
          </li>
          <?php if ($idUsuarioRol!=4 && $idUsuarioRol !=5): ?>
          <li class="nav-item">
            <a href="usuarios" class="nav-link">
              <i class="nav-icon fa-solid fa-user-gear"></i>
              <p>Usuarios</p>
            </a>
          </li>                         
          <li class="nav-item">
            <a href="#" id="ajustes" class="nav-link">
              <i class="nav-icon fa-solid fa-gear"></i>
              <p>
                Ajustes
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="carreras" class="nav-link">
                  <i class="fas fa-book-reader nav-icon"></i>
                  <p>Carreras</p>
                </a>
              </li>              
              <li class="nav-item">
                <a href="sedes" class="nav-link">
                  <i class="fas fa-city nav-icon"></i>
                  <p>Sedes</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="periodos" class="nav-link">
                  <i class="fa-solid fa-list-check nav-icon"></i>
                  <p>periodos</p>
                </a>
              </li>
            </ul>
          </li>       
          <?php endif ?>
          <?php if ($idUsuarioRol != 5): ?>
          <li class="nav-item ">
            <a href="secciones" class="nav-link">
              <i class="fa-solid fa-chalkboard-user nav-icon"></i>
              <p>
                Secciones
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" id="registrar" class="nav-link">
              <i class="nav-icon fa-solid fa-user-gear"></i>
              <p>
                Colaboradores
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="registrar" class="nav-link">
                  <i class="fa-solid fa-users nav-icon"></i>
                  <p>Personal</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="cambios" class="nav-link">
                  <i class="fa-solid fa-sort nav-icon"></i>
                  <p>Avance</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="supervisar" class="nav-link">
                  <i class="fa-solid fa-calendar-check nav-icon"></i>
                  <p>Supervisar</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="reprogramar" class="nav-link">
                  <i class="fa-solid fa-calendar-day nav-icon"></i>
                  <p>Reprogramación</p>
                </a>
              </li>
            </ul>
          </li>  
          <?php endif ?>
          <?php if ($idUsuarioRol !=4): ?>
          <li class="nav-item">
            <a href="subsanaciones" class="nav-link">
              <i class="nav-icon fa-solid fa-user-graduate"></i>
              <p>
                Subsanaciones
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="procesado" class="nav-link">
              <i class="nav-icon fa-solid fa-user-check"></i>
              <p>
                Procesados
              </p>
            </a>
          </li>          
          <?php endif ?>
          <?php if ($idUsuarioRol != 5): ?>
          <li class="nav-item">
            <a href="#" id="control" class="nav-link">
              <i class="nav-icon fa-solid fa-person-circle-check"></i>
              <p>
                Control asistencia
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <?php if ($idUsuarioRol == 2): ?>
              <li class="nav-item">
                <a href="corregir" class="nav-link">
                  <i class="nav-icon fa-solid fa-user-check"></i>
                  <p>
                    corregir asistencia
                  </p>
                </a>
              </li>
              <?php endif ?>
              <li class="nav-item">
                <a href="pagos" class="nav-link">
                  <i class="nav-icon fa-solid fa-money-bill-transfer"></i>
                  <p>
                    Pagos
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="importar-asistencia" class="nav-link">
                  <i class="nav-icon fa-solid fa-upload"></i>
                  <p>
                    Cargar Asistencias
                  </p>
                </a>
              </li>
            </ul>
          </li> 
          <?php endif ?> 
          <li class="nav-item">
            <a href="#" id="examenes" class="nav-link">
              <i class="nav-icon fa-solid fa-clipboard-list"></i>
              <p>
                Control examenes
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="examenes" class="nav-link">
                  <i class="nav-icon fa-solid fa-list-ul"></i>
                  <p>
                    Lista examenes
                  </p>
                </a>
              </li>     
              <li class="nav-item">
                <a href="lista-examenes" class="nav-link">
                  <i class="nav-icon fa-solid fa-list-check"></i>
                  <p>
                    Examenes entregados
                  </p>
                </a>
              </li>
            </ul>
          </li>  
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>