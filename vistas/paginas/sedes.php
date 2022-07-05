<?php 
  $carreras = ControladorCarrera::ctrMostrarCarreras();
 ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6 row">
            <h1 class="m-0">Sedes</h1>
            <button class="ml-2 btn btn-primary btn-sm" id="btnAgregarSede" data-toggle='modal' data-target='#modalRegistrarSede'><i class="fas fa-add"></i> Agregar sede</button>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Inicio</a></li>
              <li class="breadcrumb-item active">Sedes</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content ">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-3">
            <div class="card card-danger card-outline">
              <div class="card-body">
                <table class="table table-hover table-sm">
                  <tbody id="tableSedes">
                  </tbody>
                  <tfoot>
                    <tr>
                      <td colspan="2"></td>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
            <div class="card card-danger">
              <div class="card-header">
                <h3 class="card-title">Locales <span id="titSede"></span></h3>
              </div>
              <div class="card-body" id="locales">
               
              </div>
            </div><!-- /.card -->
          </div>
          <!-- /.col-md-6 -->
          <div class="col-lg-9">
            <div class="card">
              <div class="card-header">
                <h5 class="m-0">Lista de especialidades</h5>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th>N°</th>
                        <th>Nombre de la especialidad</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                      </tr>
                    </thead>
                    <tbody id="tablaCarreras">
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<div class="modal" id="modalRegistrarSede">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <form method="POST" id="formRegistrarSede">
        <!-- Modal Header -->
        <div class="modal-header bg-light">
          <h4 class="modal-title">Agregar sede</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body -->
        <div class="modal-body">
          <div class="form-row">
            <div class="form-group col-12">
              <label for="txtNombreSede">Nombre de la sede:</label>
              <div class="input-group input-group-sm">
                <input type="text" class="form-control" name="txtNombreSede" placeholder="Nombre de la sede" required>
              </div>
            </div>            
          </div>                
        </div>
        <input type="hidden" name="funcion" value="registrarSede">
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

<div class="modal" id="modalLocal">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" id="fomLocal">
        <!-- Modal Header -->
        <div class="modal-header bg-light">
          <h4 class="modal-title">Registrar nuevo local en <span id="titulo-sede"></span></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body -->
        <div class="modal-body">
          <div class="form-row">
            <div class="form-group col-6">
              <label for="cmbDepartamento">Departamentos:</label>
              <select class="form-control form-control-sm select2" style="width: 100%;" name="cmbDepartamento" id="cmbDepartamento" required>
              </select>
            </div>
            <div class="form-group col-6">
              <label for="cmbProvincia">Provincias:</label>
              <select class="form-control form-control-sm select2" style="width: 100%;" name="cmbProvincia" id="cmbProvincia" required></select>
            </div>           
          </div>
          <div class="form-row">
            <div class="form-group col-6">
              <label for="cmbDistrito">Distritos:</label>
              <select class="form-control form-control-sm select2" style="width: 100%;" name="cmbDistrito" id="cmbDistrito" required></select>
            </div>
            <div class="form-group col-6">
              <label for="txtCodigo">Código modular:</label>
              <input type="text" class="form-control form-control-sm" name="txtCodigo" placeholder="Ingrese el código modular" required>
            </div>            
          </div>
          <div class="form-row">
            <div class="form-group col-6">
              <label for="txtCodigoLocal">Código de local:</label>
              <input type="text" class="form-control form-control-sm" name="txtCodigoLocal" placeholder="Ingrese el código del local" required>
            </div> 
            <div class="form-group col-6">
              <label>Sede:</label>
              <input type="text" class="form-control form-control-sm" name="txtSede" readonly>
            </div>            
          </div>
          <div class="form-row">
            <label>Direción:</label>
            <textarea class="form-control form-control-sm" name="txtDireccion" rows="3" placeholder="Escriba la direción" required></textarea>
          </div>                  
        </div>
        <input type="hidden" name="funcion">
        <input type="hidden" name="txtDepartamento">
        <input type="hidden" name="txtProvincia">
        <input type="hidden" name="txtDistrito">
        <input type="hidden" name="idSede">
        <input type="hidden" name="idLocal">
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

<div class="modal" id="modalCarrera">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" id="formCarrera">
        <!-- Modal Header -->
        <div class="modal-header bg-light">
          <h4 class="modal-title" id="titulo-carrera"></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body -->
        <div class="modal-body">
          <div class="form-row">
            <div class="form-group col-6">
              <label for="cmbCarreras">Especialidades:</label>
              <select class="form-control form-control-sm select2" style="width: 100%;" name="cmbCarreras" id="cmbCarreras" required>
                <option value="">Seleccione una especialidad</option>
                <?php foreach ($carreras as $key => $value): ?>
                  <option value="<?php echo $value['idCarrera']; ?>"><?php echo $value['nombreCarrera']; ?></option>
                <?php endforeach ?>
              </select>
            </div>
            <div class="form-group col-6">
              <label>Nombre:</label>
              <input type="text" class="form-control form-control-sm" name="txtNombreCarrera" readonly>
            </div>
          </div>               
        </div>
        <input type="hidden" name="funcion">
        <input type="hidden" name="idLocalCarrera">
        <input type="hidden" name="idCarrera">
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