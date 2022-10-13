var fechaSuper = "";

$(document).ready(function(){
	$('.select2').select2();
   	activarLinkMenu("reprogramar", "#registrar");
});

$(document).on("click", "#btnBuscarSupervision", function(e){
	let fecha = $("input[name='txtFechaSupervision']").val();
	if (fecha != "") {
		let datos = new FormData();
   	datos.append("funcion", "mostrarReprogramacion");
   	datos.append("fecha", fecha);
   	buscarEnTabla('tablaReprogramar', 'supervision.ajax.php', datos, 25);
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
   $("input[name='idAsistenciaDocente']").val('');
   $("input[name='txtFechaRep']").prop('min', fechaSuper);
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
         if (response != false) {
            $("#cmbTipoClase").val(response['tipo']);
            $("input[name='editar']").val(true);
            ocultarSelectCmb("cmbTipoClase");
            $("input[name='txtHoraEntrada']").val(response['horaEntrada']);
            $("input[name='txtHoraSalida']").val(response['horaSalida']);
            $("textarea[name='txtObservacion']").val(response['observacion']);
            $("input[name='idAsistenciaDocente']").val(response['idAsistenciaDocente']);
         }else{
            mostrarSelectCmb('cmbTipoClase', 'selecione un opción');
            $("input[name='editar']").val(false);
         }
      }
   });      
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
         }else if(response == 'noval'){
            alertaMensaje1('top-right', 'warning', '¡La hora de salida no puede ser mayor a la hora de entrada!');
         }else{
            mensaje('¡ERROR!', '¡Ah ocurrido un error al realizar la acción! Comuniquese con el administrador de inmediato.' , 'error');
         }
      }
   });
   event.preventDefault();
});

$(document).on("click", ".eliminarRep", function(e){
   let idPersonal = $(this).attr('idPersonal');
   let idHorarioCurso = $(this).attr('idHorarioCurso');
   let idReprogramar = $(this).attr('idReprogramar');
   let fecha = $(this).attr('fechaRep');
   let idAsistenciaDocente = '';
   let datos1 = new FormData();
   datos1.append('funcion', 'mostrarAsistencia');
   datos1.append('fecha', fecha);
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
         if (response != false) {
            idAsistenciaDocente = response['idAsistenciaDocente'];
         }else{
            idAsistenciaDocente = '';
         }
      }
   }); 
   swal({
      title: "Advertencia",
      text: "¿Está seguro de elimar el registro?",
      type: "warning",
      showConfirmButton: true,
      confirmButtonText: "Aceptar!",
      showCancelButton: true,
   }).then(function(result){
      if (result.value) {
         let datos2 = new FormData();
         datos2.append('idAsistenciaDocente', idAsistenciaDocente);
         datos2.append('idReprogramar', idReprogramar);
         datos2.append('funcion', "elimarRep");
         $.ajax({
            url:"ajax/supervision.ajax.php",
            method: "POST",
            data: datos2,
            cache: false,
            contentType: false,
            processData: false,
            success:function(response){
               if (response == 'ok') {
                  let datos = new FormData();
                  datos.append("funcion", "mostrarReprogramacion");
                  datos.append("fecha", fechaSuper);
                  buscarEnTabla('tablaReprogramar', 'supervision.ajax.php', datos, 25);
                  alertaMensaje1('top-right', 'success', '¡Acción realizada con exito!');
               }else{
                  mensaje('¡ERROR!', '¡Ah ocurrido un error al realizar la acción! Comuniquese con el administrador de inmediato.' , 'error');
               }
            }
         });
      }
   });     
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