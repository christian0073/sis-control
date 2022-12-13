$(document).ready(function(){
   let mostrarUsuarios = new FormData();
   mostrarUsuarios.append("funcion", "mostrarUsuarios")
   buscarEnTabla('tablaUsuarios', 'usuario.ajax.php', mostrarUsuarios, 50);
});

$(document).on("click", "#btnRegistrarUsuario", function(e){
   mostrarSelectCmb("cmbRolUsuario", "Seleccione una opción");
   $("#formRegistrarUsuario")[0].reset();
   $("input[name='txtDniUsuario']").focus();
});

$(document).on("change", "#cmbRolUsuario", function(e){
   $(this).find("option[value='']").remove();
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

$('#formRegistrarUsuario').submit(event=>{
   if ($("input[name='txtDniUsuario']").val().length < 8) {
      alertaMensaje1('top-right', 'warning', '¡El DNI debe contener 8 caracteres!');
   }else{
      $.ajax({
         url:"ajax/usuario.ajax.php",
         method: "POST",
         data: $('#formRegistrarUsuario').serialize(),
         cache: false,
         success:function(response){
            if (response == 'ok') {
               let mostrarUsuarios = new FormData();
               mostrarUsuarios.append("funcion", "mostrarUsuarios")
               buscarEnTabla('tablaUsuarios', 'usuario.ajax.php', mostrarUsuarios, 50);
               mostrarSelectCmb("cmbRolUsuario", "Seleccionar una rol");
               $("#modalRegistroUsuario").modal("hide");
               mensaje('¡CORRECTO!', 'Usuario registrado con exitó con exito.' , 'success');
            }else if(response == 'existe'){
               mensaje('¡ADVERTENCIA!', '¡El nombre de usuario ya se encuentra registrada!', 'warning');
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

$(document).on("click", ".btnEditarUsuario", function(){
   let idUsuario = $(this).attr('idUsuario');
   $('#tituloPersonal').html("");
   $("#formEditarUsuario")[0].reset();
   let datos = new FormData();
   datos.append('funcion', 'mostrarUsuario');
   datos.append('idUsuario', idUsuario);
   $.ajax({
      url:"ajax/usuario.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success:function(response){
         $("#tituloPersonal").html(response['apellidoPaternoPersona'] + " " + response['apellidoMaternoPersona'] + ", " + response['nombresPersona']);
         $("#cmbRolUsuarioEditar").val(response['idRol']);
         $("input[name='txtContraEditar']").val(response['contraUsuario']);
      }
   }); 
});

$(document).on("click", ".btnEliminarUsuario", function(e){
   let idUsuario = $(this).attr('idUsuario');
   swal({
      title: "¿Está seguro de desactivar el usuario?",
      text: "¡Sí no lo está, puede cancelar la acción!",
      type: "warning",
      showCancelButton: true,
      cancelButtonText: "¡Cancelar!",
      focusCancel: true,
      confirmButtonText: "Sí, Eliminar",
   }).then(function(result){
      if (result.value) {
         let datos = new FormData();
         datos.append('funcion', 'desactivarUsuario');
         datos.append('idUsuario', idUsuario);
         $.ajax({
            url:"ajax/usuario.ajax.php",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            success:function(response){
               if (response == 'ok') {
                  let mostrarUsuarios = new FormData();
                  mostrarUsuarios.append("funcion", "mostrarUsuarios")
                  buscarEnTabla('tablaUsuarios', 'usuario.ajax.php', mostrarUsuarios, 50);
                  alertaMensaje1('top-right', 'success', '¡Se desctivó el usuario con exitó!');
               }else if (response == 'no') {
                  alertaMensaje1('top-right', 'warning', '¡No se realizó la acción!');
               }else{
                  mensaje('¡ERROR!', '¡Ah ocurrido un error al realizar la acción! Comuniquese con el administrador de inmediato.' , 'error');
               }
            }
         });
      }
   });
});

function buscarDniUsuario(datos, dni, dato){
   if(dni.length == 8 && dato){
      $.ajax({
         url:"ajax/usuario.ajax.php",
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