var queryString = window.location.search;
var urlParams = new URLSearchParams(queryString);
var idSeccionGlobal = urlParams.get('idSeccion');
$(document).ready(function(){
	activarLinkMenu("seccion", "#ajustes");
   	let mostrarCursos = new FormData();
   	mostrarCursos.append("funcion", "mostrarCursosSeccion");
   	mostrarCursos.append("idSeccion", idSeccionGlobal);
   	buscarEnTabla('tablaCursos', 'cursoaula.ajax.php', mostrarCursos, 10);
});

$(document).on("click", ".btnAgregarDocente", function(){
	$("input[name='txtDniPersonal']").focus();
	let idHorarioCurso = $(this).attr('idHorarioCurso');
	$("input[name='idCursoHorario']").val(idHorarioCurso);
	$("#formRegistrarDocente")[0].reset();
})

$(document).on("click", "#btnBuscarDni", function(e){
   		let dniUsuario = $("input[name='txtDniPersonal']").val().trim();
   		let dato = /^\d*$/.test(dniUsuario);
		let datos = new FormData();
		datos.append('funcion', 'buscarDniPersonal');
		datos.append('dni', dniUsuario);
  	 	buscarDniPersonal(datos, dniUsuario, dato);
});

$(document).on("keypress", "input[name='txtDniPersonal']", function(e){
    if (event.keyCode === 13) {
      let dniUsuario = $(this).val().trim();
      let dato = /^\d*$/.test($(this).val());
      let datos = new FormData();
      datos.append('funcion', 'buscarDniPersonal');
      datos.append('dni', dniUsuario);
      buscarDniPersonal(datos, dniUsuario, dato);
   }
});

$("#formRegistrarDocente").submit(event=>{
	$.ajax({
		url:"ajax/cursoAula.ajax.php",
		method: "POST",
		data: $('#formRegistrarDocente').serialize(),
		cache: false,
		success:function(response){
			if (response == 'ok') {
				let mostrarCursos = new FormData();
				mostrarCursos.append("funcion", "mostrarCursosSeccion");
				mostrarCursos.append("idSeccion", idSeccionGlobal);
				buscarEnTabla('tablaCursos', 'cursoaula.ajax.php', mostrarCursos, 10);
				$("#modalAgregarDocente").modal("hide");
				mensaje('¡CORRECTO!', 'La acción se realizó con exito.' , 'success');
			}else if(response == 'no'){
				mensaje('¡CORREGIR!', '¡no se permite caracteres especiales!', 'warning');
			}else{
				mensaje('¡ERROR!', '¡Ah ocurrido un error al realizar la acción! Comuniquese con el administrador de inmediato.' , 'error');
			}
      	}
   });
   event.preventDefault();
});

function buscarDniPersonal(datos, dniUsuario, dato){
	if(dniUsuario.length == 8 && dato){
     	$.ajax({
			url:"ajax/personal.ajax.php",
			method: "POST",
			data: datos,
			cache: false,
			contentType: false,
			processData: false,
			dataType: "json",
			success:function(response){
	            if(response['valor'] && response['valor'] == 'no'){
               		alertaMensaje1('top-right', 'warning', '¡Persona no registrada!');
	            }else if (response['idPersonal']) {
	               $("input[name='txtDatos']").val(response['apellidoPaternoPersona']+' '+response['apellidoMaternoPersona']+', '+response['nombresPersona']);
	               $("input[name='txtProfesion']").val(response['profesionPersonal']);
	               $("input[name='idPersonalDocente']").val(response['idPersonal']);
	            }else{
	               alertaMensaje1('top-right', 'error', '¡Hubó un error al realizar la busqueda!');
	            }
			}
      	});   
	}else{
	  alertaMensaje1('top-right', 'warning', '¡Dato invalido!');
	}
}