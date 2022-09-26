var icheck = 0;
var idSedeGlobal = '';

$(document).ready(function(){
      $("[href='subsanaciones']").addClass('active');
      $(".select2").select2()
      let mostrarSubsanaciones = new FormData();
      mostrarSubsanaciones.append("funcion", "mostrarCursosAlumnos");
      buscarEnTabla('tablaSubsanacion', 'alumno.ajax.php', mostrarSubsanaciones, 50);
});

$(document).on('change', '#cmbSedes', function(e){
   $(this).find("option[value='']").remove();
   idSedeGlobal = $(this).val();
   $("#btnGenerarExcel").attr("href", 'excel?idSede='+idSedeGlobal);
   console.log("idSedeGlobal", idSedeGlobal);
   let mostrarSubsanaciones = new FormData();
   mostrarSubsanaciones.append("funcion", "mostrarCursosAlumnos");
   mostrarSubsanaciones.append('idSede', idSedeGlobal)
   buscarEnTabla('tablaSubsanacion', 'alumno.ajax.php', mostrarSubsanaciones, 50);
});

$(document).on("click", "#btnBuscarDni", function(e){
   let dniUsuario = $("input[name='txtDniUsuario']").val().trim();
   let dato = /^\d*$/.test(dniUsuario);
   let datos = new FormData();
   datos.append('funcion', 'buscarDni');
   datos.append('dni', dniUsuario);
   buscarDniUsuario(datos, dniUsuario, dato);
});

$(document).on("keypress", "input[name='txtDniUsuario']", function(e){
    if (event.keyCode === 13) {
      let dniUsuario = $(this).val().trim();
      let dato = /^\d*$/.test($(this).val());
      let datos = new FormData();
      datos.append('funcion', 'buscarDni');
      datos.append('dni', dniUsuario);
      buscarDniUsuario(datos, dniUsuario, dato);
   }
});

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
            template += `
               <li class="list-group-item">
                  <div class="icheck-danger d-inline">
                    <input type="checkbox" id="checkbox${cont}" name="checkbox${cont}" value="${valor['idCursoHor']}">
                    <label for="checkbox${cont}">${valor['nombreCurso']}</label>
                  </div>
               </li>
            `;  
            cont++;
            
         });
         if (template == '') {
            template = '<div class="w-100 text-center"><span class="badge badge-info">SIN RESULTADOS</span></div>';
         }
         $("#listaCursos").html(template);
      }
   }); 
});

$(document).on("change", "#formRegistrarSubsanacion :checkbox", function(e){
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

$(document).on("click", "#btnRegistrarSubsanacion", function(e){
   $("#listaCursos").html('');
   icheck = 0;
   mostrarSelectCmb("cmbSedeCurso", "Seleccione una sede");
   mostrarSelectCmb("cmbLocalCurso", "Seleccione un local");
   mostrarSelectCmb("cmbCarreraCurso", "Seleccione una especialidad");
   mostrarSelectCmb("cmbCicloCurso", "selecionar ciclo");
   mostrarSelectCmb("cmbSeccionCurso", "Seleccionar sección");
   $("#formRegistrarSubsanacion")[0].reset();
   $("input[name='txtDniUsuario']").focus();
});

$('#formRegistrarSubsanacion').submit(event=>{
   if ($("input[name='txtDniUsuario']").val().length < 8) {
      alertaMensaje1('top-right', 'warning', '¡El DNI debe contener 8 caracteres!');
   }else{
      $.ajax({
         url:"ajax/alumno.ajax.php",
         method: "POST",
         data: $('#formRegistrarSubsanacion').serialize(),
         cache: false,
         success:function(response){
            if (response == 'ok') {
               $("#modalRegistroSubsanacion").modal("hide");
               let mostrarSubsanaciones = new FormData();
               mostrarSubsanaciones.append("funcion", "mostrarCursosAlumnos");
               mostrarSubsanaciones.append('idSede', idSedeGlobal)
               buscarEnTabla('tablaSubsanacion', 'alumno.ajax.php', mostrarSubsanaciones, 50);
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
   }
   event.preventDefault();
});

$(document).on('click', '.btnEliminar', function(e){
   let idSubsanacion = $(this).attr('idSubsanacion');
   let datos = new FormData();
   datos.append('funcion', 'editarCampoSubsanar');
   datos.append('idSubsanacion', idSubsanacion);
   datos.append('estado', 0);
   cambiarEstado(datos, "borrar el registro");
});

$(document).on('click', '.btnOk', function(e){
   let idSubsanacion = $(this).attr('idSubsanacion');
   let datos = new FormData();
   datos.append('funcion', 'editarProcesar');
   datos.append('idSubsanacion', idSubsanacion);
   datos.append('estado', 0);
   cambiarEstado(datos, "borrar el registro");
});

$(document).on('click', '.btnAprobar', function(e){
   let idSubsanacion = $(this).attr('idSubsanacion');
   let datos = new FormData();
   datos.append('funcion', 'editarCampoSubsanar');
   datos.append('idSubsanacion', idSubsanacion);
   datos.append('estado', 2);
   cambiarEstado(datos, "aprobar al alumno");
});

$(document).on('click', '.btnDesaprobar', function(e){
   let idSubsanacion = $(this).attr('idSubsanacion');
   let datos = new FormData();
   datos.append('funcion', 'editarCampoSubsanar');
   datos.append('idSubsanacion', idSubsanacion);
   datos.append('estado', 3);
   cambiarEstado(datos, "desaprobar al alumno");
});

function buscarDniUsuario(datos, dni, dato){
   if(dni.length == 8 && dato){
      $.ajax({
         url:"ajax/alumno.ajax.php",
         method: "POST",
         data: datos,
         cache: false,
         contentType: false,
         processData: false,
         dataType: "json",
         success:function(response){
            if(response['valor'] && response['valor'] == 'no'){
               $("input[name='txtApellidoPaterno']").val('');
               $("input[name='txtApellidoMaterno']").val('');
               $("input[name='txtNombres']").val('');
               $('input[name="txtApellidoPaterno"]').focus();
               $("input[name='txtApellidoPaterno']").removeAttr('readonly');
               $("input[name='txtApellidoMaterno']").removeAttr('readonly');
               $("input[name='txtNombres']").removeAttr('readonly');
               alertaMensaje1('top-right', 'warning', '¡No se encontró resultado!');
            }else if(response['valor'] && response['valor'] == 'existe'){
               $("input[name='txtApellidoPaterno']").val('');
               $("input[name='txtApellidoMaterno']").val('');
               $("input[name='txtNombres']").val('');
               alertaMensaje1('top-right', 'warning', '¡El usuario ya se encuentra registrado!');
            }else if (response['paterno']) {
               $("input[name='txtApellidoPaterno']").val(response['paterno']);
               $("input[name='txtApellidoMaterno']").val(response['materno']);
               $("input[name='txtNombres']").val(response['nombres']);
               $("input[name='txtApellidoPaterno']").prop('readonly', true);
               $("input[name='txtApellidoMaterno']").prop('readonly', true);
               $("input[name='txtNombres']").prop('readonly', true);
            }else{
               alertaMensaje1('top-right', 'error', '¡Hubó un error al realizar la busqueda!');
            }
         }
      }); 
   }else{
      alertaMensaje1('top-right', 'warning', '¡Dato invalido!');
   }     
}

function cambiarEstado(datos, texto){
   swal({
      title: "¿Está seguro de "+texto+"?",
      text: "¡Sí no lo está, puede cancelar la acción!",
      type: "warning",
      showCancelButton: true,
      cancelButtonText: "¡Cancelar!",
      focusCancel: true,
      confirmButtonText: "Sí",
   }).then(function(result){
      if (result.value) {         
         $.ajax({
            url:"ajax/alumno.ajax.php",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            success:function(response){
               if (response == 'ok') {
                  let mostrarSubsanaciones = new FormData();
                  mostrarSubsanaciones.append("funcion", "mostrarCursosAlumnos");
                  mostrarSubsanaciones.append('idSede', idSedeGlobal)
                  buscarEnTabla('tablaSubsanacion', 'alumno.ajax.php', mostrarSubsanaciones, 50);
               }else{
                  mensaje('¡ERROR!', '¡Ah ocurrido un error al realizar la acción! Comuniquese con el administrador de inmediato.' , 'error');
               }
            }
         });
      }
   });
}