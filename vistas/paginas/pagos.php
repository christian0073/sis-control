<?php 
    $fechaMin = Date("Y-m");
 ?>
<div class="content-wrapper">
   <!-- Main content -->
   <section class="content">
       <div class="container-fluid">
           <h2 class="text-center display-4">Realizar Busqueda</h2>
           <form action="POST" id="formBuscarDocente">
               <div class="row justify-content-center">
                   <div class="col-md-8">
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
               </div>
           </form>
       </div>
   </section>
</div>