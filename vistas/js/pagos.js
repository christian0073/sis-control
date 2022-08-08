   var docentes = [];
   var persona = '';
$(document).ready(function(){
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
   let persona = $("input[name='textBuscarDocente']").val();
   let fecha = $("input[name='txtFechaBuscar']").val();
   console.log("fecha", fecha);
   let estado = $("#buscar").find("option[value='"+persona+"']");
   if (estado.length > 0 && fecha != '') {
      console.log("fecha", fecha);

   }else{
      alertaMensaje1('top-right', 'warning', '¡No se realizó la busqueda!');
   }
   event.preventDefault();
});