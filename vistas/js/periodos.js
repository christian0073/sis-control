$(document).ready(function(){
	mostrarPeriodos();
	activarLinkMenu("periodos", "#ajustes");
});

$(document).on("click", "#btnAgregarPeriodo", function(e){
	$('#titulo-periodo').html("Registrar nuevo periodo");
	$("#formPeridoLectivo")[0].reset();
	$('input[name="txtYear"]').focus();
	$('#formPeridoLectivo input[name="funcion"]').val("registrarPeriodo");
});

$(document).on("blur", "input[name='txtYear']", function(e){
	$("input[name='txtNombrePeriodo']").val("PL - "+$(this).val()+" - "+$("input[name='txtEtapa']").val());
});

$(document).on("blur", "input[name='txtEtapa']", function(e){
	$("input[name='txtNombrePeriodo']").val("PL - "+$("input[name='txtYear']").val()+" - "+$(this).val());
});

$(document).on("blur", "input[name='txtFechaInicio']", function(e){
	$('input[name="txtFechaFin"]').attr("min", $(this).val());
});

$('#formPeridoLectivo').submit(event=>{
	if ($("input[name='txtFechaInicio']").val() == $("input[name='txtFechaFin']").val()) {
		mensaje('¡ADVERTENCIA!', '¡las fechas no pueden ser iguales!', 'warning');
	}else{
	   $.ajax({
	      url:"ajax/periodo.ajax.php",
	      method: "POST",
	      data: $('#formPeridoLectivo').serialize(),
	      cache: false,
	      success:function(response){
	         if (response == 'ok') {
	         	mostrarPeriodos();
	            $("#modalPeriodo").modal("hide");
	            mensaje('¡CORRECTO!', 'La acción se realizó con exito.' , 'success');
	         }else if(response == 'existe'){
	            mensaje('¡ADVERTENCIA!', '¡Tiene un periodo activo o el periodo ya existe!', 'warning');
	         }else if(response == 'no'){
	            mensaje('¡CORREGIR!', '¡no se permite caracteres especiales!', 'warning');
	         }else{
	            mensaje('¡ERROR!', '¡Ah ocurrido un error al realizar la acción! Comuniquese con el administrador de inmediato.' , 'error');
	         }
	      }
	   });
	}
   event.preventDefault();
});

$(document).on('click', '.btnEditarPeriodo', function(e){
   let idPeriodo = $(this).attr('idPeriodo');
   $("#formPeridoLectivo")[0].reset();
   $('#titulo-periodo').html("Editar el local");
   let datos = new FormData();
   datos.append('funcion', 'verPeriodo');
   datos.append('idPeriodo', idPeriodo);
   $.ajax({
      url:"ajax/periodo.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success:function(response){
         $('input[name="txtYear"]').val(response['yearPeriodo']);
         $('input[name="txtEtapa"]').val(response['etapaPeriodo']);
         $('input[name="txtNombrePeriodo"]').val(response['nombrePeriodo']);
         $('input[name="txtFechaInicio"]').val(response['fechaInicio']);
         $('input[name="txtFechaFin"]').val(response['fechaFin']);
         $('#formPeridoLectivo input[name="funcion"]').val('editarPeriodo');
         $('input[name="idPeriodo"]').val(response['idPeriodo']);
      }
   });   
});

/* función para desactivar  */
$(document).on("click", ".btnActivarPeriodo", function(e){
	let idPeriodo = $(this).attr('idPeriodo');
	cambiarEstado(1, idPeriodo, "Activar");
});

$(document).on("click", ".btnDesactivarPeriodo", function(e){
	let idPeriodo = $(this).attr('idPeriodo');
	cambiarEstado(0, idPeriodo, "Desactivar");
});


function mostrarPeriodos(){
   let datos = new FormData();
   datos.append('funcion', 'mostrarPeriodos');
   let template = '';
   $.ajax({
      url:"ajax/periodo.ajax.php",
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
			accion ="<div class='btn-group'><button class='btn btn-warning btn-sm btnEditarPeriodo' idPeriodo='"+valor['idPeriodo']+"' title ='Editar "+valor['nombrePeriodo']+"' data-toggle='modal' data-target='#modalPeriodo'><i class='fa-solid fa-pen-to-square'></i></button>";
			if (valor['estadoPeriodo'] == 1) {
			   estado = "<h5><span class='badge badge-info'>Activo</span></h5>";
			   accion += "<button class='btn btn-dark btn-sm btnDesactivarPeriodo' idPeriodo='"+valor['idPeriodo']+"' title='Desactivar "+valor['nombrePeriodo']+"'><i class='fas fa-sort-down'></i></button></div>"
			}else{
			   estado = "<h5><span class='badge badge-dark'>Inactivo</span></h5>";
			   accion += "<button class='btn btn-info btn-sm btnActivarPeriodo' idPeriodo='"+valor['idPeriodo']+"' title='Activar "+valor['nombrePeriodo']+"'><i class='fas fa-sort-up'></i></button></div>"
			}
			template +=`
			   <tr>
			      <td>${num}</td>
			      <td>${valor['nombrePeriodo']}</td>
			      <td>${valor['yearPeriodo']} - ${valor['etapaPeriodo']}</td>
			      <td>${valor['fechaIn']}</td>
			      <td>${valor['fechaFi']}</td>
			      <td>${estado}</td>
			      <td>${accion}</td>
			   </tr>
			`;
		});
		$('#tablaPeriodos').html(template);
      }
   });   
}

function cambiarEstado(estado, idPeriodo, texto){
   swal({
      title: "¿Está seguro de "+texto+" el periodo lectivo?",
      text: "¡Sí no lo está, puede cancelar la acción!",
      type: "warning",
      showCancelButton: true,
      cancelButtonText: "¡Cancelar!",
      focusCancel: true,
      confirmButtonText: "Sí",
   }).then(function(result){
      if (result.value) {
         let datos = new FormData();
         datos.append('funcion', 'editarEstadoPeriodo');
         datos.append('estado', estado);
         datos.append('idPeriodo', idPeriodo);         
         $.ajax({
            url:"ajax/periodo.ajax.php",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            success:function(response){
               if (response == 'ok') {
                  mostrarPeriodos();
               }else if(response == 'existe'){
               	mensaje('¡ADVERTENCIA!', '¡Ya tiene registrado un periodo activo!', 'warning');
               }else{
                  mensaje('¡ERROR!', '¡Ah ocurrido un error al realizar la acción! Comuniquese con el administrador de inmediato.' , 'error');
               }
            }
         });
      }
   });
}