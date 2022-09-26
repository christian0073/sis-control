<?php 
  $sedes = ControladorSede::ctrMostrarSedes();
 ?>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6 row">
            <h1 class="m-0">Subsanaciones</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Inicio</a></li>
              <li class="breadcrumb-item active">Subsanaciones</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row justify-content-center">
          <div class="col-12 ">
            <div class="card card-danger card-outline">
              <div class="card-header">
                <select class="form-control-sm select2" id="cmbSedes">
                  <option value="">Seleccione una sede</option>
                  <?php foreach ($sedes as $key => $value): ?>
                    <option value="<?php echo $value['idSede']; ?>"><?php echo $value['nombreSede']; ?></option>
                  <?php endforeach ?>
                </select>                
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-striped table-hover dt-responsive" id="tablaSubsanacion" style="width: 100%; font-size: 13px; text-align: center;">
                    <thead>
                      <tr>
                        <th style="width: 40px;">N°</th>
                        <th style="width: 80px;">Sedes</th>
                        <th>Carrera</th>
                        <th>Curso</th>
                        <th style="width: 60px">Sección</th>
                        <th>Apellidos y Nombres</th>
                        <th style="width: 60px;">DNI</th>
                        <th style="width: 60px;">Código</th>
                        <th style="width: 60px;">Boleta</th>
                        <th style="width: 60px;">Monto</th>
                        <th style="width: 100px;">Estado</th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="card-footer">
                <div>
                  <a class="btn btn-success float-right" href="excel?idSede=" target="_blank" id="btnGenerarExcel"><i class="fa-solid fa-file-excel"></i> Descargar Excel</a>
                </div>
              </div>
            </div>
          </div>
          
        </div>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>