
<div class="content-wrapper">
   <!-- Main content -->
   <section class="content">
       <div class="container-fluid">
           <h2 class="text-center display-4">Realizar Busqueda</h2>
           <form method="POST" id="formCargarExcel" enctype="multipart/form-data">
               <div class="row justify-content-center">
                   <div class="col-md-8">
                       <div class="row">
                           <div class="col-md-6">
                               <div class="form-group">
                                    <label>Datos:</label>
                                    <div class="input-group mb-3">
                                        <input type="search" class="form-control" list="buscar" name="textBuscarDocente" placeholder="Apellidos y nombres" autocomplete="off">
                                        <datalist id="buscar">
                                        </datalist>
                                      <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                                      </div>
                                    </div>                            
                               </div>                               
                           </div>
                           <div class=" col-md-6">
                                <div class="form-group">
                                    <label for="fileAsistencia">Cargar archivo</label>
                                    <div class="input-group">
                                      <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="fileAsistencia" id="fileAsistencia" accept=".xls">
                                        <label class="custom-file-label" for="fileAsistencia" id="nombreArchivo" style="font-size: 12px;">Selecionar un archivo</label>
                                      </div>
                                      <div class="ml-2">
                                          <button class="btn btn-info"><i class="fa-solid fa-upload"></i> Enviar</button>
                                      </div>
                                    </div>
                                </div>                            
                           </div>
                           
                       </div>
                   </div>
               </div>
               <input type="hidden" name="idPersonal" value="">
               <input type="hidden" name="funcion" value="registrarAsistencias">
           </form>
       </div>
   </section>
    <div class="content">
      <div class="card card-danger card-outline">

        <div class="card-body">
          <div class="col-12">
            <table class="table table-hover text-center" style="font-size: 13px;" id="tablaPagos">
            </table>
          </div>
        </div>
      </div>
    </div>    
</div>