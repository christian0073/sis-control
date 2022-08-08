<?php 
  $roles = ControladorUsuario::ctrMostrarRoles();
 ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6 row">
            <h1 class="m-0">Registar usuario</h1>
            <button class="ml-2 btn btn-primary btn-sm" id="btnRegistrarUsuario" data-toggle='modal' data-target='#modalRegistroUsuario'><i class="fas fa-add"></i> Agregar usuario</button>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Inicio</a></li>
              <li class="breadcrumb-item active">Registrar Usuario</li>
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
              <p>Lista Usuarios</p>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="col-12">
            <table class="table table-striped table-hover dt-responsive" id="tablaUsuarios" style="width: 100%;">
              <thead style="text-align: center;">
                <tr>
                  <th style="width: 40px;">N°</th>
                  <th>Apellidos y Nombres</th>
                  <th>Usuario</th>
                  <th>Contraseña</th>
                  <th>Rol</th>
                  <th>Acciones</th>
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

<div class="modal" id="modalRegistroUsuario">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" id="formRegistrarUsuario">
        <!-- Modal Header -->
        <div class="modal-header bg-light">
          <h4 class="modal-title">Registrar nuevo usuario</h4>
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
            <div class="form-group col-12">
              <label for="cmbRolUsuario">Rol:</label>
              <select class="form-control form-control-sm select2" style="width: 100%;" name="cmbRolUsuario" id="cmbRolUsuario" required>
                <option value="">Seleccionar rol</option>
                <?php foreach ($roles as $key => $value): ?>
                  <option value="<?php echo $value['idRol']; ?>"><?php echo $value['nombreRol']; ?></option>
                  
                <?php endforeach ?>
              </select>
            </div>
          </div>    
          <div class="form-row">
            <div class="form-group col-12">
              <label for="txtUsuarioNombre">Usuario:</label>
              <div class="input-group input-group-sm">
                <input type="text" class="form-control" name="txtUsuarioNombre" placeholder="Ingrese usuario">
              </div>
            </div>
          </div> 
          <div class="form-row">
            <div class="form-group col-12">
              <label for="txtUsuarioContra">Contraseña:</label>
              <div class="input-group input-group-sm">
                <input type="text" class="form-control" name="txtUsuarioContra" placeholder="Ingrese Contraseña">
              </div>
            </div>
          </div>               
        </div>
        <input type="hidden" name="funcion" value="registrarUsuario">
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