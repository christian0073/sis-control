var fechaSuper = "";

$(document).ready(function(){
	$('.select2').select2();
   	activarLinkMenu("supervisar", "#registrar");
});

$(document).on("change", "#cmbSedes", function(e){
	let estado = $('input[name="txtFechaSupervision"]').prop("readonly");
	if (estado) {
		$('input[name="txtFechaSupervision"]').prop("readonly", false);
	}
});

$(document).on("click", "#btnBuscarSupervision", function(e){
	let idSede = $("#cmbSedes").val();
	let fecha = $("input[name='txtFechaSupervision']").val();
	if (fecha != "" && idSede != "") {
		let datos = new FormData();
	   	datos.append("funcion", "mostrarSupervision");
	   	datos.append("fecha", fecha);
	   	datos.append("idSede", idSede);
	   	buscarEnTabla('tablaSupervisar', 'supervision.ajax.php', datos, 25);
	   	fechaSuper = fecha;
	}else{
		alertaMensaje1('top-right', 'warning', '¡No se puede realizar la busqueda!');
	}
});

$(document).on("click", ".mostrarAsistencia", function(e){
   let idPersonal = $(this).attr('idPersonal');
   let idHorarioCurso = $(this).attr('idHorarioCurso');
   $("input[name='idCursoHorario']").val(idHorarioCurso);
   $("input[name='idPersonalDocente']").val(idPersonal);
   $("input[name='fechaAsistencia']").val(fechaSuper);
   let fechaSup = new Date(fechaSuper+"T00:00:00");
   $("#formRegistrarAsistencia")[0].reset();
   $('#personafecha').html("");
   let datos = new FormData();
   datos.append('funcion', 'mostrarDatosAsis');
   datos.append('idPersonal', idPersonal);
   datos.append('idHorarioCurso', idHorarioCurso);
   let template = '';
   mostrarSelectCmb('cmbTipoClase', 'selecione un opción');
   $("input[name='txtFechaRep']").prop('disabled', true);
   $.ajax({
      url:"ajax/cursohorario.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success:function(response){
      	$('#personafecha').html(response['apellidoPaternoPersona']+' '+response['apellidoMaternoPersona']+', '+ response['nombresPersona']+' ('+fechaSup.toLocaleDateString()+')');
         template = `
            <li class="list-group-item d-flex justify-content-between">
               Carrera:
               <span style="font-size: 13px;">${response['nombreCarrera']}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between">
               Curso:
               <span style="font-size: 13px;">${response['nombreCurso']}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
               Fecha:
               <span class="badge bg-primary">${fechaSup.toLocaleDateString('pe-ES', { weekday:"long", year:"numeric", month:"long", day:"numeric"})}</span>
            </li>            
         `;         
         $("#listaAsistencia").html(template);
      }
   }); 
   let datos1 = new FormData();
   datos1.append('funcion', 'mostrarAsistencia');
   datos1.append('fecha', fechaSuper);
   datos1.append('idPersonal', idPersonal);
   datos1.append('idHorarioCurso', idHorarioCurso);
   $.ajax({
      url:"ajax/supervision.ajax.php",
      method: "POST",
      data: datos1,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success:function(response){
      	if (response.length > 0) {

      	}else{
            $("input[name='editar']").val(false);
         }
      }
   });       
});

$(document).on("change", "#cmbTipoClase", function(e){
   ocultarSelectCmb("cmbTipoClase");
   let tipoClase = $(this).val();
   if (tipoClase == 3) {
		$("input[name='txtFechaRep']").prop('disabled', false);
   }else{
   	$("input[name='txtFechaRep']").prop('disabled', true);
   }
});


$('#formRegistrarAsistencia').submit(event=>{
   $.ajax({
      url:"ajax/supervision.ajax.php",
      method: "POST",
      data: $('#formRegistrarAsistencia').serialize(),
      cache: false,
      success:function(response){
         if (response == 'ok') {
            mensaje('¡CORRECTO!', 'La acción se realizó con exito.' , 'success');
         }else if(response == 'existe'){
            mensaje('¡ADVERTENCIA!', '¡La persona ya se encuentra registrada!', 'warning');
         }else if(response == 'no'){
            mensaje('¡CORREGIR!', '¡no se permite caracteres especiales!', 'warning');
         }else{
            mensaje('¡ERROR!', '¡Ah ocurrido un error al realizar la acción! Comuniquese con el administrador de inmediato.' , 'error');
         }
      }
   });
   event.preventDefault();
});