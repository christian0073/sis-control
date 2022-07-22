$(document).ready(function(){
	$('.select2').select2();
   	activarLinkMenu("supervisar", "#registrar");
  	let datos = new FormData();
   	datos.append("funcion", "mostrarSupervision");
   	datos.append("fecha", "");
   	buscarEnTabla('tablaSupervisar', 'supervision.ajax.php', datos, 25);
});