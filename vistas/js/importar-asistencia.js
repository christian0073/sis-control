$(document).ready(function(){
   activarLinkMenu("importar-asistencia", "#control");
   let datos = new FormData();
   datos.append('funcion', 'mostrarDocentes');
   $.ajax({
      url:"ajax/personal.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success:function(response){
         docentes = response.slice();
      }
   }); 
});

$(document).on("keypress", "input[name='textBuscarDocente']", function(e){
   $("#buscar").html();
   let texto = $(this).val();
   let = '';
    //console.log(texto)
    let er = new RegExp(texto, "i");
    docentes.forEach(valores => {
      let valor = valores['datos'];
      let idPersona = valores['idPersonal'];
         if(er.test(valor)){
            let+='<option data-value="'+idPersona+'" value="'+valor+'">';
           }
      });
    $("#buscar").html(let);
});
/* Función para validar el tipo y tamaño de archivo que se sube */
$(document).on("change", "#fileAsistencia", function(e){
   let ext = $(this).val().split('.').pop();
   if ($(this).val() != '') {
      if (ext == 'xls') {
         if ($(this)[0].files[0].size > 1048576) {
            alertaMensaje1('top-right', 'warning', '¡Archivo no valido!');   
         }else{

         }
         fileName = $(this).val().split( '\\' ).pop();
         $("#nombreArchivo").html(fileName);
      }else{
         $(this).val();
         alertaMensaje1('top-right', 'warning', '¡Archivo no valido!');
      }
   }

});

$('#formCargarExcel').submit(event=>{
   let persona = $("input[name='textBuscarDocente']").val();
   let estado = $("#buscar").find("option[value='"+persona+"']");
   let excel = $("#fileAsistencia").val();
   if (estado.length > 0 && excel != "") {
      let idPersonal = document.getElementById("buscar").querySelector("option[value='"+persona+"']").dataset.value;
      $("input[name='idPersonal']").val(idPersonal);
      $("#tablaPagos").html('');
      $.ajax({
         url:"ajax/asistencia.ajax.php",
         type: "POST",
         data: new FormData($('#formCargarExcel')[0]),
         contentType: false,
         cache: false,
         processData:false,
         success:function(response){
            if (response =='') {
               alertaMensaje1('top-right', 'warning', '¡No se encontraron resultados!');
            }else if (response == 'error') {
               $("#formCargarExcel")[0].reset();
               $("#nombreArchivo").html("Selecionar un archivo");
               mensaje('¡ADVERTENCIA!', '¡Datos de archivo incorrecto, intente nuevamente.' , 'warning');
            }else{
               $("#tablaPagos").html(response); 
            }
         }
      });      
   }else{
      alertaMensaje1('top-right', 'warning', '¡No se cargo el archivo!');
   }
   event.preventDefault();
});