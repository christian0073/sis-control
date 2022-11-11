<?php 
    $fechaMin = Date("Y-m");
 ?>
<div class="content-wrapper">
   <!-- Main content -->
   <section class="content">
       <div class="container-fluid">
           <h2 class="text-center display-4">Realizar Busqueda</h2>
           <form method="POST" id="formBuscarDocente">
               <div class="row justify-content-center">
                    <div class="col-md-7 col-sm-10">
                       <div class="row">
                           <div class="col-4">
                               <div class="form-group">
                                   <label>Fecha:</label>
                                   <input type="month" class="form-control form-control-lg" name="txtFechaBuscar" max="<?php echo $fechaMin; ?>">
                               </div>
                           </div>
                           <div class="col-8">
                               <div class="form-group">
                                    <label>Datos:</label>
                                    <div class="input-group input-group-lg">
                                        <input type="search" class="form-control form-control-lg" name="textBuscarDocente" list="buscar" autocomplete="off">
                                        <datalist id="buscar">
                                        </datalist>
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-lg btn-info">
                                               <i class="fa fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                               </div>                               
                           </div>
                       </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box">
                          <span class="info-box-icon bg-info"><i class="fa-solid fa-clock"></i></span>
                          <div class="info-box-content">
                            <span class="info-box-text">Horas al mes</span>
                            <span class="info-box-number" id="cantHoras">0</span>
                          </div>
                          <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
               </div>
               <input type="hidden" name="idPersonal" value="">
               <input type="hidden" name="funcion" value="mostrarAsistencia">
           </form>
       </div>
   </section>
    <div class="content">
      <div class="card card-danger card-outline">
        <div class="card-body">
          <div class="col-12 table-responsive">
            <table class="table table-hover text-center " style="font-size: 13px;" id="tablaPagos">
            </table>
          </div>
        </div>
      </div>
    </div>    
</div>