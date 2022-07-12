var icheck = 0;
$(document).ready(function(){
   var queryString = window.location.search;
   var urlParams = new URLSearchParams(queryString);
   $('.select2').select2();
   activarLinkMenu("persona", "#registrar");
   let idPersonal = urlParams.get('idPersonal');
   let mostrarCursos = new FormData();
   mostrarCursos.append("funcion", "mostrarCursosDocente");
   mostrarCursos.append("idPersonal", idPersonal);
   buscarEnTabla('tablaCursos', 'cursoaula.ajax.php', mostrarCursos, 10);
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
            turno = 'MAÑANA';
         }else if(response['turno'] == 'T'){
            turno = 'TARDE'
         }
         template = `${response['nombreSeccion']} (${turno}), ${response['nombreSede']}, ${response['direccion']}`;
         $("#tituloCurso").html(template);
      }
   }); 
   let idhorariocurso = $(this).attr('idhorariocurso');
   let datos1 = new FormData();
   datos1.append('funcion', 'mostrarHoras');
   datos1.append('idhorariocurso', idhorariocurso);
   $.ajax({
      url:"ajax/cursoAula.ajax.php",
      method: "POST",
      data: datos1,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success:function(response){
         if (response.length > 0) {

         }
      }
   }); 
});

var dias = ["lunes", "martes", "miercoles", "jueves", "viernes", "sabado"];
$(document).on("click", ".btnTeoria", function(e){
   let padre = $(this).parent().parent().parent()[0];
   let padre1 = $(this).parent().parent().parent().parent()[0];
   btnNuevoInput = $(padre).find('.btnNuevoInput');
   let diaId = $(btnNuevoInput).attr('dia');
   let cont = $(padre1).find('.d-flex').length;
   let template = `<div class="d-flex mr-2">
                    <div class="mr-1">
                      <input type="time" name="txtEntrada${cont+1}" class="form-control form-control-sm" step="300">
                    </div>
                    <div class="mr-1">
                      <input type="time" name="txtEalida${cont+1}" class="form-control form-control-sm">
                    </div>
                    <div class="mr-1">
                      <button type="button" class="btn btn-light btn-sm btn-outline-danger btnQuitarForm">x</button>
                    </div>
                    <input type="hidden" name="tipo${cont+1}" value="T">
                  </div> `;
   padre.insertAdjacentHTML("beforebegin", template);
});

$(document).on("click", ".btnPractica", function(e){
   let padre = $(this).parent().parent().parent()[0];
   let padre1 = $(this).parent().parent().parent().parent()[0];
   btnNuevoInput = $(padre).find('.btnNuevoInput');
   let diaId = $(btnNuevoInput).attr('dia');
   let cont = $(padre1).find('.d-flex').length;
   let template = `<div class="d-flex mr-2">
                    <div class="mr-1">
                      <input type="time" name="txtEntrada${cont+1}" class="form-control form-control-sm">
                    </div>
                    <div class="mr-1">
                      <input type="time" name="txtEalida${cont+1}" class="form-control form-control-sm">
                    </div>
                    <div class="mr-1">
                      <button type="button" class="btn btn-light btn-sm btn-outline-danger btnQuitarForm">x</button>
                    </div>
                    <input type="hidden" name="tipo${cont+1}" value="P">
                  </div> `;
   padre.insertAdjacentHTML("beforebegin", template);
});

$(document).on("click", ".btnQuitarForm", function(e){
   let padre = $(this).parent().parent();
   $(padre).remove();
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