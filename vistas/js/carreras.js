$(document).ready(function(){
   var idCarreraCurso = 0;
   mostrarCarreras();
   $('.select2').select2();
   activarLinkMenu("carreras", "#ajustes");
});

$(document).on('click', '#btnAgregarCarrera', function(e) {
   $("#formRegistrarCarrera")[0].reset();
   $('input[name="txtNombreCarrera"]').focus();
   $("#tituloCarrera").html("Agregar nueva carrera");
   $('#formRegistrarCarrera input[name="funcion"]').val("registrarCarrera");
});

$(document).on('keypress', 'input[name="txtNombreCarrera"], input[name="txtNombreCurso"]', function(e) {
   $input = $(this);
   convertMayus($input);
});

$('#formRegistrarCarrera').submit(event=>{
   $.ajax({
      url:"ajax/carrera.ajax.php",
      method: "POST",
      data: $('#formRegistrarCarrera').serialize(),
      cache: false,
      success:function(response){
         if (response == 'ok') {
            mostrarCarreras();
            $("#modalRegistrarCarrera").modal("hide");
            mensaje('¡CORRECTO!', 'La acción se realizó con exito.' , 'success');
         }else if(response == 'existe'){
            mensaje('¡ADVERTENCIA!', '¡El nombre de la carrera ya se encuentra registrado!', 'warning');
         }else if(response == 'no'){
            mensaje('¡CORREGIR!', '¡no se permite caracteres especiales!', 'warning');
         }else{
            mensaje('¡ERROR!', '¡Ah ocurrido un error al realizar la acción! Comuniquese con el administrador de inmediato.' , 'error');
         }
      }
   });
   event.preventDefault();
});

$(document).on('click', '.btnEditarCarrera', function(e) {
   $("#formRegistrarCarrera")[0].reset();
   $("#tituloCarrera").html("Editar carrera");
   $('input[name="txtNombreCarrera"]').focus();
   $('#formRegistrarCarrera input[name="funcion"]').val("editarCarrera");
   let idCarrera = $(this).attr('idCarrera');
   let datos = new FormData();
   datos.append('funcion', 'verCarrera');
   datos.append('idCarrera', idCarrera);
   $.ajax({
      url:"ajax/carrera.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success:function(response){
         $('input[name="txtNombreCarrera"]').val(response['nombreCarrera']);
         $('input[name="idCarrera"]').val(response['idCarrera']);
      }
   });   
});

$(document).on('click', '.btnAgregarCurso', function(e) {
   let idCarrera = $(this).attr('idCarrera');
   $("#formRegistrarCurso")[0].reset();
   $("#tituloCurso").html("Registrar nuevo curso");
   $('input[name="txtNombreCurso"]').focus();
   $('#formRegistrarCurso input[name="idCarreraCurso"]').val(idCarrera);
   $('#formRegistrarCurso input[name="funcion"]').val("registrarCurso");
   mostrarSelectCmb("cmbPeriodoCurso", "Seleccione una opción");
   $('#cmbPeriodoCurso').select2("val", "");
   mostrarSelectCmb("cmbTipoCurso", "Seleccione una opción");
   $('#cmbTipoCurso').select2("val", "");
});

$(document).on('change', '#cmbPeriodoCurso', function(){
  $(this).find("option[value='']").remove();     
});

$(document).on('change', '#cmbTipoCurso', function(){
  $(this).find("option[value='']").remove();     
});

$('#formRegistrarCurso').submit(event=>{
   idCarreraCurso = $('input[name="idCarreraCurso"]').val();
   $.ajax({
      url:"ajax/curso.ajax.php",
      method: "POST",
      data: $('#formRegistrarCurso').serialize(),
      cache: false,
      success:function(response){
         if (response == 'ok') {
            $("#modalRegistrarCurso").modal("hide");
            //$("#nombreCurso").html($('input[name="txtNombreCurso"]').val());
            let idCarrera = $('input[name="idCarreraCurso"]').val();
            let ciclo = $('#cmbPeriodo').val();
            let datos = new FormData();
            if (ciclo != "") {
               datos.append("funcion", 'mostrarCursosCiclo');
               datos.append("idCarrera", idCarrera);
               datos.append("periodo", ciclo);
            }else{
               datos.append("funcion", 'mostrarCursos');
               datos.append("idCarrera", idCarrera);
               $('#cmbPeriodo').prop('disabled', false);
            }
            buscarEnTabla("tablaCursos", "tabla-cursos.ajax.php", datos, 10);
            mensaje('¡CORRECTO!', 'La acción se realizó con exito.' , 'success');
         }else if(response == 'existe'){
            mensaje('¡ADVERTENCIA!', '¡El código del curso ya se encuentra registrado!', 'warning');
         }else if(response == 'no'){
            mensaje('¡CORREGIR!', '¡no se permite caracteres especiales!', 'warning');
         }else{
            mensaje('¡ERROR!', '¡Ah ocurrido un error al realizar la acción! Comuniquese con el administrador de inmediato.' , 'error');
         }
      }
   });
   event.preventDefault();
});

$(document).on("click", ".btnVerCursos", function(e) {
   let nombreCurso = $(this).attr("nombre");
   let idCarrera = $(this).attr("idCarrera");
   $('#cmbPeriodo').prop('disabled', false);
   idCarreraCurso = idCarrera;
   mostrarSelectCmb("cmbPeriodo", "Seleccione una opción");
   $("#nombreCurso").html(nombreCurso);
   let datos = new FormData();
   datos.append("funcion", 'mostrarCursos');
   datos.append("idCarrera", idCarrera);
   buscarEnTabla("tablaCursos", "tabla-cursos.ajax.php", datos, 10);
});

$(document).on('change', '#cmbPeriodo', function(){
   $(this).find("option[value='']").remove();
   let ciclo = $(this).val();
   let datos = new FormData();
   datos.append("funcion", 'mostrarCursosCiclo');
   datos.append("idCarrera", idCarreraCurso);
   datos.append("periodo", ciclo);
   buscarEnTabla("tablaCursos", "tabla-cursos.ajax.php", datos, 10);
});

$(document).on("click", ".editarCurso", function(e){
   ocultarSelectCmb("cmbPeriodoCurso");
   $('input[name="txtNombreCurso"]').focus();
   let idCurso = $(this).attr('idCurso');
   $("#formRegistrarCurso")[0].reset();
   $("#tituloCurso").html("Editar curso");
   let datos = new FormData();
   datos.append("funcion", "mostrarCurso");
   datos.append('idCurso', idCurso);
   $.ajax({
      url:"ajax/curso.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success:function(response){
         $('#formRegistrarCurso input[name="funcion"]').val("editarCurso");
         $('input[name="idCurso"]').val(response['idCurso']);
         $('input[name="txtNombreCurso"]').val(response['nombreCurso']);
         $('input[name="txtCodigoCurso"]').val(response['codigo']);
         $('input[name="txtCorrelativoCurso"]').val(response['correlativo']);
         $('input[name="txtCreditosCurso"]').val(response['creditosCurso']);
         $('#cmbPeriodoCurso').find("option[value='"+response['periodo']+"']").attr("selected",true);
         $('#cmbPeriodoCurso').select2("val", response['periodo']);
         $('input[name="idCarreraCurso"]').val(response['idCarreraCurso']);
         $('#cmbTipoCurso').find("option[value='"+response['tipo']+"']").attr("selected",true);
         $('#cmbTipoCurso').select2("val", response['tipo']);
      }
   });  
});

/* función para desactivar un curso */
$(document).on("click", ".desactivarCurso", function(e){
   let idCurso = $(this).attr('idCurso');
   let idCarrera = $(this).attr('idCarrera');
   let nombre = $(this).attr("nombre");
   swal({
      title: "¿Está seguro de desactivar el curso de "+nombre+"?",
      text: "¡Sí no lo está, puede cancelar la acción!",
      type: "warning",
      showCancelButton: true,
      cancelButtonText: "¡Cancelar!",
      focusCancel: true,
      confirmButtonText: "Sí, Eliminar",
   }).then(function(result){
      if (result.value) {
         let datos = new FormData();
         datos.append('funcion', 'editarCampo');
         datos.append('idCurso', idCurso);
         $.ajax({
            url:"ajax/curso.ajax.php",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            success:function(response){
               if (response == 'ok') {
                  let ciclo = $('#cmbPeriodo').val();
                  let datos1 = new FormData();
                  if (ciclo != "") {
                     datos1.append("funcion", 'mostrarCursosCiclo');
                     datos1.append("idCarrera", idCarrera);
                     datos1.append("periodo", ciclo);
                  }else{
                     datos1.append("funcion", 'mostrarCursos');
                     datos1.append("idCarrera", idCarrera);
                  }
                  buscarEnTabla("tablaCursos", "tabla-cursos.ajax.php", datos1, 10);
                  mensaje('¡CORRECTO!', 'La filial fue eliminada con exito.' , 'success');
               }else{
                  mensaje('¡ERROR!', '¡Ah ocurrido un error al realizar la acción! Comuniquese con el administrador de inmediato.' , 'error');
               }
            }
         });
      }
   });
});

function mostrarCarreras(){
   let datos = new FormData();
   datos.append('funcion', 'mostrarCarreras');
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
         response.forEach(valor =>{
            template +=`
               <tr>
                  <td>
                     ${valor['nombreCarrera']}
                  </td>
                  <td style="height: 0;"">
                     <div style="height: 100%; display: flex; align-items: center;">
                        <div class="btn-group">
                           <button class="btn btn-primary btn-sm btnAgregarCurso" title="Agregar nuevo curso a la carrera de ${valor['nombreCarrera']}" nombre="${valor['nombreCarrera']}" idCarrera="${valor['idCarrera']}" data-toggle="modal" data-target="#modalRegistrarCurso"><i class="fas fa-add"></i></button>
                           <button class="btn btn-warning btn-sm btnEditarCarrera" title="Editar la carrera de ${valor['nombreCarrera']}" nombre="${valor['nombreCarrera']}" idCarrera="${valor['idCarrera']}" data-toggle="modal" data-target="#modalRegistrarCarrera"><i class="fa-solid fa-pen-to-square"></i></button>
                           <button class="btn btn-info btn-sm btnVerCursos" title="Ver cursos de la carrera de ${valor['nombreCarrera']}" nombre="${valor['nombreCarrera']}" idCarrera="${valor['idCarrera']}"><i class="fa-solid fa-eye"></i></button>
                        </div>
                     </div>
                  </td>
               </tr>
           `;
         });
         $('#tableCarrera').html(template);
      }
   });   
}