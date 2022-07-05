<?php 
  $planLectivo = ControladorPlan::ctrVerPlanACtivo();
 ?>
  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6 row">
            <h1 class="m-0">Carreras</h1>
            <button class="ml-2 btn btn-primary btn-sm" id="btnAgregarCarrera" data-toggle='modal' data-target='#modalRegistrarCarrera'><i class="fas fa-add"></i> Agregar carrera</button>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Inicio</a></li>
              <li class="breadcrumb-item active">Carreras</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header p-2">
                <h3 class="card-title">Lista de programa de estudios</h3>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="cursos">
                    <div class="row">
                      <div class="col-lg-4 col-md-5">
                        <table class="table table-hover table-sm">
                          <tbody id="tableCarrera">
                          </tbody>
                          <tfoot>
                            <tr>
                              <td colspan="2"></td>
                            </tr>
                          </tfoot>
                        </table>
                      </div>
                      <div class="col-lg-8 col-md-7">
                        <div class="callout callout-danger p-0">
                          <div class="card">
                            <div class="card-header">
                              <h3 class="card-title text-primary"><i class="fas fa-book"></i> <span id="nombreCurso">Cursos</span></h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group col-6 col-md-6 col-lg-3">
                                  <select class="form-control form-control-sm select2" style="width: 100%;" name="cmbPeriodo" id="cmbPeriodo" disabled>
                                    <option value="">Seleccione una opción</option>
                                    <option value="1">I</option>
                                    <option value="2">II</option>
                                    <option value="3">III</option>
                                    <option value="4">IV</option>
                                    <option value="5">V</option>
                                    <option value="6">VI</option>
                                  </select>
                                </div>  
                              <div class="mt-2 col-12">
                                <table class="table table-striped table-hover dt-responsive" id="tablaCursos" style="width: 100%;">
                                  <thead>
                                    <tr>
                                      <th style="width: 10px;">N°</th>
                                      <th style="width: 40px">Ciclo</th>
                                      <th>Nombre del curso</th>
                                      <th style="width: 35px;">Codigo</th>
                                      <th style="width: 35px;">Requisito</th>
                                      <th style="width: 35px;">Creditos</th>
                                      <th style="width: 45px;">Tipo</th>
                                      <th style="width: 40px;">Acciones</th>
                                    </tr>
                                  </thead>
                                </table>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<div class="modal" id="modalRegistrarCarrera">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <form method="POST" id="formRegistrarCarrera">
        <!-- Modal Header -->
        <div class="modal-header bg-light">
          <h4 class="modal-title" id="tituloCarrera"></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body -->
        <div class="modal-body">
          <div class="form-row">
            <div class="form-group col-12">
              <label for="txtNombreCarrera">Nombre de la carrera:</label>
              <div class="input-group input-group-sm">
                <input type="text" class="form-control" name="txtNombreCarrera" placeholder="Nombre de la carrera" required>
              </div>
            </div>            
          </div>  
          <div class="form-row">
            <div class="form-group col-12">
              <label for="txtNombrePlan">Nombre del plan:</label>
              <div class="input-group input-group-sm">
                <input type="text" class="form-control" name="txtNombrePlan" placeholder="<?php echo $planLectivo['nombrePlan']; ?>" readonly>
              </div>
            </div>            
          </div>
        </div>
        <input type="hidden" name="idCarrera">
        <input type="hidden" name="funcion">
        <input type="hidden" name="idPlanLectivo" value="<?php echo $planLectivo['idPlan']; ?>">
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
      <form method="POST" id="formRegistrarCurso">
        <!-- Modal Header -->
        <div class="modal-header bg-light">
          <h4 class="modal-title" id="tituloCurso"></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body -->
        <div class="modal-body">
          <div class="form-row">
            <div class="form-group col-10">
              <label for="txtNombreCurso">Nombre del curso:</label>
              <div class="input-group input-group-sm">
                <input type="text" class="form-control" name="txtNombreCurso" placeholder="Nombre del curso" required>
              </div>
            </div>
            <div class="form-group col-2">
              <label for="txtCreditosCurso">Creditos:</label>
              <div class="input-group input-group-sm">
                <input type="number" class="form-control" min="0" max="4" name="txtCreditosCurso" placeholder="N°" required>
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-6">
              <label for="cmbTipoCurso">Tipo:</label>
              <select class="form-control form-control-sm select2" style="width: 100%;" name="cmbTipoCurso" id="cmbTipoCurso" required>
                <option value="">Seleccione una opción</option>
                <option value="C">Carrera</option>
                <option value="T">Transversal</option>
              </select>
            </div>
            <div class="form-group col-6">
              <label for="cmbPeriodoCurso">Periodo:</label>
              <select class="form-control form-control-sm select2" style="width: 100%;" name="cmbPeriodoCurso" id="cmbPeriodoCurso" required>
                <option value="">Seleccione una opción</option>
                <option value="1">I</option>
                <option value="2">II</option>
                <option value="3">III</option>
                <option value="4">IV</option>
                <option value="5">V</option>
                <option value="6">VI</option>
              </select>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-6">
              <label for="txtCodigoCurso">Código:</label>
              <div class="input-group input-group-sm">
                <input type="text" class="form-control" name="txtCodigoCurso" placeholder="Ingrese código" required>
              </div>
            </div>            
            <div class="form-group col-6">
              <label for="txtCorrelativoCurso">Correlativo:</label>
              <div class="input-group input-group-sm">
                <input type="text" class="form-control" name="txtCorrelativoCurso" placeholder="Ingrese correlativo">
              </div>
            </div>  
          </div>
        </div>
        <input type="hidden" name="idCarreraCurso">
        <input type="hidden" name="idCurso">
        <input type="hidden" name="funcion">
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