<?php 
	$url= $_SERVER["REQUEST_URI"];
	$components = parse_url($url);
	parse_str($components['query'], $archivo);	
  if (isset($archivo['idPersonal']) && !empty($archivo['idPersonal'])) {
    $personal = ControladorPersonal::ctrMostrarPersonalId(intval($archivo['idPersonal']));
    $sedes = ControladorSede::ctrMostrarSedes();
    if (!empty($personal)) {
      $contCel = count($personal['celularPersonal']);
      $celulares = '';
      for ($i=0; $i < $contCel; $i++) { 
        $celulares .= $personal['celularPersonal'][$i].', ';
      }
      $celulares = substr($celulares, 0, -2); 
      $tipoPago = '';
      if ($personal['tipoPago'] == 1) {
        $tipoPago = 'MENSUAL';
      }else if($personal['tipoPago'] == 2){
        $tipoPago = 'HORAS';
      }
      echo '<script>
        var nombreCargo = "'.$personal['nombreCargo'].'"
      </script>';
    }else{
      echo '<script>
        mensaje("¡ERROR!", "¡Ah ocurrido un  error al ingresar a la pagina! Comuniquese con el administrador de inmediato." , "error");
        window.location = "http://localhost/sis-control/registrar";
      </script>';
      exit;    }
  }else{
      echo '<script>
        window.location = "http://localhost/sis-control/error";
      </script>';
      exit;
  }
 ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Fixed Layout</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Layout</a></li>
              <li class="breadcrumb-item active">Fixed Layout</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <!-- Default box -->
            <div class="card">
              <div class="card-body p-0">
                <div class="row">
                  <div class="col-md-3 p-0">
                    <div class="card-body box-profile">
                      <div class="text-center">
                        <img class="img-circle" style="width: 150px;" src="vistas/img/empleado.png" alt="User profile picture">
                      </div>

                      <h3 class="profile-username text-center" id="nombrePersona"><?php echo $personal['apellidoPaternoPersona'].' '.$personal['apellidoMaternoPersona'].', '.$personal['nombresPersona']; ?></h3>

                      <p class="text-muted text-center" id="profesioPersona"><?php echo $personal['profesionPersonal']; ?></p>

                      <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                          <b>DNI</b> <a class="float-right" id="dniPersona"><?php echo $personal['dniPersona']; ?></a>
                        </li>
                        <li class="list-group-item">
                          <b>Correo</b> <a class="float-right" id="correoPersona"><?php echo $personal['correoPersonal']; ?></a>
                        </li>
                        <li class="list-group-item">
                          <b>Celular</b> <a class="float-right" id="celularPersona"><?php echo $celulares; ?></a>
                        </li>
                        <li class="list-group-item">
                          <b>Dirección</b> <a class="float-right" id="direccionPersona"><?php echo $personal['direccionPersonal']; ?></a>
                        </li>
                        <li class="list-group-item">
                          <b>Banco</b> <a class="float-right" id="bancoPersona"><?php echo $personal['bancoPersonal']; ?></a>
                        </li>
                        <li class="list-group-item">
                          <b>N° Cuenta</b> <a class="float-right" id="cuentaPersona"><?php echo $personal['numCuentaPersonal']; ?></a>
                        </li>
                        <li class="list-group-item">
                          <b>Tipo pago</b> <a class="float-right" id="tipoPago"><?php echo $tipoPago; ?></a>
                        </li>
                        <li class="list-group-item">
                          <b>Monto</b> <a class="float-right" id="montoPago">S/. <?php echo number_format($personal['montoPago'], 2); ?></a>
                        </li>
                      </ul>
                      <div class="row">
                        <div class="p-1 col-6">
                          <button class="btn btn-primary col-12" id="editarDetalles" data-toggle='modal' data-target='#modalDetalles' idPersonal="<?php echo $personal['idPersonal']; ?>">Editar detalles</button>
                        </div>
                        <div class="p-1 col-6">
                          <button class="btn btn-warning col-12" id="editarDatos">Editar Datos</button>
                        </div>
                      </div>
                    </div>
                    <!-- /.card-body -->
                  </div>
                  <div class="col-md-9">
                    <div class="card">
                      <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link" href="#cursos" data-toggle="tab">Cursos</a></li>
                          <li class="nav-item"><a class="nav-link active" href="#horario" data-toggle="tab">Horario</a></li>
                          <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Settings</a></li>
                        </ul>
                      </div><!-- /.card-header -->
                      <div class="card-body">
                        <div class="tab-content">
                          <div class="tab-pane" id="cursos">
                            <div class="row">
                              <div class="mr-2">
                                <button class="btn btn-primary" id="btnRegistrarCurso" data-toggle='modal' data-target='#modalRegistrarCurso'>Agregar Curso</button>
                              </div>
                              <h3>Cursos</h3>
                            </div>
                            <div class="mt-2 col-12">
                              <table class="table table-striped table-hover dt-responsive" id="tablaCursos" style="width: 100%;">
                                <thead>
                                  <tr>
                                    <th>N°</th>
                                    <th>Especialidad</th>
                                    <th>Codigo</th>
                                    <th>Nombre del curso</th>
                                    <th>Creditos</th>
                                    <th>Seccion - Turno</th>
                                    <th>Ciclo</th>
                                    <th>Acciones</th>
                                  </tr>
                                </thead>
                              </table>
                            </div>
                          </div>
                          <!-- /.tab-pane -->
                          <div class="active tab-pane" id="horario">
                            <div class="mb-2">
                              <button type="button" class="btn btn-primary">Registrar</button>
                            </div>
                            <div class="table-responsive">
                              <table class="table table-hover">
                                <thead>
                                  <tr>
                                    <th colspan="2">Hora</th>
                                    <th>Lunes</th>
                                    <th>Martes</th>
                                    <th>Miercoles</th>
                                    <th>Jueves</th>
                                    <th>Viernes</th>
                                    <th>Sábado</th>
                                  </tr>
                                </thead>
                                <tbody>
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

            <!-- /.card -->
                </div>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                Footer
              </div>
              <!-- /.card-footer-->
            </div>
            <!-- /.card -->
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>

<div class="modal" id="modalDetalles">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" id="formDetalles">
        <!-- Modal Header -->
        <div class="modal-header bg-light">
          <h4 class="modal-title" id="tituloPersonal"></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body -->
        <div class="modal-body">          
          <div class="form-row">
            <div class="form-group col-12">
              <label for="txtBancoPersonal">Banco:</label>
              <div class="input-group input-group-sm">
                <input type="text" class="form-control" name="txtBancoPersonal" placeholder="Ingrese entidad bancaria">
              </div>
            </div>
          </div> 
          <div class="form-row">
            <div class="form-group col-12">
              <label for="txtNumCuenta">N° de cuenta:</label>
              <div class="input-group input-group-sm">
                <input type="text" class="form-control" name="txtNumCuenta" placeholder="Ingrese N° de cuenta">
              </div>
            </div>
          </div>           
          <div class="form-row">
            <div class="form-group col-6">
              <label for="cmbTipoPago">Tipo pago:</label>
              <select class="form-control form-control-sm" style="width: 100%;" name="cmbTipoPago" id="cmbTipoPago" required>
                <option value="">Selecciones una opción</option>
                <option value="1">MENSUAL</option>
                <option value="2">HORAS</option>
              </select>
            </div>
            <div class="form-group col-6">
              <label for="txtMontoPersonal">Ingrese monto:</label>
               <div class="input-group input-group-sm">
                <input type="number" class="form-control" name="txtMontoPersonal" placeholder="S/. 0.00" required>
              </div>
            </div>
          </div>
        </div>
        <input type="hidden" name="funcion" value="editarDetalles">
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

<div class="modal" id="modalRegistrarCurso">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" id="formReistrarCurso">
        <!-- Modal Header -->
        <div class="modal-header bg-light">
          <h4 class="modal-title">Registrar curso</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body -->
        <div class="modal-body">  
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
            <div class="form-group col-6">
              <label for="cmbSeccionCurso">Sección:</label>
              <select class="form-control form-control-sm" style="width: 100%;" name="cmbSeccionCurso" id="cmbSeccionCurso" required>
                <option value="">Selecciones una opción</option>
              </select>
            </div>
          </div>     
          <ul class="list-group" id="listaCursos">
          </ul>
        </div>
        <input type="hidden" name="funcion" value="registrarCurso">
        <input type="hidden" name="idPersonal" value="<?php echo $personal['idPersonal']; ?>">
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
                    <input type="hidden" name="minutos" value="">
                    <input type="hidden" name="funcion" value="registrarHorario">
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
</div