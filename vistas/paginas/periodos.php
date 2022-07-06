
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6 row">
            <h1 class="m-0">Periodos</h1>
            <button class="ml-2 btn btn-primary btn-sm" id="btnAgregarPeriodo" data-toggle='modal' data-target='#modalPeriodo'><i class="fas fa-add"></i> Agregar periodo</button>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Inicio</a></li>
              <li class="breadcrumb-item active">Periodos</li>
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
          <div class="col-lg-10 col-md-12">
            <div class="card card-danger card-outline">
              <div class="card-header">
                <h3 class="card-title">Lista de periodos</h3>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th>N°</th>
                        <th>Nombre del periodo</th>
                        <th>Año - etapa</th>
                        <th>Fecha inicio</th>
                        <th>Fecha fin</th>
                        <th>estado</th>
                        <th>Acciones</th>
                      </tr>
                    </thead>
                    <tbody id="tablaPeriodos">
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          
        </div>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<div class="modal" id="modalPeriodo">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" id="formPeridoLectivo">
        <!-- Modal Header -->
        <div class="modal-header bg-light">
          <h4 class="modal-title" id="titulo-periodo"></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body -->
        <div class="modal-body">
          <div class="form-row">
            <div class="form-group col-3">
              <label>Año:</label>
              <input type="text" class="form-control form-control-sm" name="txtYear" placeholder="Año" pattern="[0-9]+" required>
            </div>
            <div class="form-group col-3">
              <label>Etapa:</label>
              <input type="number" class="form-control form-control-sm" name="txtEtapa" min="1" max="2" placeholder="Etapa" required>
            </div>
            <div class="form-group col-6">
              <label>Nombre:</label>
              <input type="text" class="form-control form-control-sm" name="txtNombrePeriodo" readonly required>
            </div>
          </div>               
          <div class="form-row">
            <div class="form-group col-6">
              <label>Fecha inicio:</label>
              <input type="date" class="form-control form-control-sm" name="txtFechaInicio" required>
            </div>
            <div class="form-group col-6">
              <label>Fecha fin:</label>
              <input type="date" class="form-control form-control-sm" name="txtFechaFin" required>
            </div>
          </div>        
        </div>
        <input type="hidden" name="funcion">
        <input type="hidden" name="idPeriodo">
        <!-- Modal footer -->
        <div class="modal-footer">
          <div>
            <button type="button" class="btn btn-dark" data-dismiss="modal"><i class="fas fa-window-close"></i> Cerrar</button>
          </div>
          <div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>