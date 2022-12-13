  <?php 
  $url= $_SERVER["REQUEST_URI"];
  $components = parse_url($url);
  parse_str($components['query'], $archivo);  
  if (isset($archivo['idSeccion']) && !empty($archivo['idSeccion'])) {
    $seccion = ControladorAula::ctrMostrarAulaId(intval($archivo['idSeccion']));
    if (!empty($seccion)) {
      $local = ControladorLocal::ctrMostrarLocalSede($seccion['idSeccionLocal']);
      $turno = '';
      if ($seccion['turno'] == 'M') {
        $turno = 'MAÑANA';
      }else if ($seccion['turno'] == 'T') {
        $turno = 'TARDE';
      }else if($seccion['turno'] == 'N'){
        $turno = 'NOCHE';
      }
      $seccionNombre = $seccion['nombreSeccion'].' ('.$turno.') - '.$local['nombreSede']; 
    }else{
      echo '<script>
        mensaje("¡ERROR!", "¡Ah ocurrido un  error al ingresar a la pagina! Comuniquese con el administrador de inmediato." , "error");
        window.location = "'.$rutaSistema.'secciones";
      </script>';
      exit;   
    }
  }else{
      echo '<script>
        window.location = "'.$rutaSistema.'error";
      </script>';
      exit;
  }
 ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"><?php echo $seccionNombre; ?></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Inicio</a></li>
              <li class="breadcrumb-item active">Reprogramación</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="card">
        <div class="card-header p-2">
          <ul class="nav nav-pills">
              <li class="nav-item"><a class="nav-link active" href="#cursos" data-toggle="tab">Cursos</a></li>
            <li class="nav-item"><a class="nav-link" href="#horario" id="verHorario" data-toggle="tab">Horario</a></li>
            <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Settings</a></li>
          </ul>
        </div><!-- /.card-header -->
        <div class="card-body">
          <div class="tab-content">
            <div class="active tab-pane" id="cursos">
              <div class="row">
                <div>
                  <h3>Cursos</h3>
                </div>
              </div>
              <div class="mt-2 col-12">
                <table class="table table-striped table-hover dt-responsive" id="tablaCursos" style="width: 100%;">
                  <thead>
                    <tr>
                      <th style="width: 20px;">N°</th>
                      <th>Especialidad</th>
                      <th>Nombre del curso</th>
                      <th style="width: 30px;">Codigo</th>
                      <th style="width: 30px;">Ciclo</th>
                      <th>Docente</th>
                      <th style="width: 40px;">Acciones</th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>
            <!-- /.tab-pane -->
            <div class="tab-pane" id="horario">
              <div class="mb-2">
                <a href="reporte-pdf?idSeccion=<?php echo $seccion['idSeccion']; ?>" class="btn btn-danger" target="_blank"><i class="fas fa-file-pdf"></i> Horario</a>
              </div>
              <div class="table-responsive">
                <table class="table text-center table-bordered" style="height:300px; min-width: 900px;">
                  <thead>
                    <tr>
                      <th colspan="2" style="width: 40px;">Hora</th>
                      <th>Lunes</th>
                      <th>Martes</th>
                      <th>Miercoles</th>
                      <th>Jueves</th>
                      <th>Viernes</th>
                      <th>Sábado</th>
                    </tr>
                  </thead>
                  <tbody id="tableHorario" style="font-size: 12px;">
                  </tbody>
                </table>
              </div>
            </div>
            <!-- /.tab-pane -->

            <div class="tab-pane" id="settings">
            </div>
            <!-- /.tab-pane -->
          </div>
          <!-- /.tab-content -->
        </div><!-- /.card-body -->
      </div>      
    </div> 
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <div class="modal" id="modalAgregarDocente">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" id="formRegistrarDocente">
        <!-- Modal Header -->
        <div class="modal-header bg-light">
          <h4 class="modal-title">Registrar docente</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body -->
        <div class="modal-body">  
          <div class="form-row">
            <div class="form-group col-12">
              <label for="txtDniPersonal">DNI:</label>
                <div class="input-group">
                  <input type="text" class="form-control" name="txtDniPersonal" placeholder="Ingrese DNI" pattern="[0-9]+" minlength="8" maxlength="8" onkeypress="return event.charCode>=48 && event.charCode<=57" required>
                  <span class="input-group-append">
                    <button type="button" class="btn btn-info btn-flat" id="btnBuscarDni"><i class="fa-solid fa-magnifying-glass"></i> Buscar</button>
                  </span>
                </div>
            </div> 
          </div>                 
          <div class="form-row">
            <div class="form-group col-12">
              <label for="txtDatos">Apellidos y Nombres:</label>
              <div class="input-group">
                <input type="text" class="form-control" name="txtDatos" placeholder="Apellidos y nombres" required readonly>
              </div>
            </div>
          </div>   
          <div class="form-row">
            <div class="form-group col-12">
              <label for="txtProfesion">Profesión:</label>
              <div class="input-group">
                <input type="text" class="form-control" name="txtProfesion" placeholder="Profesión" required readonly>
              </div>
            </div>
          </div>   
        </div>
        <input type="hidden" name="funcion" value="registrarDocenteCurso">
        <input type="hidden" name="idPersonalDocente">
        <input type="hidden" name="idCursoHorario">
        <!-- Modal footer -->
        <div class="modal-footer">
          <div>
            <button type="button" class="btn btn-dark" data-dismiss="modal"><i class="fas fa-window-close"></i> Cerrar</button>
          </div>
          <div>
            <button type="submit" id="btnGuardar" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal" id="agregarHorario">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
          <h4 class="modal-title" id="tituloCurso"></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>        
      </div>
      <input type="hidden" name="turno">
      <div class="modal-body">
        <div class="text-center">
          <h5 id="nombreCurso"></h5>
        </div>
        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th style="width: 80px;">Día</th>
                <th class="text-left">Periodo</th>
                <th class="text-right" style="width: 35px;">Horas</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Lunes</td>
                <td>
                  <form id="form1" method="POST">
                    <div class="d-flex" id="dia1">  
                      <div class="btn-group">
                        <button type="button" class="btn btn-info btn-sm btnNuevoInput" data-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-plus"></i>
                        </button>
                        <ul class="dropdown-menu" style="">
                          <li><button type="button" class="dropdown-item btnTeoria">Teoría</button></li>
                          <li><button type="button" class="dropdown-item btnPractica">Práctica</button></li>
                        </ul>
                        <button type="submit" class="btn btn-primary btn-sm btnRegistrarHora"><i class="fa-solid fa-floppy-disk"></i></button>
                      </div>                               
                    </div> 
                    <input type="hidden" name="diaId" value="1">
                    <input type="hidden" name="cargo" value="<?php echo $personal['nombreCargo']; ?>">
                    <input type="hidden" name="idPersonal" value="<?php echo $personal['idPersonal']; ?>">
                    <input type="hidden" name="idCursoHorario" value="">
                    <input type="hidden" name="minutos" value="">
                    <input type="hidden" name="funcion" value="registrarHorario">
                  </form>
                </td>
                <td class="text-center horasCurso1" id="horasCurso1">-</td>
              </tr>
              <tr>
                <td>Martes</td>
                <td>
                  <form id="form2" method="POST">
                    <div class="d-flex" id="dia2">  
                      <div class="btn-group">
                        <button type="button" class="btn btn-info btn-sm btnNuevoInput" data-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-plus"></i>
                        </button>
                        <ul class="dropdown-menu" style="">
                          <li><button type="button" class="dropdown-item btnTeoria">Teoría</button></li>
                          <li><button type="button" class="dropdown-item btnPractica">Práctica</button></li>
                        </ul>
                        <button type="submit" class="btn btn-primary btn-sm btnRegistrarHora"><i class="fa-solid fa-floppy-disk"></i></button>
                      </div>                               
                    </div>  
                    <input type="hidden" name="diaId" value="2">
                    <input type="hidden" name="cargo" value="<?php echo $personal['nombreCargo']; ?>">
                    <input type="hidden" name="idPersonal" value="<?php echo $personal['idPersonal']; ?>">
                    <input type="hidden" name="idCursoHorario" value="">
                    <input type="hidden" name="minutos" value="">
                    <input type="hidden" name="funcion" value="registrarHorario">
                  </form>
                </td>
                <td class="text-center horasCurso1" id="horasCurso2">-</td>
              </tr>
              <tr>
                <td>Miercoles</td>
                <td>
                  <form id="form3" method="POST">
                    <div class="d-flex" id="dia3">  
                      <div class="btn-group">
                        <button type="button" class="btn btn-info btn-sm btnNuevoInput" data-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-plus"></i>
                        </button>
                        <ul class="dropdown-menu" style="">
                          <li><button type="button" class="dropdown-item btnTeoria">Teoría</button></li>
                          <li><button type="button" class="dropdown-item btnPractica">Práctica</button></li>
                        </ul>
                        <button type="submit" class="btn btn-primary btn-sm btnRegistrarHora"><i class="fa-solid fa-floppy-disk"></i></button>
                      </div>                               
                    </div>  
                    <input type="hidden" name="diaId" value="3">
                    <input type="hidden" name="cargo" value="<?php echo $personal['nombreCargo']; ?>">
                    <input type="hidden" name="idPersonal" value="<?php echo $personal['idPersonal']; ?>">
                    <input type="hidden" name="idCursoHorario" value="">
                    <input type="hidden" name="funcion" value="registrarHorario">
                    <input type="hidden" name="minutos" value="">
                  </form>
                </td>
                <td class="text-center horasCurso1" id="horasCurso3">-</td>
              </tr>
              <tr>
                <td>Jueves</td>
                <td>
                  <form id="form4" method="POST">
                    <div class="d-flex" id="dia4">  
                      <div class="btn-group">
                        <button type="button" class="btn btn-info btn-sm btnNuevoInput" data-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-plus"></i>
                        </button>
                        <ul class="dropdown-menu" style="">
                          <li><button type="button" class="dropdown-item btnTeoria">Teoría</button></li>
                          <li><button type="button" class="dropdown-item btnPractica">Práctica</button></li>
                        </ul>
                        <button type="submit" class="btn btn-primary btn-sm btnRegistrarHora"><i class="fa-solid fa-floppy-disk"></i></button>
                      </div>                               
                    </div>
                    <input type="hidden" name="diaId" value="4">
                    <input type="hidden" name="cargo" value="<?php echo $personal['nombreCargo']; ?>">
                    <input type="hidden" name="idPersonal" value="<?php echo $personal['idPersonal']; ?>">
                    <input type="hidden" name="idCursoHorario" value="">
                    <input type="hidden" name="minutos" value="">
                    <input type="hidden" name="funcion" value="registrarHorario">
                  </form>
                </td>
                <td class="text-center horasCurso1" id="horasCurso4">-</td>
              </tr>
              <tr>
                <td>Viernes</td>
                <td>
                  <form id="form5" method="POST">
                    <div class="d-flex" id="dia5">  
                      <div class="btn-group">
                        <button type="button" class="btn btn-info btn-sm btnNuevoInput" data-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-plus"></i>
                        </button>
                        <ul class="dropdown-menu" style="">
                          <li><button type="button" class="dropdown-item btnTeoria">Teoría</button></li>
                          <li><button type="button" class="dropdown-item btnPractica">Práctica</button></li>
                        </ul>
                        <button type="submit" class="btn btn-primary btn-sm btnRegistrarHora"><i class="fa-solid fa-floppy-disk"></i></button>
                      </div>                               
                    </div>
                    <input type="hidden" name="diaId" value="5">
                    <input type="hidden" name="cargo" value="<?php echo $personal['nombreCargo']; ?>">
                    <input type="hidden" name="idPersonal" value="<?php echo $personal['idPersonal']; ?>">
                    <input type="hidden" name="idCursoHorario" value="">
                    <input type="hidden" name="minutos" value="">
                    <input type="hidden" name="funcion" value="registrarHorario">
                  </form>                
                </td>
                <td class="text-center horasCurso1" id="horasCurso5">-</td>
              </tr> 
              <tr>
                <td>Sábado</td>
                <td>
                  <form id="form6" method="POST">
                    <div class="d-flex" id="dia6">  
                      <div class="btn-group">
                        <button type="button" class="btn btn-info btn-sm btnNuevoInput" data-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-plus"></i>
                        </button>
                        <ul class="dropdown-menu" style="">
                          <li><button type="button" class="dropdown-item btnTeoria">Teoría</button></li>
                          <li><button type="button" class="dropdown-item btnPractica">Práctica</button></li>
                        </ul>
                        <button type="submit" class="btn btn-primary btn-sm btnRegistrarHora"><i class="fa-solid fa-floppy-disk"></i></button>
                      </div>                               
                    </div>
                    <input type="hidden" name="diaId" value="6">
                    <input type="hidden" name="cargo" value="<?php echo $personal['nombreCargo']; ?>">
                    <input type="hidden" name="idPersonal" value="<?php echo $personal['idPersonal']; ?>">
                    <input type="hidden" name="idCursoHorario" value="">
                    <input type="hidden" name="minutos" value="">
                    <input type="hidden" name="funcion" value="registrarHorario">
                  </form>                
                </td>
                <td class="text-center horasCurso1" id="horasCurso6">-</td>
              </tr>                
            </tbody>
            <tfoot class="border-bottom">
              <tr>
                <td colspan="2" class="text-center"><strong>Total</strong></td>
                <td style="width: 35px;" class="text-center"><strong id="totalHoras">0</strong></td>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-dark" data-dismiss="modal"><i class="fas fa-window-close"></i> Cerrar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal" id="modalDetalleCurso">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
          <h4 class="modal-title">Detalles</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>        
      </div>
      <div class="modal-body">
        <ul class="list-group" id="detalleCurso">
        </ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-dark" data-dismiss="modal"><i class="fas fa-window-close"></i> Cerrar</button>
      </div>
    </div>
  </div>
</div>