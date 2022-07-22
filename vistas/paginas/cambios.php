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
            <h1 class="m-0">Supervisar</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Inicio</a></li>
              <li class="breadcrumb-item active">Supervisar</li>
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
              <select class="form-control-sm select2" id="cmbCargo">
                <option value="">Seleccione una sede</option>
                <?php foreach ($sedes as $key => $value): ?>
                  <option value="<?php echo $value['idSede']; ?>"><?php echo $value['nombreSede']; ?></option>
                <?php endforeach ?>
              </select>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="col-12">
            <table class="table table-striped table-hover dt-responsive" id="tablaSupervisar" style="width: 100%;">
              <thead>
                <tr>
                  <th style="width: 20px;">N°</th>
                  <th>Docente</th>
                  <th>Especialidad</th>
                  <th>Curso</th>
                  <th>Ciclo</th>
                  <th>Sección - turno</th>
                  <th>Estado</th>
                  <th>Horas</th>
                  <th style="width: 100px;">Acciones</th>
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