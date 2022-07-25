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
              <select class="form-control-sm select2" id="cmbSedes">
                <option value="">Seleccione una sede</option>
                <?php foreach ($sedes as $key => $value): ?>
                  <option value="<?php echo $value['idSede']; ?>"><?php echo $value['nombreSede']; ?></option>
                <?php endforeach ?>
              </select>
            </div>
            <div class="form-group mr-1">
              <input type="date" class="form-control form-control-sm" name="txtFechaSupervision" readonly>
            </div>
            <div>
              <button class="btn btn-info btn-sm" id="btnBuscarSupervision">Buscar <i class="fas fa-search"></i></button>
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


<div class="modal" id="modalAsistencia">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" id="formRegistrarAsistencia">
        <div class="modal-header">
            <h4 class="modal-title" id="personafecha"></h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>        
        </div>
        <div class="modal-body">
          <ul class="list-group mb-2" id="listaAsistencia">
          </ul>
          <hr>
            <div class="form-row">
              <div class="form-group col-6">
                <label for="cmbTipoClase">Clase:</label>
                <div class="input-group input-group-sm">
                    <select class="form-control" name="cmbTipoClase" id="cmbTipoClase" required>
                      <option value="">Seleccione una opción</option>
                      <option value="1">Virtual</option>
                      <option value="2">Presencial</option>
                      <option value="3">Reprogramar</option>
                      <option value="4">No se realizó</option>
                    </select>
                </div>
              </div>
              <div class="form-group col-6">
                <label for="txtFechaRep">Fecha reprogramación:</label>
                <div class="input-group input-group-sm">
                  <input type="date" class="form-control" name="txtFechaRep" disabled>
                </div>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-6">
                <label for="txtHoraEntrada">Hora de entrada:</label>
                <div class="input-group input-group-sm">
                  <input type="time" class="form-control" name="txtHoraEntrada">
                </div>
              </div>
              <div class="form-group col-6">
                <label for="txtHoraSalida">Hora de salida:</label>
                <div class="input-group input-group-sm">
                  <input type="time" class="form-control" name="txtHoraSalida">
                </div>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-12">
                <label for="txtObservacion">Observación:</label>
                <div class="input-group input-group-sm">
                  <textarea class="form-control" style="font-size: 14px;" name="txtObservacion" rows="5"></textarea>
                </div>
              </div>
            </div>
            <input type="hidden" name="funcion" value="registrarAsistencia">
            <input type="hidden" name="idPersonalDocente">
            <input type="hidden" name="idCursoHorario">
            <input type="hidden" name="fechaAsistencia">
            <input type="hidden" name="editar">
        </div>
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