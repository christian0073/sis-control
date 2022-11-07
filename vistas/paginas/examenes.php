<?php 
  
 ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6 row">
            <h1 class="m-0">Docentes</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Inicio</a></li>
              <li class="breadcrumb-item active">Docentes</li>
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
            <div class="col-md-3 col-sm-6 col-12">
              <div class="info-box bg-light">
                <span class="info-box-icon bg-primary">1</span>
                <div class="info-box-content">
                  <span class="info-box-text">1er Parcial</span>
                  <span class="info-box-number" id="parcial1">0</span>
                </div>
                <!-- /.info-box-content -->
              </div>              
            </div> 
            <div class="col-md-3 col-sm-6 col-12">
              <div class="info-box bg-light">
                <span class="info-box-icon bg-info">2</span>
                <div class="info-box-content">
                  <span class="info-box-text">2do Parcial</span>
                  <span class="info-box-number" id="parcial2">0</span>
                </div>
                <!-- /.info-box-content -->
              </div>              
            </div> 
            <div class="col-md-3 col-sm-6 col-12">
              <div class="info-box bg-light">
                <span class="info-box-icon bg-secondary">3</span>
                <div class="info-box-content">
                  <span class="info-box-text">3er Parcial</span>
                  <span class="info-box-number" id="parcial3">0</span>
                </div>
                <!-- /.info-box-content -->
              </div>              
            </div> 
            <div class="col-md-3 col-sm-6 col-12">
              <div class="info-box bg-light">
                <span class="info-box-icon bg-dark">4</span>
                <div class="info-box-content">
                  <span class="info-box-text">4to Parcial</span>
                  <span class="info-box-number" id="parcial4">0</span>
                </div>
                <!-- /.info-box-content -->
              </div>              
            </div>                                                            
          </div>
        </div>
        <div class="card-body">
          <div class="col-12">
            <table class="table table-striped table-hover dt-responsive" id="tablaDocentes" style="width: 100%; font-size: 13px;">
              <thead>
                <tr>
                  <th style="width: 20px;">N°</th>
                  <th>Apellidos y Nombres</th>
                  <th>DNI</th>
                  <th>Profesión</th>
                  <th>Correo</th>
                  <th style="width: 100px;">Celulares</th>
                  <th style="width: 100px;">Fecha de cese</th>
                  <th style="width: 120px;">Acciones</th>
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
<div class="modal" id="modalParcial">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="POST" id="formRegistrarExamen">
        <div class="modal-header">
            <h4 class="modal-title" id="nombrePersona"></h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>        
        </div>
        <div class="modal-body">
          <div class="mb-3 row">
            <label for="txtFechaRegistro" class="col-sm-4 col-form-label">Fecha registro:</label>
            <div class="col-sm-8">
              <input type="date" class="form-control" id="txtFechaRegistro" name="txtFechaRegistro" value="<?php echo date("Y-m-d");?>">
            </div>
          </div>
          <div class="mb-3">
            <div class="icheck-danger mb-3">
              <input type="checkbox" id="checkboxTodo" name="checkboxTodo" value="0">
              <label for="checkboxTodo">SELECIONAR TODO</label>
            </div>
          </div>
          <ul class="list-group" id="listaCursos">
          </ul>
        </div>
        <input type="hidden" name="idParcial" required>
        <input type="hidden" name="editar" required>
        <input type="hidden" name="totalCheck" required>
        <input type="hidden" name="funcion" value="registrarParcial" required>
        <input type="hidden" name="idPersonal" required>
        <div class="modal-footer">
          <?php if ($_SESSION['idUsuarioRol'] == 2): ?>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
          <?php endif ?>
          <button type="button" class="btn btn-dark" data-dismiss="modal"><i class="fas fa-window-close"></i> Cerrar</button>
        </div>
      </form>
    </div>
  </div>
</div>