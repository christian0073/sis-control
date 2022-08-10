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
            <button class="ml-2 btn btn-primary btn-sm" id="btnRegistrarSubsanacion" data-toggle='modal' data-target='#modalRegistroSubsanacion'><i class="fas fa-add"></i> Registrar subsanación</button>
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
                        <th style="width: 80px;">Acciones</th>
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

<div class="modal" id="modalRegistroSubsanacion">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" id="formRegistrarSubsanacion">
        <!-- Modal Header -->
        <div class="modal-header bg-light">
          <h4 class="modal-title">Registrar curso</h4>
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
              <label for="cmbSedeCurso">Sede:</label>
              <select class="form-control form-control-sm" style="width: 100%;" name="cmbSedeCurso" id="cmbSedeCurso" required>
                <option value="">Selecciones una opción</option>
                <?php foreach ($sedes as $key => $value): ?>
                  <option value="<?php echo $value['idSede']; ?>"><?php echo $value['nombreSede']; ?></option>
                <?php endforeach ?>
              </select>
            </div>
            <div class="form-group col-6">
              <label for="cmbLocalCurso">Local:</label>
              <select class="form-control form-control-sm" style="width: 100%;" name="cmbLocalCurso" id="cmbLocalCurso" required>
                <option value="">Selecciones una opción</option>
              </select>
            </div>
          </div>                
          <div class="form-row">
            <div class="form-group col-6">
              <label for="cmbCarreraCurso">Carreras:</label>
              <select class="form-control form-control-sm" style="width: 100%;" name="cmbCarreraCurso" id="cmbCarreraCurso" required>
                <option value="">Selecciones una opción</option>
              </select>
            </div>            
            <div class="form-group col-6">
              <label for="cmbCicloCurso">Ciclo:</label>
              <select class="form-control form-control-sm" style="width: 100%;" name="cmbCicloCurso" id="cmbCicloCurso" required>
                <option value="">Selecciones una opción</option>
              </select>
            </div>
          </div> 
          <div class="form-row">
            <div class="form-group col-5">
              <label for="cmbSeccionCurso">Sección:</label>
              <select class="form-control form-control-sm" style="width: 100%;" name="cmbSeccionCurso" id="cmbSeccionCurso" required>
                <option value="">Selecciones una opción</option>
              </select>
            </div>
            <div class="form-group col-4">
              <label for="txtCodigoPago">Codigo:</label>
              <div class="input-group input-group-sm">
                <input type="text" class="form-control" name="txtCodigoPago" placeholder="Codigo" id="txtCodigoPago" required>
              </div>
            </div>
            <div class="form-group col-3">
              <label for="txtMontoPago">Monto:</label>
              <div class="input-group input-group-sm">
                <input type="number" class="form-control" name="txtMontoPago" placeholder="S/. 0.00" id="txtMontoPago" required>
              </div>
            </div>
          </div>     
          <ul class="list-group" id="listaCursos">
          </ul>
        </div>
        <input type="hidden" name="funcion" value="registrarSubsanacion">
        <!-- Modal footer -->
        <div class="modal-footer">
          <div>
            <button type="button" class="btn btn-dark" data-dismiss="modal"><i class="fas fa-window-close"></i> Cerrar</button>
          </div>
          <div>
            <button type="submit" id="btnGuardar" class="btn btn-primary" disabled><i class="fas fa-save"></i> Guardar</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>