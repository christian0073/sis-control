  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6 row">
            <h1 class="m-0">Examenes entregados y pendientes</h1>              
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Inicio</a></li>
              <li class="breadcrumb-item active">Registrar personal</li>
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
              <select class="form-control-sm select2" id="cmbParcial">
                <option value="">Seleccione un parcial</option>
                <option value="1">Parcial  1</option>
                <option value="2">Parcial  2</option>
                <option value="3">Parcial  3</option>
                <option value="4">Parcial  4</option>
              </select>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="col-12">
            <table class="table table-striped table-hover dt-responsive" id="tablaDoenteExamenes" style="width: 100%; font-size: 13px;">
              <thead>
                <tr>
                  <th style="width: 20px;">N°</th>
                  <th style="width:100px;">Sede</th>
                  <th>Apellidos y Nombres</th>
                  <th style="width: 100px;">DNI</th>
                  <th style="width: 100px;">Celulares</th>
                  <th>Curso</th>
                  <th style="width: 120px;">Sección</th>
                  <th style="width: 120px;">Estado</th>
                  <th style="width: 120px;">Fecha</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
        <div class="card-footer">
          <div id="btnDescarga" style="display: none;">
            <a class="btn btn-success float-right" href="#" target="_blank" id="btnGenerarExcel"><i class="fa-solid fa-file-excel"></i> Descargar Excel</a>
            <input style="width: 200px;" class="form-control float-right mr-2" type="date" name="fechaDescarga">
          </div>
        </div>
      </div>
    </div>    
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->