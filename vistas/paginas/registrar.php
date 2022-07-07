<?php 
  $cargos = ControladorCargo::ctrMostrarCargos();
 ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6 row">
            <h1 class="m-0">Registar personal</h1>
            <button class="ml-2 btn btn-primary btn-sm" id="btnAgregarPeriodo" data-toggle='modal' data-target='#modalRegistroPersonal'><i class="fas fa-add"></i> Agregar personal</button>
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
              <select class="form-control-sm select2" id="cmbCargo">
                <option value="">Seleccione una opción</option>
                <?php foreach ($cargos as $key => $value): ?>
                  <option value="<?php echo $value['idCargo']; ?>"><?php echo $value['nombreCargo']; ?></option>
                <?php endforeach ?>
              </select>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="col-12">
            <table class="table table-striped table-hover dt-responsive" id="tablaPersonal" style="width: 100%;">
              <thead>
                <tr>
                  <th style="width: 20px;">N°</th>
                  <th style="width: 80px;">Cargo</th>
                  <th style="width: 300px;">Apellidos y Nombres</th>
                  <th style="width: 80px;">DNI</th>
                  <th>Profesión</th>
                  <th>Correo</th>
                  <th style="width: 80px;">Celulares</th>
                  <th>Dirección</th>
                  <th style="width: 120px;">Fecha ingreso</th>
                  <th style="width: 100px;">Fecha de cese</th>
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

<div class="modal" id="modalRegistroPersonal">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" id="formRegistrarPersonal">
        <!-- Modal Header -->
        <div class="modal-header bg-light">
          <h4 class="modal-title">Registrar nuevo personal</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body -->
        <div class="modal-body">
          <div class="form-row">
            <div class="form-group col-6">
              <label for="txtDniUsuario">DNI:</label>
                <div class="input-group input-group-sm">
                  <input type="text" class="form-control" name="txtDniUsuario" placeholder="Ingrese DNI" pattern="[0-9]+" minlength="8" maxlength="8" onkeypress="return event.charCode>=48 && event.charCode<=57" required>
                  <span class="input-group-append">
                    <button type="button" class="btn btn-info btn-flat" id="btnBuscarDni"><i class="fa-solid fa-magnifying-glass"></i></button>
                  </span>
                </div>
            </div> 
            <div class="form-group col-6">
              <label for="txtApellidoPaterno">Apellido Paterno:</label>
              <div class="input-group input-group-sm">
                <input type="text" class="form-control" name="txtApellidoPaterno" placeholder="Apellido paterno" required readonly>
              </div>
            </div>                                  
          </div>
          <div class="form-row">
            <div class="form-group col-6">
              <label for="txtApellidoMaterno">Apellido Materno:</label>
              <div class="input-group input-group-sm">
                <input type="text" class="form-control" name="txtApellidoMaterno" placeholder="Apellido materno" required readonly>
              </div>
            </div>
            <div class="form-group col-6">
              <label for="txtNombres">Nombres:</label>
              <div class="input-group input-group-sm">
                <input type="text" class="form-control" name="txtNombres" placeholder="Nombres" required readonly>
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-6">
              <label for="cmbCargoPersonal">Cargo:</label>
              <select class="form-control form-control-sm select2" style="width: 100%;" name="cmbCargoPersonal" id="cmbCargoPersonal" required>
                <option value="">Seleccionar cargo</option>
                <?php foreach ($cargos as $key => $value): ?>
                  <option value="<?php echo $value['idCargo']; ?>"><?php echo $value['nombreCargo']; ?></option>
                  
                <?php endforeach ?>
              </select>
            </div>
            <div class="form-group col-6">
              <label for="txtFechaIngreso">Fecha ingreso:</label>
               <div class="input-group input-group-sm">
                <input type="date" class="form-control" name="txtFechaIngreso" placeholder="Ingrese correo" required>
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-12">
              <label for="txtProfesion">Profesión:</label>
              <div class="input-group input-group-sm">
                <input type="text" class="form-control" name="txtProfesion" placeholder="Ingrese Profesión">
              </div>
            </div>
          </div>           
          <div class="form-row">
            <div class="form-group col-12">
              <label for="txtCorreoPersonal">Correo:</label>
              <div class="input-group input-group-sm">
                <input type="text" class="form-control" name="txtCorreoPersonal" placeholder="Ingrese correo">
              </div>
            </div>
          </div> 
          <div class="form-row">
            <div class="form-group col-12">
              <label for="txtDireccionPersonal">Dirección:</label>
              <div class="input-group input-group-sm">
                <input type="text" class="form-control" name="txtDireccionPersonal" placeholder="Ingrese dirección">
              </div>
            </div>
          </div>
          <div class="mb-2">
            <label>Celulares:</label>
            <button class="btn btn-light btn-sm" id="btnAgregarCelulares" type="button"><i class="fas fa-add"></i> Agregar</button>
          </div>
          <div class="form-row" id="seccionCelulares">        
          </div>            
        </div>
        <input type="hidden" name="funcion" value="registrarPersonal">
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
<!-- modal para editar datos de un personañ -->
<div class="modal" id="modalEditarPersonal">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" id="formEditarPersonal">
        <!-- Modal Header -->
        <div class="modal-header bg-light">
          <h4 class="modal-title" id="tituloPersonal"></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body -->
        <div class="modal-body">
          <div class="form-row">
            <div class="form-group col-6">
              <label for="cmbCargoPersonalEditar">Cargo:</label>
              <select class="form-control form-control-sm select2" style="width: 100%;" name="cmbCargoPersonalEditar" id="cmbCargoPersonalEditar" required>
                <?php foreach ($cargos as $key => $value): ?>
                  <option value="<?php echo $value['idCargo']; ?>"><?php echo $value['nombreCargo']; ?></option>
                  
                <?php endforeach ?>
              </select>
            </div>
            <div class="form-group col-6">
              <label for="txtFechaIngresoEditar">Fecha ingreso:</label>
               <div class="input-group input-group-sm">
                <input type="date" class="form-control" name="txtFechaIngresoEditar" placeholder="Ingrese correo" required>
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-12">
              <label for="txtProfesionEditar">Profesión:</label>
              <div class="input-group input-group-sm">
                <input type="text" class="form-control" name="txtProfesionEditar" placeholder="Ingrese Profesión">
              </div>
            </div>
          </div>           
          <div class="form-row">
            <div class="form-group col-12">
              <label for="txtCorreoPersonalEditar">Correo:</label>
              <div class="input-group input-group-sm">
                <input type="text" class="form-control" name="txtCorreoPersonalEditar" placeholder="Ingrese correo">
              </div>
            </div>
          </div> 
          <div class="form-row">
            <div class="form-group col-12">
              <label for="txtDireccionPersonalEditar">Dirección:</label>
              <div class="input-group input-group-sm">
                <input type="text" class="form-control" name="txtDireccionPersonalEditar" placeholder="Ingrese dirección">
              </div>
            </div>
          </div>
          <div class="mb-2">
            <label>Celulares:</label>
            <button class="btn btn-light btn-sm" id="btnAgregarCelularesEditar" type="button"><i class="fas fa-add"></i> Agregar</button>
          </div>
          <div class="form-row" id="seccionCelularesEditar">        
          </div>            
        </div>
        <input type="hidden" name="funcion" value="editarPersonal">
        <input type="hidden" name="idPersonal">
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