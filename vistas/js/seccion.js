var queryString = window.location.search;
var urlParams = new URLSearchParams(queryString);
var idSeccionGlobal = urlParams.get('idSeccion');
$(document).ready(function(){
	activarLinkMenu("seccion", "#ajustes");
   	let mostrarCursos = new FormData();
   	mostrarCursos.append("funcion", "mostrarCursosSeccion");
   	mostrarCursos.append("idSeccion", idSeccionGlobal);
   	buscarEnTabla('tablaCursos', 'cursoaula.ajax.php', mostrarCursos, 10);
});

$(document).on("click", ".btnAgregarDocente", function(){
	$("input[name='txtDniPersonal']").focus();
	let idHorarioCurso = $(this).attr('idHorarioCurso');
	$("input[name='idCursoHorario']").val(idHorarioCurso);
	$("#formRegistrarDocente")[0].reset();
})

$(document).on("click", "#btnBuscarDni", function(e){
   		let dniUsuario = $("input[name='txtDniPersonal']").val().trim();
   		let dato = /^\d*$/.test(dniUsuario);
		let datos = new FormData();
		datos.append('funcion', 'buscarDniPersonal');
		datos.append('dni', dniUsuario);
  	 	buscarDniPersonal(datos, dniUsuario, dato);
});

$(document).on("keypress", "input[name='txtDniPersonal']", function(e){
    if (event.keyCode === 13) {
      let dniUsuario = $(this).val().trim();
      let dato = /^\d*$/.test($(this).val());
      let datos = new FormData();
      datos.append('funcion', 'buscarDniPersonal');
      datos.append('dni', dniUsuario);
      buscarDniPersonal(datos, dniUsuario, dato);
   }
});

$("#formRegistrarDocente").submit(event=>{
	$.ajax({
		url:"ajax/cursoAula.ajax.php",
		method: "POST",
		data: $('#formRegistrarDocente').serialize(),
		cache: false,
		success:function(response){
			if (response == 'ok') {
				let mostrarCursos = new FormData();
				mostrarCursos.append("funcion", "mostrarCursosSeccion");
				mostrarCursos.append("idSeccion", idSeccionGlobal);
				buscarEnTabla('tablaCursos', 'cursoaula.ajax.php', mostrarCursos, 10);
				$("#modalAgregarDocente").modal("hide");
				mensaje('¡CORRECTO!', 'La acción se realizó con exito.' , 'success');
			}else if(response == 'no'){
				mensaje('¡CORREGIR!', '¡no se permite caracteres especiales!', 'warning');
			}else{
				mensaje('¡ERROR!', '¡Ah ocurrido un error al realizar la acción! Comuniquese con el administrador de inmediato.' , 'error');
			}
      	}
   });
   event.preventDefault();
});

var turno;
var step;
var minTime = '';
var maxTime = '';
$(document).on("click", ".agregarHorario", function(e){
   let idSeccion = $(this).attr('idSeccion');
   let datos = new FormData();
   let template = '';
   datos.append('funcion', 'mostrarDetallesCurso');
   datos.append('idSeccion', idSeccion);
   $.ajax({
      url:"ajax/aula.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success:function(response){
         let turno = '';
         if (response['turno'] == 'M') {
            step = 3000;
            minTime = '08:00';
            maxTime = '13:00';
            turno = 'MAÑANA';
            $('input[name="minutos"]').val(50);
         }else if(response['turno'] == 'T'){
            turno = 'TARDE';
            step = 3000;
            minTime = '13:30';
            maxTime = '18:30';
            $('input[name="minutos"]').val(50);
         }else if (response['turno'] == 'N') {
            minTime = '16:00';
            maxTime = '23:00';
            turno = 'NOCHE';
            step = '';
            $('input[name="minutos"]').val(45);
         }
         template = `${response['nombreSeccion']} (${turno}), ${response['nombreSede']}, ${response['direccion']}`;
         $("#tituloCurso").html(template);
      }
   }); 
   for (var i = 1; i <= 7; i++) {
      let elemento1 = $("#dia" + i).find(".d-flex");
      let numElementos = $(elemento1).length;
      if (numElementos > 0) {
         $(elemento1).remove();
      }
   }
   $("#nombreCurso").html($(this).attr('nombreCurso'));
   let idhorariocurso = $(this).attr('idhorariocurso');
   $('input[name="idCursoHorario"]').val(idhorariocurso);
   let datos1 = new FormData();
   datos1.append('funcion', 'mostrarHoras');
   datos1.append('idhorariocurso', idhorariocurso);
   $(".horasCurso1").html('-');
   $("#totalHoras").html('0');
   let horasAcumulada = 0;
   $.ajax({
      url:"ajax/cursoaula.ajax.php",
      method: "POST",
      data: datos1,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success:function(response){
         if (response.length > 0) {
            response.forEach(function (valor) {
               let diaId = valor['dia']
               let elemento = $("#form" + diaId).find(".btn-group")[0];
               let elemento1 = $("#dia" + diaId).find(".d-flex");
               let cont = $(elemento1).length;
               let template = `<div class="d-flex mr-2">
                                 <div class="mr-1">
                                    <input type="time" name="txtEntrada${cont+1}" class="form-control form-control-sm inputEntrada" value="${valor['horaEntrada']}"  min="${minTime}" step="${step}" required>
                                 </div>
                                 <div class="mr-1">
                                    <input type="time" name="txtSalida${cont+1}" class="form-control form-control-sm inputSalida" value="${valor['horaSalida']}" max="${maxTime}" step="${step}" required>
                                 </div>
                                 <div class="mr-1">
                                    <button type="button" class="btn btn-light btn-sm btn-outline-danger btnQuitarForm">x</button>
                                 </div>
                                 <input type="hidden" class="inputTipo" name="tipo${cont+1}" value="${valor['tipo']}">
                              </div> `;
               elemento.insertAdjacentHTML("beforebegin", template);
               horasAcumulada += + valor['horas'];
               let horas = $("#horasCurso" + diaId).html();
               if (horas == '-') {
                  $("#horasCurso" + diaId).html(valor['horas']);
               }else{
                  $("#horasCurso" + diaId).html(parseInt(horas)+parseInt(valor['horas']));
               }
            }); 
         }
      $("#totalHoras").html(horasAcumulada);
      }
   }); 
});

$(document).on("click", ".btnTeoria", function(e){
   let padre = $(this).parent().parent().parent()[0];
   let padre1 = $(this).parent().parent().parent().parent()[0];
   let cont = $(padre1).find('.d-flex').length;
   mostrarInputTime(cont, padre, 'T');
});

$(document).on("click", ".btnPractica", function(e){
   let padre = $(this).parent().parent().parent()[0];
   let padre1 = $(this).parent().parent().parent().parent()[0];
   let cont = $(padre1).find('.d-flex').length;
   mostrarInputTime(cont, padre, 'P');
});

$(document).on("click", ".btnQuitarForm", function(e){
   let padre = $(this).parent().parent();
   let padre1 = $(this).parent().parent().parent()[0];
   let cont = $(padre1).find('.d-flex').length;
   let i = 0;
   $(padre).remove();
   /* bucle para renombrar los nombres de los inputs */
   while(i < cont){
      let nombreEntrada = "txtEntrada" + (i + 1);
      let nombreSalida = "txtSalida" + (i + 1);
      let nombreTipo = "tipo" + (i + 1);
      let elemento = $(padre1).find('.d-flex')[i];
      $(elemento).find('.inputEntrada').prop('name', nombreEntrada); 
      $(elemento).find('.inputSalida').prop('name', nombreSalida);
      $(elemento).find('.inputTipo').prop('name', nombreTipo);
      i++;
   }
});

$(document).on('keyup, change', '.inputEntrada', function(e){
   let hora_escogida = $(this).val();
   if (hora_escogida < '18:30') {
      step = 3000;
   }else if(hora_escogida >= '18:30'){
      step = 2700;
      $(this).prop('min', '18:30');
      $(this).prop('step', step);
   }
   let elementoPadre = $(this).parent().parent();
   let horaSalida= tiempo((step/60), hora_escogida);
   let inputSalida = $(elementoPadre).find('.inputSalida');
   $(inputSalida).prop('min', horaSalida);
   $(inputSalida).prop('step', step);
   $(inputSalida).prop('readonly', false);
});

$(document).on("click", ".btnVerDetalles", function(e){
   let idSeccion = $(this).attr('idSeccion');
   let datos = new FormData();
   let template = '';
   datos.append('funcion', 'mostrarDetallesCurso');
   datos.append('idSeccion', idSeccion);
   $.ajax({
      url:"ajax/aula.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success:function(response){
         template += `
            <li class="list-group-item d-flex justify-content-between align-items-center">
               <label>Sede:</label>
               <span class="">${response['nombreSede']}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
               <label>Local:</label>
               <span class="">${response['direccion']}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
               <label>Periodo lectivo:</label>
               <span class="">${response['nombrePeriodo']}</span>
            </li>
         `;
         $("#detalleCurso").html(template);
      }
   }); 
});

function buscarDniPersonal(datos, dniUsuario, dato){
	if(dniUsuario.length == 8 && dato){
     	$.ajax({
			url:"ajax/personal.ajax.php",
			method: "POST",
			data: datos,
			cache: false,
			contentType: false,
			processData: false,
			dataType: "json",
			success:function(response){
	            if(response['valor'] && response['valor'] == 'no'){
               		alertaMensaje1('top-right', 'warning', '¡Persona no registrada!');
	            }else if (response['idPersonal']) {
	               $("input[name='txtDatos']").val(response['apellidoPaternoPersona']+' '+response['apellidoMaternoPersona']+', '+response['nombresPersona']);
	               $("input[name='txtProfesion']").val(response['profesionPersonal']);
	               $("input[name='idPersonalDocente']").val(response['idPersonal']);
	            }else{
	               alertaMensaje1('top-right', 'error', '¡Hubó un error al realizar la busqueda!');
	            }
			}
      	});   
	}else{
	  alertaMensaje1('top-right', 'warning', '¡Dato invalido!');
	}
}

function mostrarInputTime(cont, elemento, tipo){
      let template = `<div class="d-flex mr-2">
                        <div class="mr-1">
                           <input type="time" name="txtEntrada${cont+1}" class="form-control form-control-sm inputEntrada" min="${minTime}" step="${step}" required>
                        </div>
                        <div class="mr-1">
                           <input type="time" name="txtSalida${cont+1}" class="form-control form-control-sm inputSalida" max="${maxTime}" required readonly>
                        </div>
                        <div class="mr-1">
                           <button type="button" class="btn btn-light btn-sm btn-outline-danger btnQuitarForm">x</button>
                        </div>
                        <input type="hidden" class="inputTipo" name="tipo${cont+1}" value="${tipo}">
                     </div> `;
   elemento.insertAdjacentHTML("beforebegin", template);
}