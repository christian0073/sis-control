<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar Sesion</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Theme style -->
    <link rel="stylesheet" href="vistas/css/plugins/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="text-center"><strong>Iniciar sesión</strong></p>
      <div class="row pb-4">
        <img style="width: 200px; margin-left: auto; margin-right: auto;" src="vistas/img/logo-fibo.png" alt="Escudo del instituto licenciado fibonacci">
      </div>
      <form id="formLogin" method="POST">
        <div class="input-group mb-3">
          <input autofocus name="txtUser" type="text" class="form-control" placeholder="Usuario">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input name="txtContra" type="password" class="form-control" placeholder="Contraseña">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <input type="hidden" name="funcion" value="inciarSesion">
        <div class="row">
          <!-- /.col -->
          <div class="w-100 d-sm-flex justify-content-center">
            <button type="submit" class="col-6 btn btn-primary">Ingresar</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="vistas/js/plugins/jquery.min.js"></script>
<!-- fontawesome -->
<script src="vistas/js/plugins/all.min.js"></script>
<!-- Sweetalert2 -->
<script src="vistas/js/plugins/sweetalert2.all.js"></script>
<!-- funciones -->
<script src="vistas/js/funciones.js"></script>
<script src="vistas/js/login.js"></script>
<!-- AdminLTE App -->
<script src="vistas/js/plugins/adminlte.min.js"></script>
</body>