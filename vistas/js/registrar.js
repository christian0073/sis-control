var btnMaximo = 1;
var btnCelular = 1;

$(document).ready(function(){
   $('.select2').select2();
   activarLinkMenu("registrar", "#registrar");
   let mostrarPersonal = new FormData();
   mostrarPersonal.append("funcion", "mostrarPersonales")
   buscarEnTabla('tablaPersonal', 'personal.ajax.php', mostrarPersonal, 10);
});

$(document).on("click", "#btnAgregarPeriodo", function(e){
   mostrarSelectCmb("cmbCargoPersonal", "Seleccione una opción");
   $("#formRegistrarPersonal")[0].reset();
});

$(document).on("change", "#cmbCargoPersonal", function(e){
   $(this).find("option[value='']").remove();
});

$(document).on("change", "#cmbCargo", function(e){
   $(this).find("option[value='']").remove();
   let idCargo = $(this).val();
   let mostrarPersonal = new FormData();
   mostrarPersonal.append("funcion", "mostrarPersonales")
   mostrarPersonal.append("idCargo", idCargo)
   buscarEnTabla('tablaPersonal', 'personal.ajax.php', mostrarPersonal, 10);
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

$(document).on("click", "#btnAgregarCelulares", function(e){
   if (btnMaximo <= 4) {
      let template = `<div class="form-group col-6 contenedorCel">
                         <div class="input-group input-group-sm">
                           <input type="text" class="form-control" name="txtCelular${btnMaximo}" placeholder="Celular ${btnMaximo}" pattern="[0-9]+" minlength="9" maxlength="9" onkeypress="return event.charCode>=48 && event.charCode<=57" required>
                           <span class="input-group-append">
                             <button type="button" class="btn btn-info btn-light btnQuitarCelular"><i class="fa-solid fa-xmark"></i></button>
                           </span>
                         </div>
                     </div>`;
      let nuevo = $("#seccionCelulares").append(template);
      if (nuevo.length ==1) {
         $("input[name='txtCelular"+btnMaximo+"']").focus();
         btnMaximo++;
      }
   }else{
      alertaMensaje1('top-right', 'warning', '¡No se puede agregar más campos!');
   }
});

$(document).on("click", ".btnQuitarCelular", function(e){
   let dato = $(this).parent().parent().parent().remove();
   btnMaximo--;
   let numElementos = $("#seccionCelulares .contenedorCel").length;
   let i = 0;
   let contenedor = '';
   while(i < numElementos){
      let nombre = "txtCelular" + (i + 1);
      let elemento = $("#seccionCelulares .contenedorCel input")[i];
      $(elemento).prop('name', nombre);
      $(elemento).prop('placeholder', 'Celular ' + (i + 1));
      i++;
   }
});

$(document).on("click", "#btnAgregarCelularesEditar", function(e){
   if (btnCelular <= 4) {
      let template = `<div class="form-group col-6 contenedorCel">
                         <div class="input-group input-group-sm">
                           <input type="text" class="form-control" name="txtCelularEdit${btnCelular}" placeholder="Celular ${btnCelular}" pattern="[0-9]+" minlength="9" maxlength="9" onkeypress="return event.charCode>=48 && event.charCode<=57" required>
                           <span class="input-group-append">
                             <button type="button" class="btn btn-info btn-light btnQuitarCelularEditar"><i class="fa-solid fa-xmark"></i></button>
                           </span>
                         </div>
                     </div>`;
      let nuevo = $("#seccionCelularesEditar").append(template);
      if (nuevo.length ==1) {
         $("input[name='txtCelularEdit"+btnCelular+"']").focus();
         btnCelular++;
      }
   }else{
      alertaMensaje1('top-right', 'warning', '¡No se puede agregar más campos!');
   }
   console.log("btnCelular", btnCelular);
});

$(document).on("click", ".btnQuitarCelularEditar", function(e){
   let dato = $(this).parent().parent().parent().remove();
   btnCelular--;
   console.log("btnCelular", btnCelular);
   let numElementos = $("#seccionCelularesEditar .contenedorCel").length;
   let i = 0;
   let contenedor = '';
   while(i < numElementos){
      let nombre = "txtCelularEdit" + (i + 1);
      let elemento = $("#seccionCelularesEditar .contenedorCel input")[i];
      $(elemento).prop('name', nombre);
      $(elemento).prop('placeholder', 'Celular ' + (i + 1));
      i++;
   }
});

$('#formRegistrarPersonal').submit(event=>{
   if ($("input[name='txtDniUsuario']").val().length < 8) {
      alertaMensaje1('top-right', 'warning', '¡El DNI debe contener 8 caracteres!');
   }else{
      $.ajax({
         url:"ajax/personal.ajax.php",
         method: "POST",
         data: $('#formRegistrarPersonal').serialize(),
         cache: false,
         success:function(response){
            if (response == 'ok') {
               let mostrarPersonal = new FormData();
               mostrarPersonal.append("funcion", "mostrarPersonales")
               buscarEnTabla('tablaPersonal', 'personal.ajax.php', mostrarPersonal, 10);
               mostrarSelectCmb("cmbCargo", "Seleccionar una opción");
               $('#cmbCargo').select2("val", "");
               $("#modalRegistroPersonal").modal("hide");
               mensaje('¡CORRECTO!', 'La acción se realizó con exito.' , 'success');
            }else if(response == 'existe'){
               mensaje('¡ADVERTENCIA!', '¡La persona ya se encuentra registrada!', 'warning');
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
/* boton para traer los datos a editar */
$(document).on("click", ".btnEditarPersonal", function(e){
   $("#seccionCelularesEditar").html('');
   let idPersonal = $(this).attr('idPersonal');
   $("#formEditarPersonal")[0].reset();
   $('#tituloPersonal').html("");
   let datos = new FormData();
   datos.append('funcion', 'mostrarPersonal');
   datos.append('idPersonal', idPersonal);
   $.ajax({
      url:"ajax/personal.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success:function(response){
         $('#tituloPersonal').html(response['apellidoPaternoPersona']+' '+response['apellidoMaternoPersona']+', '+ response['nombresPersona']+' ('+response['dniPersona']+')');
         $('#cmbCargoPersonalEditar').val(response['idCargo']);
         $('#cmbCargoPersonalEditar').select2("val", response['idCargo']);
         $('input[name="txtFechaIngresoEditar"]').val(response['fechaIngresoPersonal']);
         $('input[name="txtCorreoPersonalEditar"]').val(response['correoPersonal']);
         $('input[name="txtDireccionPersonalEditar"]').val(response['direccionPersonal']);
         $('input[name="idPersonal"]').val(response['idPersonal']);
         $('input[name="txtProfesionEditar"]').val(response['profesionPersonal']);
         let cont = response['celularPersonal'].length;
         let template = '';
         let nuevo;
         btnCelular =1;
         for (let i = 0; i < cont; i++) {
            template = `<div class="form-group col-6 contenedorCel">
                         <div class="input-group input-group-sm">
                                 <input type="text" class="form-control" name="txtCelularEdit${btnCelular}" value="${response['celularPersonal'][i]}" pattern="[0-9]+" minlength="9" maxlength="9" onkeypress="return event.charCode>=48 && event.charCode<=57" required>
                                 <span class="input-group-append">
                                   <button type="button" class="btn btn-info btn-light btnQuitarCelularEditar"><i class="fa-solid fa-xmark"></i></button>
                                 </span>
                               </div>
                           </div>`;
            nuevo = $("#seccionCelularesEditar").append(template);
            if (nuevo.length ==1) {
               btnCelular++;
            }
         }
      }
   }); 
});
/* enviar datos a editar */
$("#formEditarPersonal").submit(event=>{
   $.ajax({
      url:"ajax/personal.ajax.php",
      method: "POST",
      data: $('#formEditarPersonal').serialize(),
      cache: false,
      success:function(response){
         if (response == 'ok') {
            let mostrarPersonal = new FormData();
            mostrarPersonal.append("funcion", "mostrarPersonales")
            buscarEnTabla('tablaPersonal', 'personal.ajax.php', mostrarPersonal, 10);
            mostrarSelectCmb("cmbCargo", "Seleccionar una opción");
            $('#cmbCargo').select2("val", "");
            $("#modalEditarPersonal").modal("hide");
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



function buscarDniUsuario(datos, dni, dato){
   if(dni.length == 8 && dato){
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
