var fechaSuper;
$(document).ready(function(){
	$('.select2').select2();
   	activarLinkMenu("cambios", "#registrar");
});

$(document).on("click", "#btnBuscarAvance", function(e){
	let fecha = $("input[name='txtFechaSupervision']").val();
	if (fecha != "") {
		let datos = new FormData();
	   	datos.append("funcion", "mostrarAvance");
	   	datos.append("fecha", fecha);
	   	buscarEnTabla('tablaSupervisar', 'supervision.ajax.php', datos, 100);
	   	fechaSuper = fecha;
	}else{
		alertaMensaje1('top-right', 'warning', '¡No se puede realizar la busqueda!');
	}
});

$(document).on("click", ".btnEliminarAsistencia", function(e){
	let idAsistenciaDocente = $(this).attr('idAsistenciaDocente');
   	swal({
      title: "¿Está seguro de eliminar el registro?",
      text: "¡Sí no lo está, puede cancelar la acción!",
      type: "warning",
      showCancelButton: true,
      cancelButtonText: "¡Cancelar!",
      focusCancel: true,
      confirmButtonText: "Sí, Eliminar",
   	}).then(function(result){
      if (result.value) {
         let datos = new FormData();
         datos.append('funcion', 'eliminarAsistencia');
         datos.append('idAsistenciaDocente', idAsistenciaDocente);
         $.ajax({
            url:"ajax/supervision.ajax.php",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            success:function(response){
               	if (response == 'ok') {
					let datos = new FormData();
				   	datos.append("funcion", "mostrarAvance");
				   	datos.append("fecha", fechaSuper);
				   	buscarEnTabla('tablaSupervisar', 'supervision.ajax.php', datos, 25);
				   	alertaMensaje1('top-right', 'success', '¡Registro eliminado!');
               }else{
                  mensaje('¡ERROR!', '¡Ah ocurrido un error al realizar la acción! Comuniquese con el administrador de inmediato.' , 'error');
               }
            }
         });
      }
   });
});