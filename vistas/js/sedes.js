$(document).ready(function(){
   mostrarSedes();
   $('.select2').select2();
   activarLinkMenu("sedes", "#ajustes");
});

$(document).on('click', '#btnAgregarSede', function(e) {
   $("#formRegistrarSede")[0].reset();
	$('input[name="txtNombreSede"]').focus();
});

$('#formRegistrarSede').submit(event=>{
   $.ajax({
      url:"ajax/sede.ajax.php",
      method: "POST",
      data: $('#formRegistrarSede').serialize(),
      cache: false,
      success:function(response){
      	if (response == 'ok') {
            mostrarSedes();
            $("#modalRegistrarSede").modal("hide");
            mensaje('¡CORRECTO!', 'La sede se registro con exito.' , 'success');
       	}else if(response == 'no'){
            mensaje('¡CORREGIR!', '¡no se permite caracteres especiales!', 'warning');
       	}else{
            mensaje('¡ERROR!', '¡Ah ocurrido un error al realizar la acción! Comuniquese con el administrador de inmediato.' , 'error');
       	}
      }
   });
   event.preventDefault();
});

$(document).on('click', '.btnAgregarLocal', function(e){
   let idSede = $(this).attr('idSede');
   let nombre = $(this).attr('nombre');
   $("#fomLocal")[0].reset();
   $('#titulo-sede').html(nombre);
   $('input[name="idSede"]').val(idSede);
   $('input[name="txtSede"]').val(nombre);
   $('#fomLocal input[name="funcion"]').val('registrarLocal');
   cmbDepartamentos('cmbDepartamento');
   $("#cmbProvincia").html("");  
   $("#cmbProvincia").append($("<option>", {value: "",text: "Seleccione una opción"}));
   $("#cmbDistrito").html("");  
   $("#cmbDistrito").append($("<option>", {value: "",text: "Seleccione una opción"}));
});

$(document).on('change', '#cmbDepartamento', function(){
  let ubigeo = $(this).val();
  mostrarProvinciaDistrito('cmbProvincia', 'provincias.json', ubigeo);
  $(this).find("option[value='']").remove();     
  $('input[name="txtDepartamento"]').val($("#cmbDepartamento option:selected").text());
});

$(document).on('change', '#cmbProvincia', function(){
  let ubigeo = $(this).val();
  mostrarProvinciaDistrito('cmbDistrito', 'distritos.json', ubigeo);
  $(this).find("option[value='']").remove();     
  $('input[name="txtProvincia"]').val($("#cmbProvincia option:selected").text());
});

$(document).on('change', '#cmbDistrito', function(){
  $(this).find("option[value='']").remove();     
  $('input[name="txtDistrito"]').val($("#cmbDistrito option:selected").text());
});

$('#fomLocal').submit(event=>{
   $.ajax({
      url:"ajax/local.ajax.php",
      method: "POST",
      data: $('#fomLocal').serialize(),
      cache: false,
      success:function(response){
         if (response == 'ok') {
            let idSede = $('input[name="idSede"]').val();
            let datos = new FormData();
            datos.append('funcion', 'mostrarLocales');
            datos.append('idSede', idSede);
            $('#titSede').html($('#titulo-sede').html());
            mostrarLocales(datos);
            $("#modalLocal").modal("hide");
            mensaje('¡CORRECTO!', 'El local se registró con exito.' , 'success');
         }else if(response == 'no'){
            mensaje('¡CORREGIR!', '¡no se permite caracteres especiales!', 'warning');
         }else{
            mensaje('¡ERROR!', '¡Ah ocurrido un error al realizar la acción! Comuniquese con el administrador de inmediato.' , 'error');
         }
      }
   });
   event.preventDefault();
});
/* evento que muestra los locales activos */
$(document).on('click', '.btnVerLocal', function(e){
   let idSede = $(this).attr('idSede');
   let nombre = $(this).attr('nombre');
   $('#titSede').html(nombre);
   let datos = new FormData();
   datos.append('funcion', 'mostrarLocales');
   datos.append('idSede', idSede);
   mostrarLocales(datos);
});
/* evento para mostrar los datos a editar de un local */
$(document).on('click', '.btnEditarLocal', function(e){
   let idLocal = $(this).attr('idLocal');
   $("#fomLocal")[0].reset();
   $('#titulo-sede').html("Editar el local");
   cmbDepartamentos('cmbDepartamento');
   let datos = new FormData();
   datos.append('funcion', 'verLocal');
   datos.append('idLocal', idLocal);
   $.ajax({
      url:"ajax/local.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success:function(response){
         let departamento = JSON.parse(response['departamento']);
         $("#cmbDepartamento").find("option[value='']").remove();   
         $('#cmbDepartamento').val(departamento.ubigeo);
         let provincia = JSON.parse(response['provincia']);
         mostrarDatosCmb('provincias.json', 'cmbProvincia', departamento.ubigeo, provincia.ubigeo);
         let distrito = JSON.parse(response['distrito']);
         mostrarDatosCmb('distritos.json', 'cmbDistrito', provincia.ubigeo, distrito.ubigeo);
         $('input[name="txtSede"]').val(response['nombreSede']);
         $('input[name="idLocal"]').val(response['idLocal']);
         $('input[name="txtCodigo"]').val(response['codigoModular']);
         $('input[name="txtCodigoLocal"]').val(response['codigoLocal']);
         $('textarea[name="txtDireccion"]').val(response['direccion']);
         $('input[name="txtDepartamento"]').val(departamento.nombre);
         $('input[name="txtProvincia"]').val(provincia.nombre);
         $('input[name="txtDistrito"]').val(distrito.nombre);
         $('#fomLocal input[name="funcion"]').val('editarLocal');
         $('input[name="idSede"]').val('idSedeLocal');
      }
   });   
});
/* función para borrar un local */
$(document).on("click", ".btnEliminarLocal", function(e){
   let idLocal = $(this).attr('idLocal');
   let idSede = $(this).attr('idSede');
   swal({
      title: "¿Está seguro de eliminar la filial?",
      text: "¡Sí no lo está, puede cancelar la acción!",
      type: "warning",
      showCancelButton: true,
      cancelButtonText: "¡Cancelar!",
      focusCancel: true,
      confirmButtonText: "Sí, Eliminar",
   }).then(function(result){
      if (result.value) {
         let datos = new FormData();
         datos.append('funcion', 'eliminarLocal');
         datos.append('idLocal', idLocal);
         $.ajax({
            url:"ajax/local.ajax.php",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            success:function(response){
               if (response == 'ok') {
                  let datos1 = new FormData();
                  datos1.append('funcion', 'mostrarLocales');
                  datos1.append('idSede', idSede);
                  mostrarLocales(datos1);
                  mensaje('¡CORRECTO!', 'La filial fue eliminada con exito.' , 'success');
               }else{
                  mensaje('¡ERROR!', '¡Ah ocurrido un error al realizar la acción! Comuniquese con el administrador de inmediato.' , 'error');
               }
            }
         });
      }
   });
});

$(document).on("click", ".btnAgregarCarrera", function(e){
   mostrarSelectCmb('cmbCarreras', "Elejir una especialidad");
   let idLocal = $(this).attr('idLocal');
   $("input[name='idLocalCarrera']").val(idLocal);
   $("input[name='txtNombreCarrera']").val("");
   $("#formCarrera input[name='funcion']").val("registrarCarreraLocal");
});

$(document).on("change", "#cmbCarreras", function(e){
  $(this).find("option[value='']").remove();
  $('input[name="txtNombreCarrera"]').val($(this).find("option:selected").text());  
});

$('#formCarrera').submit(event=>{
   $.ajax({
      url:"ajax/carrera.ajax.php",
      method: "POST",
      data: $('#formCarrera').serialize(),
      cache: false,
      success:function(response){
         if (response == 'ok') {
            mostrarCarrerasLocal($("input[name='idLocalCarrera']").val())
            $("#modalCarrera").modal("hide");
            mensaje('¡CORRECTO!', 'La carrera se registró con exito.' , 'success');
         }else if(response == 'existe'){
            mensaje('¡CORREGIR!', '¡El local ya tiene registrado la carrera!', 'warning');
         }else{
            mensaje('¡ERROR!', '¡Ah ocurrido un error al realizar la acción! Comuniquese con el administrador de inmediato.' , 'error');
         }
      }
   });
   event.preventDefault();
});

$(document).on("click", ".btnVerCarreras", function(e){
   let idLocal = $(this).attr('idLocal');
   mostrarCarrerasLocal(idLocal);
});

$(document).on("click", ".btnDesactivarCarrera", function(e){
   let idLocal = $(this).attr('idLocal');
   let idLocalCarrera = $(this).attr('idCarreraLocal');
   cambiarEstado(0, idLocal, idLocalCarrera);
});

$(document).on("click", ".btnActivarCarrera", function(e){
   let idLocal = $(this).attr('idLocal');
   let idLocalCarrera = $(this).attr('idCarreraLocal');
   cambiarEstado(1, idLocal, idLocalCarrera);
});

function mostrarSedes(){
   let datos = new FormData();
   datos.append('funcion', 'mostrarSedes');
   let template = '';
   $.ajax({
      url:"ajax/sede.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success:function(response){
         response.forEach(valor =>{
            template +=`
               <tr>
                  <td>${valor['nombreSede']}</td>
                  <td>
                     <div class="d-flex justify-content-end">
                       <button class="btn btn-primary btn-sm btnAgregarLocal" nombre="${valor['nombreSede']}" idSede="${valor['idSede']}" data-toggle="modal" data-target="#modalLocal"><i class="fas fa-add"></i> Local</button>
                       <button class="btn btn-info btn-sm ml-2 btnVerLocal" nombre="${valor['nombreSede']}" idSede="${valor['idSede']}"><i class="fa-solid fa-eye"></i> Ver</button>
                     </div>
                  </td>
               </tr>
           `;
         });
         $('#tableSedes').html(template);
      }
   });   
}

function mostrarLocales(datos){
   $('#locales').html('');
    let template = '';
   $.ajax({
      url:"ajax/local.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success:function(response){
         response.forEach(valor =>{
            let departamento = JSON.parse(valor.departamento);
            let provincia = JSON.parse(valor.provincia);
            let distrito = JSON.parse(valor.distrito);
            template +=`
               <div class="card card-danger card-outline">
                  <div class="card-body">
                    <ul class="list-group list-group-unbordered" >
                      <li class="list-group-item">
                        <b>Código modular:</b> <a class="float-right">${valor.codigoModular}</a>
                      </li>
                      <li class="list-group-item">
                        <b>Código de local:</b> <a class="float-right">${valor.codigoLocal}</a>
                      </li>
                      <li class="list-group-item">
                        <b>Ubicación:</b> <p class="p-0 m-0">${departamento.nombre+', '+provincia.nombre+', '+distrito.nombre}</p>
                      </li>
                      <li class="list-group-item">
                        <b>Dirección:</b> <p class="p-0 m-0">${valor.direccion}</p>
                      </li>
                    </ul>
                  </div>
                  <div class="card-footer">
                     <div class="btn-group float-right">
                        <button class="btn btn-primary btn-sm btnAgregarCarrera" idLocal="${valor.idLocal}" data-toggle="modal" data-target="#modalCarrera" title="Registrar carrera"><i class="fas fa-add"></i></button>
                        <button class="btn btn-warning btn-sm btnEditarLocal" idLocal="${valor.idLocal}" data-toggle="modal" data-target="#modalLocal" title="Editar local"><i class="fa-solid fa-pen-to-square"></i></button>
                        <button class="btn btn-info btn-sm btnVerCarreras" idLocal="${valor.idLocal}" title="Ver carreras"><i class="fa fa-solid fa-eye"></i></button>
                        <button class="btn btn-dark btn-sm btnEliminarLocal" idLocal="${valor.idLocal}" idSede="${valor.idSedeLocal}" title="Elimnar local"><i class="fa-solid fa-trash-can"></i></button>
                     </div>
                  </div>
               </div> 
           `;
         });
         $('#locales').html(template);
      }
   });   
}

function mostrarCarrerasLocal(idLocal){
   let datos = new FormData();
   datos.append('funcion', 'mostrarCarrerasLocal');
   datos.append('idLocal', idLocal);
   let template = '';
   $.ajax({
      url:"ajax/carrera.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success:function(response){
         let num = 0;
         let estado = "";
         let accion = "";
         response.forEach(valor =>{
            num++;
            if (valor['estado'] == 1) {
               estado = "<h5><span class='badge badge-info'>Activo</span></h5>";
               accion = "<div class='btn-group'><button class='btn btn-dark btn-sm btnDesactivarCarrera' idLocal='"+valor['idLocal']+"' idCarreraLocal='"+valor['idLocalCarrera']+"' title='Desactivar'><i class='fas fa-sort-down'></i></button></div>"
            }else{
               estado = "<h5><span class='badge badge-dark'>Inactivo</span></h5>";
               accion = "<div class='btn-group'><button class='btn btn-info btn-sm btnActivarCarrera' idLocal='"+valor['idLocal']+"' idCarreraLocal='"+valor['idLocalCarrera']+"' title='Activar'><i class='fas fa-sort-up'></i></button></div>"
            }
            template +=`
               <tr>
                  <td>${num}</td>
                  <td>${valor['nombreCarrera']}</td>
                  <td>${estado}</td>
                  <td>${accion}</td>
               </tr>
           `;
         });
         $('#tablaCarreras').html(template);
      }
   });   
}

function cambiarEstado(estado, idLocal, idLocalCarrera){
   swal({
      title: "¿Está seguro de desactivar / activar la especialidad del local?",
      text: "¡Sí no lo está, puede cancelar la acción!",
      type: "warning",
      showCancelButton: true,
      cancelButtonText: "¡Cancelar!",
      focusCancel: true,
      confirmButtonText: "Sí",
   }).then(function(result){
      if (result.value) {
         let datos = new FormData();
         datos.append('funcion', 'editarLocalCarrera');
         datos.append('estado', estado);
         datos.append('idLocalCarrera', idLocalCarrera);         
         $.ajax({
            url:"ajax/carrera.ajax.php",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            success:function(response){
               if (response == 'ok') {
                  mostrarCarrerasLocal(idLocal);
               }else{
                  mensaje('¡ERROR!', '¡Ah ocurrido un error al realizar la acción! Comuniquese con el administrador de inmediato.' , 'error');
               }
            }
         });
      }
   });
}