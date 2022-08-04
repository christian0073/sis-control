<?php 
  $sedes = ControladorSede::ctrMostrarSedes();
  $periodos = ControladorPeriodo::ctrMostrarPeriodos();
 ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6 row">
            <h1 class="m-0">Aulas</h1>
            <?php if (!empty($periodoActivo) && $idUsuarioRol != 4): ?>
              <button class="ml-2 btn btn-primary btn-sm" id="btnAgregarAula" data-toggle='modal' data-target='#modalRegistrarAula'><i class="fas fa-add"></i> Agregar Aula</button>
            <?php endif ?>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Inicio</a></li>
              <li class="breadcrumb-item active">Aulas</li>
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
            <div class="form-group">
              <select class="form-control-sm select2" id="cmbPeriodoAula">
                <option value="">Seleccionar periodo</option>
                <?php foreach ($periodos as $key => $value): ?>
                  <option value="<?php echo $value['idPeriodo']; ?>"><?php echo $value['nombrePeriodo']; ?></option>
                <?php endforeach ?>
              </select>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="form-group mr-1">
              <select class="form-control-sm select2" id="cmbSedeAulas">
                <option value="">Seleccione una sede</option>
                <?php foreach ($sedes as $key => $value): ?>
                  <option value="<?php echo $value['idSede']; ?>"><?php echo $value['nombreSede']; ?></option>
                <?php endforeach ?>
              </select>
            </div>
            <div class="form-group mr-1">
              <select class="form-control-sm select2" disabled id="cmbLocalesAulas">
                <option value="">Seleccione una filial</option>
              </select>
            </div>
            <div class="form-group mr-1">
              <select class="form-control-sm select2" disabled id="cmbCarrerasAulas">
                <option value="">Seleccionar especialidad</option>
              </select>
            </div>
            <div>
              <button class="btn btn-info btn-sm" id="btnBuscarAula"><i class="fa-solid fa-magnifying-glass"></i> Buscar</button>
            </div>
          </div>
          <div class="col-12">
            <table class="table table-striped table-hover dt-responsive" id="tablaAula" style="width: 100%;">
              <thead>
                <tr>
                  <th style="width: 30px;">N°</th>
                  <th>Periodo</th>
                  <th>Filial</th>
                  <th>Especialidad</th>
                  <th>Ciclo</th>
                  <th>Sección</th>
                  <th>Turno</th>
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


<div class="modal" id="modalRegistrarAula">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" id="formRegistrarAula">
        <!-- Modal Header -->
        <div class="modal-header bg-light">
          <h4 class="modal-title">Registrar nueva aula en el <?php echo $periodoActivo['nombrePeriodo']; ?></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body -->
        <div class="modal-body">
          <div class="form-row">
            <div class="form-group col-6">
              <label for="cmbSedeAula">Sedes:</label>
              <select class="form-control form-control-sm" style="width: 100%;" name="cmbSedeAula" id="cmbSedeAula" required>
                <option value="">Seleccionar una sede</option>
                <?php foreach ($sedes as $key => $value): ?>
                  <option value="<?php echo $value['idSede']; ?>"><?php echo $value['nombreSede']; ?></option>
                <?php endforeach ?>
              </select>
            </div>  
            <div class="form-group col-6">
              <label for="cmbLocalesAula">Locales:</label>
              <select class="form-control form-control-sm" style="width: 100%;" name="cmbLocalesAula" id="cmbLocalesAula" required>
                <option value="">Seleccione una opción</option>
              </select>
            </div>                        
          </div>
          <div class="form-row">
            <div class="form-group col-6">
              <label for="cmbEspecialidadAula">Especilaidad:</label>
              <select class="form-control form-control-sm" style="width: 100%;" name="cmbEspecialidadAula" id="cmbEspecialidadAula" required>
                <option value="">Seleccione una opción</option>
              </select>
            </div>
            <div class="form-group col-6">
              <label for="txtNombreAula">Nombre:</label>
              <div class="input-group input-group-sm">
                <input type="text" class="form-control" name="txtNombreAula" placeholder="Aula" required>
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-6">
              <label for="cmbTurnoAula">Turno:</label>
              <select class="form-control form-control-sm" style="width: 100%;" name="cmbTurnoAula" id="cmbTurnoAula" required>
                <option value="">Elejir</option>
                <option value="M">Mañana</option>
                <option value="T">Tarde</option>
                <option value="N">Noche</option>
              </select>
            </div>
            <div class="form-group col-6">
              <label for="cmbCicloAula">Ciclo:</label>
              <select class="form-control form-control-sm" style="width: 100%;" name="cmbCicloAula" id="cmbCicloAula" required>
                <option value="">Elejir</option>
                <option value="1">I</option>
                <option value="2">II</option>
                <option value="3">III</option>
                <option value="4">IV</option>
                <option value="5">V</option>
                <option value="6">VI</option>
              </select>
            </div>
          </div>              
        </div>
        <input type="hidden" name="funcion" value="registrarAula">
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

<div class="modal" id="modalEditarAula">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" id="formEditarAula">
        <!-- Modal Header -->
        <div class="modal-header bg-light">
          <h4 class="modal-title">Editar Aula</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body -->
        <div class="modal-body">
          <div class="form-row">
            <div class="form-group col-6">
              <label for="txtPeriodoAula">Periodo:</label>
              <div class="input-group input-group-sm">
                <input type="text" class="form-control" name="txtPeriodoAula" required disabled>
              </div>
            </div>
            <div class="form-group col-6">
              <label for="txtLocalAula">Filial:</label>
              <div class="input-group input-group-sm">
                <input type="text" class="form-control" name="txtLocalAula" required disabled>
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-6">
              <label for="txtCarreraAula">Especialidad:</label>
              <div class="input-group input-group-sm">
                <input type="text" class="form-control" name="txtCarreraAula" required disabled>
              </div>
            </div>            
            <div class="form-group col-6">
              <label for="txtAula">Nombre:</label>
              <div class="input-group input-group-sm">
                <input type="text" class="form-control" name="txtAula" required>
              </div>
            </div>           
          </div>
          <div class="form-row">          
            <div class="form-group col-6">
              <label for="cmbTurno">Turno:</label>
              <select class="form-control form-control-sm" style="width: 100%;" name="cmbTurno" id="cmbTurno" required>
                <option value="M">Mañana</option>
                <option value="T">Tarde</option>
                <option value="N">Noche</option>
              </select>
            </div>
            <div class="form-group col-6">
              <label for="cmbCiclo">Ciclo:</label>
              <select class="form-control form-control-sm" style="width: 100%;" name="cmbCiclo" id="cmbCiclo" required>
                <option value="1">I</option>
                <option value="2">II</option>
                <option value="3">III</option>
                <option value="4">IV</option>
                <option value="5">V</option>
                <option value="6">VI</option>
              </select>
            </div>             
          </div>              
        </div>
        <input type="hidden" name="funcion" value="editarAula">
        <input type="hidden" name="idAula">
        <input type="hidden" name="idPeriodoAula">
        <input type="hidden" name="idLocalidadAula">
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

<div class="modal" id="modalVerCursos">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
          <h4 class="modal-title">Cursos habilitados</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>        
      </div>
      <div class="modal-body">
        <ul class="list-group" id="listaCursos">
        </ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-dark" data-dismiss="modal"><i class="fas fa-window-close"></i> Cerrar</button>
      </div>
    </div>
  </div>
</div>