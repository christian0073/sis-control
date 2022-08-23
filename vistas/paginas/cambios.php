<?php 
  $sedes = ControladorSede::ctrMostrarSedes();
 ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">lista supervisión</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Inicio</a></li>
              <li class="breadcrumb-item active">Avance</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="card card-danger card-outline">
        <div class="card-header pb-0">
          <div class="row">
            <div class="form-group mr-1">
              <input type="date" class="form-control form-control-sm" name="txtFechaSupervision">
            </div>
            <div>
              <button class="btn btn-info btn-sm" id="btnBuscarAvance">Buscar <i class="fas fa-search"></i></button>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="col-12">
            <table class="table table-striped table-hover dt-responsive" id="tablaSupervisar" style="width: 100%; font-size: 13px;">
              <thead>
                <tr>
                  <th style="width: 20px;">N°</th>
                  <th>Docente</th>
                  <th>Especialidad</th>
                  <th>Curso</th>
                  <th style="width: 40px;">Ciclo</th>
                  <th style="width: 100px;">Sección - turno</th>
                  <th style="width: 100px;">Horario</th>
                  <th style="width: 100px;">Estado</th>
                  <th style="width: 30px;">Horas</th>
                  <th style="width: 40px;">Acciones</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div> 
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->