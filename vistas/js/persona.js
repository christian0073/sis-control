var icheck = 0;
var queryString = window.location.search;
var urlParams = new URLSearchParams(queryString);
var idPersonalGlobal = urlParams.get('idPersonal');
var idActivo = '';
const arrMeses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
$(document).ready(function(){
   $('.select2').select2();
   activarLinkMenu("persona", "#registrar");
   let mostrarCursos = new FormData();
   mostrarCursos.append("funcion", "mostrarCursosDocente");
   mostrarCursos.append("idPersonal", idPersonalGlobal);
   buscarEnTabla('tablaCursos', 'cursoaula.ajax.php', mostrarCursos, 10);
});

   

$(document).on("click", "#verCursos", function(e){
   if ($("#body").hasClass("bg-light")) {
      $('#body').removeClass('bg-light');
   }
});

$(document).on("click", "#verHistorial", function(e){
   if (!$("#body").hasClass("bg-light")) {
      $('#body').addClass('bg-light');
   }
   let historial = new FormData();
   historial.append("funcion", "mostrarHistorial");
   historial.append("idPersonal", idPersonalGlobal);
   mostrarHistorial(historial)
});

$(document).on("click", "#mes01, #mes02, #mes03, #mes04, #mes05, #mes06, #mes07, #mes08, #mes09, #mes10, #mes11, #mes12", function(e){
   console.log("idActivo", idActivo);
   let mes = $(this).attr('mes');
   let historial = new FormData();
   historial.append("funcion", "mostrarHistorial");
   historial.append("idPersonal", idPersonalGlobal);
   mostrarHistorial(historial)
   historial.append("mes", mes);
   mostrarHistorial(historial);
   $("#mesTitulo").html(arrMeses[mes-1]);
});

$(document).on("click", "#verHorario", function(e){
   if ($("#body").hasClass("bg-light")) {
      $('#body').removeClass('bg-light');
   }
   let mostrarHorario = new FormData();
   mostrarHorario.append("funcion", "mostrarHorario");
   mostrarHorario.append("idPersonal", idPersonalGlobal);
   mostrarHorario.append("nombreCargo", nombreCargo);
   mostrarHorarios("#tableHorario", mostrarHorario);
   let datos = new FormData();
   datos.append('funcion', 'verHoras');
   datos.append('idPersonal', idPersonalGlobal);
   $.ajax({
      url:"ajax/cursohorario.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      success:function(response){
         if (response == '') {
            $("#horas").html(0);
         }else{
            $("#horas").html(response);
         }
      }
   });
});

/* boton para traer los datos a editar */
$(document).on("click", "#editarDetalles", function(e){
   let idPersonal = $(this).attr('idPersonal');
   $("#formDetalles")[0].reset();
   $('#tituloPersonal').html("");
   let datos = new FormData();
   datos.append('funcion', 'mostrarPersonal');
   datos.append('idPersonal', idPersonal);
   $.ajax({
      url:"ajax/personal.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success:function(response){
         $('#tituloPersonal').html(response['apellidoPaternoPersona']+' '+response['apellidoMaternoPersona']+', '+ response['nombresPersona']+' ('+response['dniPersona']+')');
         $('input[name="txtBancoPersonal"]').val(response['bancoPersonal']);
         $('input[name="txtNumCuenta"]').val(response['numCuentaPersonal']);
         $('input[name="txtMontoPersonal"]').val(response['montoPago'])
         $('#cmbTipoPago').val(response['tipoPago']);
         $('input[name="idPersonal"]').val(response['idPersonal']);
      }
   }); 
});

$('#formDetalles').submit(event=>{
   let idPersonal = $('input[name="idPersonal"]').val();
   $.ajax({
      url:"ajax/personal.ajax.php",
      method: "POST",
      data: $('#formDetalles').serialize(),
      cache: false,
      success:function(response){
         if (response == 'ok') {
            let mostrarPersonal = new FormData();
            mostrarPersonal.append("funcion", "mostrarPersonal");
            mostrarPersonal.append('idPersonal', idPersonal);
            mostrarDatosPersonal(mostrarPersonal);
            $("#modalDetalles").modal("hide");
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
/* evento que muestra los locales de una sede */
$(document).on('change', '#cmbSedeCurso', function(e){
   $(this).find("option[value='']").remove();
   let idSede = $(this).val();
   let datos = new FormData();
   datos.append('funcion', 'mostrarLocales');
   datos.append('idSede', idSede);
   mostrarLocalesAulas(datos, 'cmbLocalCurso', 'cmbCarreraCurso');
   $('#cmbSeccionCurso').html('');
   $('#cmbSeccionCurso').prepend($("<option>", {value: "",text: "Seleccionar sección", selected: "selected"}));
   $('#cmbCicloCurso').html('');
   $('#cmbCicloCurso').prepend($("<option>", {value: "",text: "Seleccionar ciclo", selected: "selected"}));
   $('#cmbSeccionCurso').html('');
   $('#cmbSeccionCurso').prepend($("<option>", {value: "",text: "Seleccionar sección", selected: "selected"}));
   $("#listaCursos").html('');
});
/* evento que muestra las carreas que hay en un local */
$(document).on("change", "#cmbLocalCurso", function(e){
   $(this).find("option[value='']").remove();
   let idLocal = $(this).val();
   let datos = new FormData();
   datos.append('funcion', 'mostrarCarrerasLocalActivo');
   datos.append('idLocal', idLocal);
   mostrarCarrerasAulas(datos, 'cmbCarreraCurso');
   $('#cmbCicloCurso').html('');
   $('#cmbCicloCurso').prepend($("<option>", {value: "",text: "Seleccionar ciclo", selected: "selected"}));
   $('#cmbSeccionCurso').html('');
   $('#cmbSeccionCurso').prepend($("<option>", {value: "",text: "Seleccionar sección", selected: "selected"}));
   $("#listaCursos").html('');
});
/* evento que muestra las secciones */
$(document).on("change", "#cmbCarreraCurso", function(e){
   $(this).find("option[value='']").remove();
   let idLocalCarrera = $(this).val();
   let datos = new FormData();
   datos.append('funcion', 'mostrarCiclos');
   datos.append('idLocalCarrera', idLocalCarrera);
   mostrarCiclo(datos, 'cmbCicloCurso');
   $('#cmbSeccionCurso').html('');
   $('#cmbSeccionCurso').prepend($("<option>", {value: "",text: "Seleccionar sección", selected: "selected"}));
   $("#listaCursos").html('');
});
/* evento que muestra las secciones */
$(document).on("change", "#cmbCicloCurso", function(e){
   $(this).find("option[value='']").remove();
   let idCiclo = $(this).val();
   let idLocalCarrera = $("#cmbCarreraCurso").val();
   let datos = new FormData();
   datos.append('funcion', 'mostrarSecciones');
   datos.append('idLocalCarrera', idLocalCarrera);
   datos.append('idCiclo', idCiclo);
   mostrarSecciones(datos, 'cmbSeccionCurso');
   $('#cmbSeccionCurso').html('');
   $('#cmbSeccionCurso').prepend($("<option>", {value: "",text: "Seleccionar sección", selected: "selected"}));
   $("#listaCursos").html('');
});
/* evento para mostrar los cursos de una sección */
$(document).on("change", "#cmbSeccionCurso", function(e){
   $(this).find("option[value='']").remove();
   let template = '';
   let idSeccion = $(this).val();
   let datos = new FormData();
   datos.append('funcion', 'mostrarCursosAula');
   datos.append('idAula', idSeccion);
   $("#listaCursos").html('');
   $.ajax({
      url:"ajax/cursoaula.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success:function(response){
         let cont = 1;
         response.forEach(valor => {
            if (valor['idPersonalHor'] == null || valor['idPersonalHor'] == '') {
               template += `
                  <li class="list-group-item">
                     <div class="icheck-danger d-inline">
                       <input type="checkbox" id="checkbox${cont}" name="checkbox${cont}" value="${valor['idHorarioCurso']}">
                       <label for="checkbox${cont}">${valor['nombreCurso']}</label>
                     </div>
                  </li>
               `;  
               cont++;
            }
         });
         if (template == '') {
            template = '<div class="w-100 text-center"><span class="badge badge-info">SIN RESULTADOS</span></div>';
         }
         $("#listaCursos").html(template);
      }
   }); 
});

$(document).on("change", "#formReistrarCurso :checkbox", function(e){
    if (this.checked) {
      icheck++;
      if (icheck > 0) {
         $('#btnGuardar').prop('disabled', false);
       }
    }else{
      icheck--;
      if (icheck == 0) {
         $('#btnGuardar').prop('disabled', true);
       }
    }

});

$(document).on("click", "#btnRegistrarCurso", function(e){
   $("#listaCursos").html('');
   icheck = 0;
   mostrarSelectCmb("cmbSedeCurso", "Seleccione una sede");
   mostrarSelectCmb("cmbLocalCurso", "Seleccione un local");
   mostrarSelectCmb("cmbCarreraCurso", "Seleccione una especialidad");
   mostrarSelectCmb("cmbCicloCurso", "selecionar ciclo");
   mostrarSelectCmb("cmbSeccionCurso", "Seleccionar sección");
   $("#formReistrarCurso")[0].reset();
})

$('#formReistrarCurso').submit(event=>{
   $.ajax({
      url:"ajax/cursoaula.ajax.php",
      method: "POST",
      data: $('#formReistrarCurso').serialize(),
      cache: false,
      success:function(response){
         if (response == 'ok') {
            $("#modalRegistrarCurso").modal("hide");
               mensaje('¡CORRECTO!', 'La acción se realizó con exito.' , 'success');
               let mostrarCursos = new FormData();
               mostrarCursos.append("funcion", "mostrarCursosDocente");
               mostrarCursos.append("idPersonal", idPersonalGlobal);
               buscarEnTabla('tablaCursos', 'cursoaula.ajax.php', mostrarCursos, 10);
         }else{
            mensaje('¡ERROR!', '¡Ah ocurrido un error al realizar la acción! Comuniquese con el administrador de inmediato.' , 'error');
         }
      }
   });
   event.preventDefault();
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
            minTime = '13:30';
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


$('#form1, #form2, #form3, #form4, #form5, #form6').submit(event=>{
   let elemento = event.target;
   let inputDia = $(elemento).find("input[name='diaId']");   
   let dia = $(inputDia).val();
   let totalHoras = $('#totalHoras').html();
   $.ajax({
      url:"ajax/cursohorario.ajax.php",
      method: "POST",
      data: $(elemento).serialize(),
      cache: false,
      success:function(response){
         if (response > 0) {
            $("#horasCurso"+dia).html(response);
            $('#totalHoras').html(Number(totalHoras) + Number(response));
            alertaMensaje1('top-right', 'success', '¡Se agrego con exito!');
         }else if(response <= 0){
            $("#horasCurso"+dia).html('-');
            $('#totalHoras').html(Number(totalHoras) + Number(response));
            alertaMensaje1('top-right', 'success', '¡Se elimnó el registro!');
         }else if(response == 'novalido'){
            alertaMensaje1('top-right', 'warning', '¡El horario ingresado ya se encuentra registrado!');
         }else if (response == 'vacio') {
            alertaMensaje1('top-right', 'warning', '¡No se registro datos!');
         }else{
            alertaMensaje1('top-right', 'error', '¡Ocurrio un error, comuniquese con el administrador!');
         }
      }
   });
   
   event.preventDefault();
});

$(document).on("click", ".btnEliminarCurso", function(e){
   let idHorarioCurso = $(this).attr('idHorarioCurso');
   swal({
      title: "¿Está seguro de quitar el curso?",
      text: "¡Sí no lo está, puede cancelar la acción! Se eliminará el horario del curso",
      type: "warning",
      showCancelButton: true,
      cancelButtonText: "¡Cancelar!",
      focusCancel: true,
      confirmButtonText: "Sí, Eliminar",
   }).then(function(result){
      if (result.value) {
         let datos = new FormData();
         datos.append('funcion', 'eliminarDocenteCurso');
         datos.append('idHorarioCurso', idHorarioCurso);
         $.ajax({
            url:"ajax/cursoaula.ajax.php",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            success:function(response){
               if (response == 'ok') {
                  let mostrarCursos = new FormData();
                  mostrarCursos.append("funcion", "mostrarCursosDocente");
                  mostrarCursos.append("idPersonal", idPersonalGlobal);
                  buscarEnTabla('tablaCursos', 'cursoaula.ajax.php', mostrarCursos, 10);
                  alertaMensaje1('top-right', 'success', '¡Se elimnó el curso y horario!');
               }else if (response == 'no') {
                  alertaMensaje1('top-right', 'warning', '¡No se realizó la acción!');
               }else{
                  mensaje('¡ERROR!', '¡Ah ocurrido un error al realizar la acción! Comuniquese con el administrador de inmediato.' , 'error');
               }
            }
         });
      }
   });
});

$(document).on("click", "#btnCalcularHoras", function(e){
   let datos = new FormData();
   datos.append('funcion', 'calcularHoras');
   datos.append('idPersonal', idPersonalGlobal);
   swal({
      title: "¿Deseas calcular las horas actuales?",
      showConfirmButton: true,
      confirmButtonText: "Sí, calcular",
      showLoaderOnConfirm: true,
      preConfirm: (respuesta) => {
         return fetch('ajax/cursohorario.ajax.php',{
            method: 'POST',
            body:   datos
         })
            .then(res => res.json());
      }
   }).then(function(result){
      if (result.value.ok > 0) {
         $('#horasMes').html(result.value.ok);
         alertaMensaje1('top-right', 'success', 'Las horas se calcularon correctamente')
      }else{
         alertaMensaje1('top-right', 'error', '¡Ocurrio un error!')
      }
   });;

});

function mostrarDatosPersonal(datos){
   $.ajax({
      url:"ajax/personal.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success:function(response){
         $('#nombrePersona').html(response['apellidoPaternoPersona']+' '+response['apellidoMaternoPersona']+', '+ response['nombresPersona']+' ('+response['dniPersona']+')');
         $('#profesioPersona').html(response['profesionPersonal']);
         $('#dniPersona').html(response['dniPersona']);
         $('#correoPersona').html(response['correoPersonal']);
         let cont = response['celularPersonal'].length;
         let celular = '';
         for (let i = 0; i < cont; i++) {
            celular += response['celularPersonal'][i]+', ';
         }
         $('#celularPersona').html(celular.substring(0, celular.length-2));
         $('#direccionPersona').html(response['direccionPersonal']);
         $('#bancoPersona').html(response['bancoPersonal']);
         $('#cuentaPersona').html(response['numCuentaPersonal']);
         let tipo = 'HORAS';
         if (response['tipoPago'] == 1) {
            tipo = 'MENSUAL';
         }
         $('#tipoPago').html(tipo);
         $('#montoPago').html("S/. "+response['montoPago']);
      }
   }); 
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

function mostrarHorarios(elemento, datos){
   let template = '';
   $.ajax({
      url:"ajax/personal.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success:function(response){
         if(response != 'no'){
            let contador= 1;
            let template = '';
            response.forEach(valor => {

               template +=  `<tr>
                                 <td style="max-width:75px">${valor['rangoHora']}</td>
                                 <td style="max-width:30px">${contador}</td>
                                 <td style="margin: 0px; padding:0px; max-width:140px;">${valor['dia1']}</td>
                                 <td style="margin: 0px; padding:0px; max-width:140px;">${valor['dia2']}</td>
                                 <td style="margin: 0px; padding:0px; max-width:140px;">${valor['dia3']}</td>
                                 <td style="margin: 0px; padding:0px; max-width:140px;">${valor['dia4']}</td>
                                 <td style="margin: 0px; padding:0px; max-width:140px;">${valor['dia5']}</td>
                                 <td style="margin: 0px; padding:0px; max-width:140px;">${valor['dia6']}</td>
                              </tr>`;
               contador++;
            });
            $(elemento).html(template);
         }else{
            $(elemento).html('');
         }
      }
   }); 
}

function mostrarHistorial(datos){
   $.ajax({
      url:"ajax/cursohorario.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success:function(response){
         if (response.template == '') {
            $("#historialHoras").html(0);
         }else{
            $("#historialHoras").html(response.template);
         }
         $('.page-year').html(response.year);
         if (idActivo != '') {
            $("#"+idActivo).removeClass('active');
            idActivo = 'mes'+response.mes;
            $("#"+idActivo).addClass('active');
         }else{
            idActivo = 'mes'+response.mes;
            $("#"+idActivo).addClass('active');
         }
      }
   });
}