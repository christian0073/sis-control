var fechaSuper = "";
var sedeSuper = "";

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
	   	buscarEnTabla('tablaSupervisar', 'supervision.ajax.php', datos, 100);
	   	fechaSuper = fecha;
         sedeSuper = idSede;
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
   $("input[name='txtFechaRep']").prop('disabled', true);
   $("input[name='idAsistenciaDocente']").val('');
   $("input[name='idReprogramar']").val('');
   let horaIngreso = '';
   let horaSalida = '';
   $.ajax({
      url:"ajax/cursohorario.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success:function(response){
         horaIngreso = response['horaIngreso'];
         horaSalida = response['horaSalida'];
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
   datos1.append('horaIngreso', horaIngreso);
   datos1.append('horaSalida', horaSalida);
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
         if (response != false) {
            $("#cmbTipoClase").val(response['tipo']);
            $("input[name='editar']").val(true);
            ocultarSelectCmb("cmbTipoClase");
            if (response['tipo'] == 3) {
               $("#cmbTipoClase option:not(:selected)").prop("disabled", true);
               $("input[name='txtFechaRep']").prop('disabled', false);
               $("input[name='txtFechaRep']").val(response['fechaRep']);
               $("input[name='idReprogramar']").val(response['idReprogramar']);
            }else{
               $("#cmbTipoClase").prop('readonly', false);
               $("input[name='txtFechaRep']").prop('disabled', true);
               $("#cmbTipoClase option").prop("disabled", false);
            }
            $("input[name='txtHoraEntrada']").val(response['horaEntrada']);
            $("input[name='txtHoraSalida']").val(response['horaSalida']);
            $("textarea[name='txtObservacion']").val(response['observacion']);
            $("input[name='idAsistenciaDocente']").val(response['idAsistenciaDocente']);
      	}else{
            $("#cmbTipoClase option").prop("disabled", false);
            mostrarSelectCmb('cmbTipoClase', 'selecione un opción');
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
            $("#modalAsistencia").modal("hide");
            let datos1 = new FormData()
            datos1.append("funcion", "mostrarSupervision");
            datos1.append("fecha", fechaSuper);
            datos1.append("idSede", sedeSuper);
            buscarEnTabla('tablaSupervisar', 'supervision.ajax.php', datos1, 100);
         }else if(response == 'noval'){
            alertaMensaje1('top-right', 'warning', '¡La hora de salida no puede ser mayor a la hora de entrada!');
         }else if(response=='error'){
            mensaje('¡ADVERTENCIA!', '¡El tiempo de sessión ah expirado. Actualice la pagina' , 'warning');
         }else if (response == 'nofecha') {
            mensaje('¡ADVERTENCIA!', '¡La fecha reprogramación no fue ingresada' , 'warning');
         }else{
            mensaje('¡ERROR!', '¡Ah ocurrido un error al realizar la acción! Comuniquese con el administrador de inmediato.' , 'error');
         }
      }
   });
   event.preventDefault();
});

$(document).on('click','.agregarLink', function(e){
   let idHorarioCurso = $(this).attr('idHorarioCurso');
   swal({
      title: 'Ingrese link de la clase',
      input: 'url',
      inputPlaceholder: 'Link de la clase',
      showCancelButton: true,
      cancelButtonText: 'Cancelar'
   }).then(function(result){
      if (result.value) {
         let datos = new FormData();
         datos.append('funcion', 'editarLink');
         datos.append('link', result.value);
         datos.append('idHorarioCurso', idHorarioCurso);
         $.ajax({
            url:"ajax/supervision.ajax.php",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            success:function(response){
               if (response == 'ok') {
                  alertaMensaje1('top-right', 'success', '¡El link fue registrado con exito!');
                  let datos1 = new FormData()
                  datos1.append("funcion", "mostrarSupervision");
                  datos1.append("fecha", fechaSuper);
                  datos1.append("idSede", sedeSuper);
                  buscarEnTabla('tablaSupervisar', 'supervision.ajax.php', datos1, 100);
               }else{
                  alertaMensaje1('top-right', 'warning', '¡Ocurrió un error al registrar el link!');
               }
            }
         });
      }
   });
});