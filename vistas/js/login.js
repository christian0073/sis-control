$('#formLogin').submit(event=>{
	$.ajax({
		url:"ajax/usuario.ajax.php",
		method: "POST",
		data: $('#formLogin').serialize(),
		cache: false,
		success:function(response){
			if (response == 'novalido') {
				mensaje('¡CORREGIR!', '¡Usuario y/o contraseña incorrectas!', 'warning');
			}else if (response == 'no') {
				mensaje('¡CORREGIR!', '¡no se permite caracteres especiales!', 'warning');
			}else if (response == 'ok') {
				mensajeReload('¡CORRECTO!', '¡Bienvenido.' , 'success');
			}else{
				mensaje('¡ERROR!', '¡Ah ocurrido un  error al iniciar sesión! Comuniquese con el administrador de inmediato.' , 'error');
			}
	    }
  	});
	event.preventDefault();
});