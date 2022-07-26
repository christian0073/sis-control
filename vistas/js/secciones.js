$(document).ready(function(){
   activarLinkMenu("secciones", "#ajustes");
   $('.select2').select2();
   mostrarDataTable('tablaAula', 'tabla-aulas.ajax.php');
});

$(document).on('click', '#btnAgregarAula', function(e) {
   mostrarSelectCmb("cmbSedeAula", "Seleccione una sede");
   mostrarSelectCmb("cmbEspecialidadAula", "Seleccione una especialidad");
   mostrarSelectCmb("cmbLocalesAula", "Seleccione un local");
   mostrarSelectCmb("cmbTurnoAula", "Elejir");
   mostrarSelectCmb("cmbCicloAula", "Elejir");
   $("#formRegistrarAula")[0].reset();
});

$(document).on("change", "#cmbSedeAula", function(e){
   $(this).find("option[value='']").remove();
   let idSede = $(this).val();
   let datos = new FormData();
   datos.append('funcion', 'mostrarLocales');
   datos.append('idSede', idSede);
   mostrarLocalesAulas(datos, 'cmbLocalesAula', 'cmbEspecialidadAula');
});

$(document).on("change", "#cmbLocalesAula", function(e){
   $(this).find("option[value='']").remove();
   let idLocal = $(this).val();
   let datos = new FormData();
   datos.append('funcion', 'mostrarCarrerasLocalActivo');
   datos.append('idLocal', idLocal);
   mostrarCarrerasAulas(datos, 'cmbEspecialidadAula');
});

$(document).on("change", "#cmbEspecialidadAula", function(e){
   $(this).find("option[value='']").remove();
});

$(document).on("change", "#cmbTurnoAula", function(e){
   $(this).find("option[value='']").remove();
});

$(document).on("change", "#cmbCicloAula", function(e){
   $(this).find("option[value='']").remove();
});


$('#formRegistrarAula').submit(event=>{
   $.ajax({
      url:"ajax/aula.ajax.php",
      method: "POST",
      data: $('#formRegistrarAula').serialize(),
      cache: false,
      success:function(response){
         if (response == 'ok') {
            buscarEnTabla('tablaAula', 'tabla-aulas.ajax.php', '', 10);
            mostrarSelectCmb("cmbPeriodoAula", "Seleccionar un periodo");
            $('#cmbPeriodoAula').select2("val", "");
            $("#modalRegistrarAula").modal("hide");
            mensaje('¡CORRECTO!', 'El aula se registró con exito.' , 'success');
         }else if(response == 'existe'){
            mensaje('¡ADVERTENCIA!', '¡El nombre del aula ya existe!', 'warning');
         }else if(response == 'no'){
            mensaje('¡CORREGIR!', '¡no se permite caracteres especiales!', 'warning');
         }else{
            mensaje('¡ERROR!', '¡Ah ocurrido un error al realizar la acción! Comuniquese con el administrador de inmediato.' , 'error');
         }
      }
   });
   event.preventDefault();
});

$(document).on("change", "#cmbPeriodoAula", function(e){
   $(this).find("option[value='']").remove();
   let idPeriodoAula = $(this).val();
   let datos = new FormData();
   datos.append("funcion", "mostrarAulasPeriodo");
   datos.append("idPeriodo", idPeriodoAula);
   buscarEnTabla('tablaAula', 'tabla-aulas.ajax.php', datos, 10);
   mostrarSelectCmb("cmbSedeAulas", "Seleccionar una sede");
   $('#cmbSedeAulas').select2("val", "");
   $('#cmbLocalesAulas').prop('disabled', true);
   mostrarSelectCmb("cmbLocalesAulas", "Seleccionar una sede");
   $('#cmbLocalesAulas').select2("val", "");
   $('#cmbCarrerasAulas').prop('disabled', true);
   mostrarSelectCmb("cmbCarrerasAulas", "Seleccionar una sede");
   $('#cmbCarrerasAulas').select2("val", "");
});

$(document).on("change", "#cmbSedeAulas", function(e){
   $(this).find("option[value='']").remove();
   let idSedeAula = $(this).val();
   let idPeriodoAula = $("#cmbPeriodoAula").val();
   let datos1 = new FormData();
   datos1.append('funcion', 'mostrarLocales');
   datos1.append('idSede', idSedeAula);
   mostrarLocalesAulas(datos1, 'cmbLocalesAulas', 'cmbCarrerasAulas');
   $('#cmbLocalesAulas').prop('disabled', false);
   let datos = new FormData();
   datos.append("funcion", "mostrarAulasSede");
   datos.append("idSede", idSedeAula);
   datos.append("idPeriodo", idPeriodoAula);
   buscarEnTabla('tablaAula', 'tabla-aulas.ajax.php', datos, 10);
});

$(document).on("change", "#cmbLocalesAulas", function(e){
   $(this).find("option[value='']").remove();
   let idLocal = $(this).val();
   let datos = new FormData();
   datos.append('funcion', 'mostrarCarrerasLocalActivo');
   datos.append('idLocal', idLocal);
   mostrarCarrerasAulas(datos, 'cmbCarrerasAulas');
   $('#cmbCarrerasAulas').prop('disabled', false);
});

$(document).on("change", "#cmbCarrerasAulas", function(e){
   $(this).find("option[value='']").remove();
});

/* evento que realizará una busqueda de las aulas */
$(document).on("click", "#btnBuscarAula", function(e){
   let idPeriodoAula = $("#cmbPeriodoAula").val();
   let idSedeAula = $("#cmbSedeAulas").val();
   let idLocalAula = $("#cmbLocalesAulas").val();
   let idCarreraAula = $("#cmbCarrerasAulas").val();
   if(idLocalAula == '' || idCarreraAula == '' || idSedeAula == ''){
      alertaMensaje1('top-right', 'warning', 'No es posible realizar la busqueda');
   }else{
      let datos = new FormData();
      datos.append('idPeriodo', idPeriodoAula);
      datos.append('idSede', idSedeAula);
      datos.append('idCarrera', idCarreraAula);
      datos.append("funcion", 'mostrarAulasTodo');
      buscarEnTabla('tablaAula', 'tabla-aulas.ajax.php', datos, 10);
   }
})

/* traer los datos de una aula */
$(document).on("click", ".editarAula", function(e){
   $("#formEditarAula")[0].reset();
   $('input[name="txtAula"]').focus();
   let idAula = $(this).attr('idAula');
   let datos = new FormData();
   datos.append('funcion', 'verAula');
   datos.append('idAula', idAula);
   $.ajax({
      url:"ajax/aula.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success:function(response){
         $('input[name="txtPeriodoAula"]').val(response['nombrePeriodo']);
         $('input[name="txtLocalAula"]').val(response['direccion']);
         $('input[name="txtCarreraAula"]').val(response['nombreCarrera']);
         $('input[name="txtAula"]').val(response['nombreSeccion']);
         $('input[name="idAula"]').val(response['idSeccion']);
         $('input[name="idPeriodoAula"]').val(response['idPeriodoSeccion']);
         $('input[name="idLocalidadAula"]').val(response['idSeccionLocal']);
         $('#cmbTurno').val(response['turno']);
         $('#cmbCiclo').val(response['cicloSeccion']);
      }
   });  
});

$('#formEditarAula').submit(event=>{
   $.ajax({
      url:"ajax/aula.ajax.php",
      method: "POST",
      data: $('#formEditarAula').serialize(),
      cache: false,
      success:function(response){
         if (response == 'ok') {
            let idPeriodoAula = $("#cmbPeriodoAula").val();
            let idSedeAula = $("#cmbSedeAulas").val();
            let idLocalAula = $("#cmbLocalesAulas").val();
            let idCarreraAula = $("#cmbCarrerasAulas").val();
            let datos = new FormData();
            if (idCarreraAula != '') {
               datos.append('idCarrera', idCarreraAula);
               datos.append('idPeriodo', idPeriodoAula);
               datos.append('funcion', 'mostrarAulasTodo');  
            }else if(idSedeAula != ''){
               datos.append('idSede', idSedeAula);
               datos.append('idPeriodo', idPeriodoAula);
               datos.append('funcion', 'mostrarAulasSede');
            }else if(idPeriodoAula != ''){
               datos.append('idPeriodo', idPeriodoAula);
               datos.append('funcion', 'mostrarAulasPeriodo');
            }
            buscarEnTabla('tablaAula', 'tabla-aulas.ajax.php', datos, 10);
            $("#modalEditarAula").modal("hide");
            mensaje('¡CORRECTO!', 'El aula se editó con exito.' , 'success');
         }else if(response == 'existe'){
            mensaje('¡ADVERTENCIA!', '¡El nombre del aula ya existe!', 'warning');
         }else if(response == 'no'){
            mensaje('¡CORREGIR!', '¡no se permite caracteres especiales!', 'warning');
         }else{
            mensaje('¡ERROR!', '¡Ah ocurrido un error al realizar la acción! Comuniquese con el administrador de inmediato.' , 'error');
         }
      }
   });
   event.preventDefault();
});

$(document).on("click", ".btnVerCursos", function(e){
   let idAula = $(this).attr('idAula');
   let datos = new FormData();
   let template = '';
   datos.append('funcion', 'mostrarCursosAula');
   datos.append('idAula', idAula);
   $.ajax({
      url:"ajax/cursoaula.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success:function(response){
         console.log("response", response);
         response.forEach(valor => {
            template += `
               <li class="list-group-item d-flex justify-content-between align-items-center">
                  ${valor['nombreCurso']}
                  <span class="badge bg-primary rounded-2">${valor['codigo']}</span>
               </li>
            `;
         });
         $("#listaCursos").html(template);
      }
   });  
});

$(document).on("click", ".desactivarCurso", function(e){
   let idAula = $(this).attr('idAula');
   let nombreAula = $(this).attr('nombre');
   swal({
      title: "¿Está seguro de desactivar el aula "+nombreAula+"?",
      text: "¡Sí no lo está, puede cancelar la acción!",
      type: "warning",
      showCancelButton: true,
      cancelButtonText: "¡Cancelar!",
      focusCancel: true,
      confirmButtonText: "Sí, Eliminar",
   }).then(function(result){
      if (result.value) {
         let datos = new FormData();
         datos.append('funcion', 'editarCampoAula');
         datos.append('idAula', idAula);
         $.ajax({
            url:"ajax/aula.ajax.php",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            success:function(response){
               if (response == 'ok') {
                  let idPeriodoAula = $("#cmbPeriodoAula").val();
                  let idSedeAula = $("#cmbSedeAulas").val();
                  let idLocalAula = $("#cmbLocalesAulas").val();
                  let idCarreraAula = $("#cmbCarrerasAulas").val();
                  let datos = new FormData();
                  if (idCarreraAula != '') {
                     datos.append('idCarrera', idCarreraAula);
                     datos.append('idPeriodo', idPeriodoAula);
                     datos.append('funcion', 'mostrarAulasTodo');  
                  }else if(idSedeAula != ''){
                     datos.append('idSede', idSedeAula);
                     datos.append('idPeriodo', idPeriodoAula);
                     datos.append('funcion', 'mostrarAulasSede');
                  }else if(idPeriodoAula != ''){
                     datos.append('idPeriodo', idPeriodoAula);
                     datos.append('funcion', 'mostrarAulasPeriodo');
                  }
                  buscarEnTabla('tablaAula', 'tabla-aulas.ajax.php', datos, 10);
               }else{
                  mensaje('¡ERROR!', '¡Ah ocurrido un error al realizar la acción! Comuniquese con el administrador de inmediato.' , 'error');
               }
            }
         });
      }
   });
});