$(document).ready(function(){
   activarLinkMenu("corregir", "#control");
   $('.select2').select2();
});

$(document).on('change', '#cmbDocentes', function(e){
   $(this).find("option[value='']").remove();
});

$(document).on('change', '#cmbSedes', function(e){
   $(this).find("option[value='']").remove();
   validarCmb();
});

$(document).on('change', '#cmbCarreras', function(e){
   $(this).find("option[value='']").remove();
   validarCmb();
});

$(document).on('change', '#cmbSupervisar, #cmbTipoClase, #cmbCursoHorario', function(e){
   $(this).find("option[value='']").remove();
});

$(document).on('click', '#btnCancelar', function(e){
   limpiarFormulario();
   e.preventDefault();
});

$('#formRegistrarAsistencia').submit(event=>{
   let idPersonal = $('#cmbDocentes').val();
   $.ajax({
      url:"ajax/supervision.ajax.php",
      method: "POST",
      data: $('#formRegistrarAsistencia').serialize(), 
      cache: false,
      success:function(response){
         if (response == 'ok') {
            mensaje('¡CORRECTO!', 'La acción se realizó con exito.' , 'success');
            limpiarFormulario();
            $("#modalAsistencia").modal("hide");
         }else if(response == 'noval'){
            alertaMensaje1('top-right', 'warning', '¡La hora de salida no puede ser mayor a la hora de entrada!');
         }else if(response=='error'){
            mensaje('¡ADVERTENCIA!', '¡El tiempo de sessión ah expirado. Actualice la pagina' , 'warning');
         }else if (response == 'nofecha') {
            mensaje('¡ADVERTENCIA!', '¡La fecha no fue ingresada' , 'warning');
         }else{
            mensaje('¡ERROR!', '¡Ah ocurrido un error al realizar la acción! Comuniquese con el administrador de inmediato.' , 'error');
         }
      }
   });
   event.preventDefault();
});

function validarCmb(){
   let valSede = $('#cmbSedes').val();
   let valCarrera = $('#cmbCarreras').val();
   if (valSede != '' && valCarrera != '') {
      $('#cmbCursoHorario').prop('disabled', false);
      let datos = new FormData();
      datos.append('funcion', 'mostrarSeccionesDatos');
      datos.append('idSede', valSede);
      datos.append('idCarrera', valCarrera);
      mostrarSecciones(datos, 'cmbCursoHorario');
   }
}

function mostrarSecciones(datos, cmb){
   let template = '';
   $.ajax({
      url:"ajax/aula.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success:function(response){
         response.forEach(valor =>{
            template +=`
               <option value="${valor.idHorarioCurso}">${valor.nombreCurso} - ${valor.nombreSeccion} TURNO ${valor.nombreTurno}</option>
            `;
         });
         $('#'+cmb).html(template);
         mostrarSelectCmb(cmb, "Seleccionar una opción");
      }
   });  
}

function limpiarFormulario(){
   $("#formRegistrarAsistencia")[0].reset();   
   mostrarSelectCmb('cmbDocentes', 'Seleccione una opción');
   mostrarSelectCmb('cmbSedes', 'Seleccione una opción');
   mostrarSelectCmb('cmbCarreras', 'Seleccione una opción');
   mostrarSelectCmb('cmbSupervisar', 'Seleccione una opción');
   mostrarSelectCmb('cmbTipoClase', 'Seleccione una opción');
   $('#cmbCursoHorario').html('');
   mostrarSelectCmb('cmbCursoHorario', 'Seleccione una opción');
   $('#cmbCursoHorario').prop('disabled', true);
}