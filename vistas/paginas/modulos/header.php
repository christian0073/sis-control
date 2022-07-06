<?php 
  $periodoActivo = ControladorPeriodo::ctrMostrarPeriodoActivo();
  $planLectivo = ControladorPlan::ctrVerPlanACtivo();
 ?>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sistema de Matricula </title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Theme style -->
  <link rel="stylesheet" href="vistas/css/plugins/adminlte.min.css">
  <!-- Selec2 -->
  <link rel="stylesheet" href="vistas/css/plugins/select2.min.css">
  <!-- DataTable -->
  <link rel="stylesheet" href="vistas/css/plugins/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="vistas/css/plugins/responsive.bootstrap4.min.css">
  <!-- jQuery -->
  <script src="vistas/js/plugins/jquery.min.js"></script>
    <!-- select2 -->
  <script src="vistas/js/plugins/select2.full.min.js"></script>
</head>
<body class="layout-navbar-fixed layout-fixed sidebar-mini sidebar-collapse">
<div class="wrapper">

<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="index3.html" class="nav-link"></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="index3.html" class="nav-link"><?php echo $periodoActivo['nombrePeriodo'] ." / ".$planLectivo['nombrePlan']; ?></a>
    </li>    
    <li class="nav-item d-none d-sm-inline-block">
      <a href="index3.html" class="nav-link">INSTITUTO FIBONACCI</a>
    </li>
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown2" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Contactanos</a>
      <div class="dropdown-menu" aria-labelledby="navbarDropdown2">
        <a class="dropdown-item" href="#">christian.vilca@institutofibonacci.com</a>
      </div>
    </li>
  </ul>
  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <!-- Notifications Dropdown Menu -->
    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-bell"></i>
        <span class="badge badge-warning navbar-badge">15</span>
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <span class="dropdown-header">15 Notificaciones</span>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
          <i class="fas fa-envelope mr-2"></i> 4 new messages
          <span class="float-right text-muted text-sm">3 mins</span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
          <i class="fas fa-users mr-2"></i> 8 friend requests
          <span class="float-right text-muted text-sm">12 hours</span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
          <i class="fas fa-file mr-2"></i> 3 new reports
          <span class="float-right text-muted text-sm">2 days</span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item dropdown-footer">Ver todas los notificaciones</a>
      </div>
    </li>
    <li class="nav-item">
      <a href="salir" class="nav-link"><i class="fa-solid fa-right-from-bracket"></i></a>
    </li>
  </ul>
</nav>