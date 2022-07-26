  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Reprogramación</h1>
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
                <div class="mr-2">
                  <button class="btn btn-primary" id="btnRegistrarCurso" data-toggle='modal' data-target='#modalRegistrarCurso'>Agregar Curso</button>
                </div>
                <h3>Cursos</h3>
              </div>
              <div class="mt-2 col-12">
                <table class="table table-striped table-hover dt-responsive" id="tablaCursos" style="width: 100%;">
                  <thead>
                    <tr>
                      <th style="width: 20px;">N°</th>
                      <th>Especialidad</th>
                      <th style="width: 30px;">Codigo</th>
                      <th>Nombre del curso</th>
                      <th style="width: 130px;">Seccion - Turno</th>
                      <th style="width: 40px;">Ciclo</th>
                      <th style="width: 40px;">Acciones</th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>
            <!-- /.tab-pane -->
            <div class="tab-pane" id="horario">
              <div class="mb-2">
                <button type="button" class="btn btn-primary">Registrar</button>
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