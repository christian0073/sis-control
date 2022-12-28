  <?php 
    $sedes = ControladorSede::ctrMostrarSedes();
    $docentes = ControladorPersonal::ctrMostrarDocentes();
    $carreras = ControladorCarrera::ctrMostrarCarreras();
    $usuarios = ControladorUsuario::ctrMostrarUsariosRol(4);
   ?>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6 row">
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Inicio</a></li>
              <li class="breadcrumb-item active">Corregir notas</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content row justify-content-center">
      <div class="card card-info col-md-12 col-lg-10" style="margin: 0; padding: 0;">
        <div class="card-header pb-0">
          <div class="text-center">
            <h4>Registrar asistencias excepcionales</h4>
          </div>
        </div>
        <form action="POST" id="formRegistrarAsistencia">
          <div class="card-body">
            <div class="row">
              <div class="form-group col-md-12 col-lg-6">
                <label for="cmbDocentes">Selecione una docente</label>
                <select class="form-control form-control-sm select2" style="width: 100%;" name="cmbDocentes" id="cmbDocentes" required>
                  <option value="">Selecione una opción</option>
                  <?php foreach ($docentes as $key => $value): ?>
                    <option value="<?php echo $value['idPersonal']; ?>"><?php echo $value['datos']; ?></option>
                  <?php endforeach ?>
                </select>
              </div>
              <div class="form-group col-md-12 col-lg-6">
                <label for="cmbSedes">Selecione un sede</label>
                <select class="form-control form-control-sm select2" style="width: 100%;" name="cmbSedes" id="cmbSedes" required>
                  <option value="">Selecione una opción</option>
                  <?php foreach ($sedes as $key => $value): ?>
                    <option value="<?php echo $value['idSede']; ?>"><?php echo $value['nombreSede']; ?></option>
                  <?php endforeach ?>
                </select>
              </div> 
              <div class="form-group col-md-12 col-lg-6">
                <label for="cmbCarreras">Selecione una carrera</label>
                <select class="form-control form-control-sm select2" style="width: 100%;" name="cmbCarreras" id="cmbCarreras" required>
                  <option value="">Selecione una opción</option>
                  <?php foreach ($carreras as $key => $value): ?>
                    <option value="<?php echo $value['idCarrera']; ?>"><?php echo $value['nombreCarrera']; ?></option>
                  <?php endforeach ?>
                </select>
              </div>
              <div class="form-group col-md-12 col-lg-6">
                <label for="cmbCursoHorario">Selecione una sección</label>
                <select class="form-control form-control-sm select2" style="width: 100%;" name="cmbCursoHorario" id="cmbCursoHorario" disabled required>
                  <option value="">Selecione una opción</option>
                </select>
              </div>
              <div class="form-group col-md-12 col-lg-6">
                <label for="cmbSupervisar">Selecione una supervisora</label>
                <select class="form-control form-control-sm select2" style="width: 100%;" name="cmbSupervisar" id="cmbSupervisar" required>
                  <option value="">Selecione una opción</option>
                  <?php foreach ($usuarios as $key => $value): ?>
                    <option value="<?php echo $value['idUsuario']; ?>"><?php echo $value['datos']; ?></option>
                  <?php endforeach ?>
                </select>
              </div>
              <div class="form-group col-md-6 col-sm-6 col-lg-3">
                <label for="txtFechaRegistro">Fecha</label>
                <input type="date" class="form-control form-control-sm" name="txtFechaRegistro" id="txtFechaRegistro" required>
              </div>
              <div class="form-group col-md-6 col-sm-6 col-lg-3">
                <label for="cmbTipoClase">Selecione tipo</label>
                <select class="form-control form-control-sm" style="width: 100%;" name="cmbTipoClase" id="cmbTipoClase" required>
                  <option value="">Selecione una opción</option>
                  <option value="1">Virtual</option>
                  <option value="2">Presecial</option>
                </select>
              </div>
              <div class="form-group col-md-6 col-sm-6 col-lg-3">
                <label for="txtHoraEntrada">Hora de entrada</label>
                <input type="time" class="form-control form-control-sm" name="txtHoraEntrada" id="txtHoraEntrada" required>
              </div>
              <div class="form-group col-md-6 col-sm-6 col-lg-3">
                <label for="txtHoraSalida">Hora de salida</label>
                <input type="time" class="form-control form-control-sm" name="txtHoraSalida" id="txtHoraSalida" required>
              </div>
              <div class="form-group col-md-12 col-lg-6">
                <label for="txtHoraSalida">Descripción</label>
                <textarea class="form-control"></textarea>
              </div>              
            </div>
            <input type="hidden" name="funcion" value="registrarAsistenciaExep">
          </div>
          <div class="card-footer">
            <div class="row justify-content-end">
              <button type="submit" class="btn btn-primary mr-2"><i class="fa-solid fa-floppy-disk"></i> registrar</button>
              <button class="btn btn-secondary" id="btnCancelar"><i class="fa-solid fa-xmark"></i> Cancelar</button>
            </div>
          </div>          
        </form>
      </div>
    </div>
    <!-- /.content -->
  </div>