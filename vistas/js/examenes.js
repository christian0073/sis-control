var icheck = 0;
var icheckTotal = 0;
$(document).ready(function(){
   //$('.select2').select2();
   cantidadExamenes();
   activarLinkMenu("examenes", "#examenes");
   let mostrarPersonal = new FormData();
   mostrarPersonal.append("funcion", "mostrarListaDocentes")
   buscarEnTabla('tablaDocentes', 'personal.ajax.php', mostrarPersonal, 100);
});


$(document).on("click", ".btnParcial1, .btnParcial2, .btnParcial3, .btnParcial4", function(e){
   icheck = 0;
   let editar = $(this).attr('editar');
   $('input[name="idParcial"]').val('');
   $('input[name="editar"]').val(editar);
   $('input[name="totalCheck"]').val('');
   $('#checkboxTodo').prop('checked', false);
   let idPersonal = $(this).attr('idPersonal');
   let idParcial = $(this).attr('idParcial');
   $('input[name="idParcial"]').val(idParcial);
   let mostrarPersonal = new FormData();
   mostrarPersonal.append("funcion", "mostrarPersonal");
   mostrarPersonal.append('idPersonal', idPersonal);
   $("#nombrePersona").html('');
   $('input[name="idPersonal"]').val(idPersonal);
   $.ajax({
      url:"ajax/personal.ajax.php",
      method: "POST",
      data: mostrarPersonal,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success:function(response){
         $('#nombrePersona').html(response['apellidoPaternoPersona']+' '+response['apellidoMaternoPersona']+', '+ response['nombresPersona']+' ('+response['dniPersona']+')');
      }
   }); 
   let datos1 = new FormData();
   datos1.append('funcion', 'mostrarCursosListaDocente');
   datos1.append('idPersonal', idPersonal);
   datos1.append('editar', editar);
   datos1.append('idParcial', idParcial);
   let template = '';
   $("#listaCursos").html('');
   $.ajax({
      url:"ajax/cursoaula.ajax.php",
      method: "POST",
      data: datos1,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success:function(response){
         let cont = 1;
         response.forEach(valor => {
            let valor1 = 0;
            let activo = "nochecked";
            if (editar == 0) {
               valor1 = valor['idHorarioCurso'];
            }else{
               valor1 = valor['idExamen'];
               if (valor['estadoExamen'] == 1) {
                  activo = "checked";
               }
            }
            template += `
               <li class="list-group-item">
                  <div class="icheck-danger d-inline">
                    <input type="checkbox" id="checkbox${cont}" name="checkbox${cont}" value="${valor1}" ${activo}>
                    <label for="checkbox${cont}">${valor['nombreCurso']} - ${valor['nombreCarrera']} - ${valor['nombreSeccion']}</label>
                  </div>
               </li>
            `;  
            cont++;
         });
         if (template == '') {
            template = '<div class="w-100 text-center"><span class="badge badge-info">SIN RESULTADOS</span></div>';
         }
         $("#listaCursos").html(template);
         icheckTotal = $("#listaCursos :checkbox").length;
         $('input[name="totalCheck"]').val(icheckTotal);
      }
   }); 
});

$(document).on("change", "#checkboxTodo", function(e){
   icheckTotal = $("#listaCursos :checkbox").length;
   icheck = icheckTotal;
   $("#listaCursos :checkbox").prop('checked', $(this).prop("checked"));
});

$(document).on("change", "#listaCursos :checkbox", function(e){
   if ((this).checked) {
      icheck++;
      if (icheck == icheckTotal) {
         $('#checkboxTodo').prop('checked', true);
      }
   }else{
      icheck--;
      if (icheck < icheckTotal) {
         $('#checkboxTodo').prop('checked', false);
      }
   }
});

$("#formRegistrarExamen").submit(event=>{
   $.ajax({
      url:"ajax/examenes.ajax.php",
      method: "POST",
      data: $('#formRegistrarExamen').serialize(),
      cache: false,
      success:function(response){
         if (response == 'ok') {
            $("#modalParcial").modal("hide");
            cantidadExamenes();
            let mostrarPersonal = new FormData();
            mostrarPersonal.append("funcion", "mostrarListaDocentes")
            buscarEnTabla('tablaDocentes', 'personal.ajax.php', mostrarPersonal, 100);
            mensaje('¡CORRECTO!', 'Los examenes fueron registrados con exito.' , 'success');
         }else if(response == 'no'){
            alertaMensaje1('top-right', 'warning', 'El docente no registra examenes');
         }else if (response == 'novalido') {
            mensaje('¡ADVERTENCIA!', 'No se realizo el registro de examenes.' , 'warning');
         }else{
            mensaje('¡ERROR!', 'Comuniquese con el administrador.' , 'error');
         }
      }
   });
   event.preventDefault();
});

function cantidadExamenes(){
   let datos = new FormData();
   datos.append("funcion", "cantidadExamenes");
   $.ajax({
      url:"ajax/examenes.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success:function(response){
         let cant = response.length;
         for (var i = 1; i < cant; i++) {
            $("#parcial"+i).html(response[i]);
         }
      }
   }); 
}