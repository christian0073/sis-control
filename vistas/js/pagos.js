   var docentes = [];
   var persona = '';
$(document).ready(function(){
   activarLinkMenu("pagos", "#control");
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

$('#formBuscarDocente').submit(event=>{
   $('#cantHoras').html(0);
   let persona = $("input[name='textBuscarDocente']").val();
   let fecha = $("input[name='txtFechaBuscar']").val();
   let estado = $("#buscar").find("option[value='"+persona+"']");
   if (estado.length > 0 && fecha != '') {
      let idPersonal = document.getElementById("buscar").querySelector("option[value='"+persona+"']").dataset.value;
      $("input[name='idPersonal']").val(idPersonal);
      $("#tablaPagos").html('');
      $.ajax({
         url:"ajax/asistencia.ajax.php",
         method: "POST",
         data: $("#formBuscarDocente").serialize(),
         cache: false,
         dataType: "json",
         success:function(response){
            if (response =='') {
               alertaMensaje1('top-right', 'warning', '¡No se encontraron resultados!');
            }else if (response == 'no') {
               mensaje('¡ADVERTENCIA!', '¡El docente no tiene asigando el monto por hora! registre el monto correspondiente.' , 'warning');
            }else{
               $("#tablaPagos").html(response.tabla); 
               $('#cantHoras').html(response.cantidadHoras);
            }
         }
      });      
   }else{
      alertaMensaje1('top-right', 'warning', '¡No se realizó la busqueda!');
   }
   event.preventDefault();
});