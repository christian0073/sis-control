function activarLinkMenu(link, idElemento){
   $("[href='"+link+"']").addClass('active');
   $(idElemento).addClass('active');
   $(idElemento).parent().addClass('menu-is-opening menu-open');
}

function mensaje(titulo, mensaje, tipo){
	swal({
		title: titulo,
		text: mensaje,
		type: tipo,
		showConfirmButton: true,
		confirmButtonText: "Aceptar",
	});
}

function mensajeReload(titulo, mensaje, tipo){
	swal({
		title: titulo,
		text: mensaje,
		type: tipo,
		showConfirmButton: true,
		confirmButtonText: "Aceptar!",
	}).then(function(result){
		if (result.value) {
			location.reload();
		}
	});
}

function cmbDepartamentos(cmbElemento){
   let template  = '<option value="">Seleccione una opción</option>';
   $.ajax({
      type: 'POST',
      url: 'ajax/json-ubiacion/departamentos.json',
      dataType: 'json'
   }).done((data) => {
      $.each(data, function(indice, departamento){
         template +=`
            <option value="${departamento.id_ubigeo}">${departamento.nombre_ubigeo}</option>
         `;
      });
      $('#'+cmbElemento).html(template);
   });
}

function mostrarProvinciaDistrito(cmbElemento, url, ubigeo){
   let template  = '<option value="">Seleccione una opción</option>';
   $.ajax({
      type: 'POST',
      url: 'ajax/json-ubiacion/'+url,
      dataType: 'json'
   }).done((data) => {
      $.each(data, function(indice, provDistrito){
         if (indice == ubigeo) {
            provDistrito.forEach(valor => {
               template +=`
                  <option value="${valor.id_ubigeo}">${valor.nombre_ubigeo}</option>
               `;

            })
         }
      });
      $('#'+cmbElemento).html(template);
   });
}


function mostrarDatosCmb(url, cmb, ubigeo, idSelect){
   let template = '';
   $.ajax({
      type: 'POST',
      url: 'ajax/json-ubiacion/'+url,
      dataType: 'json',
      success:function(response){
         lista = response[ubigeo];
         lista.forEach( valor =>{
            if (idSelect != valor.id_ubigeo) {
               template +=`
                  <option value="${valor.id_ubigeo}">${valor.nombre_ubigeo}</option>
               `;
            }else{
               template +=`
                  <option value="${valor.id_ubigeo}" selected>${valor.nombre_ubigeo}</option>
               `;
            }
            $('#'+cmb).html(template);
         });
      }
   });
}

function convertMayus($input){
   setTimeout(function () {
      $input.val(($input).val().toUpperCase());
  },50);
}

function buscarEnTabla(tabla, link, datos, longitud){
      $.ajax({
      url: "ajax/"+link,
      type: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success:function(response){
         let datatable = $('#'+tabla).DataTable({
         "pageLength": longitud,
         "deferRender":true,
         "retrieve":true,
         "processing":true,
         "language": {
            "sProcessing":     "Procesando...",
            "sLengthMenu":     "Mostrar _MENU_ registros",
            "sZeroRecords":    "No se encontraron resultados",
            "sEmptyTable":     "Ningún dato disponible en esta tabla",
            "sInfo":           "Mostrando registros del _START_ al _END_",
            "sInfoEmpty":      "Mostrando registros del 0 al 0",
            "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix":    "",
            "sSearch":         "Buscar:",
            "sUrl":            "",
            "sInfoThousands":  ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
               "sFirst":    "Primero",
               "sLast":     "Último",
               "sNext":     "Siguiente",
               "sPrevious": "Anterior"
            },
            "oAria": {
               "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
               "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
         }
      });         
      datatable.clear(); 
      datatable.rows.add(response.data); 
      datatable.draw(); 
      }
   });
}

function mostrarSelectCmb(elemento, texto){
   let valor = $("#"+elemento).find("option[value='']");
   if (valor.length == 0) {
      $("#"+elemento).prepend($("<option>", {value: "",text: texto, selected: "selected"}));
   }
}

function ocultarSelectCmb(elemento){
   let valor = $("#"+elemento).find("option[value='']");
   if (valor.length > 0) {
      $("#"+elemento).find("option[value='']").remove();
   }
}
/* mostrar datos en un datetable */
function mostrarDataTable(tabla, link){
   $('#'+tabla).DataTable({
      "ajax":"ajax/"+link,
      "pageLength": 25,
      "deferRender":true,
      "retrieve":true,
      "processing":true,
      "language": {
            "sProcessing":     "Procesando...",
            "sLengthMenu":     "Mostrar _MENU_ registros",
            "sZeroRecords":    "No se encontraron resultados",
            "sEmptyTable":     "Ningún dato disponible en esta tabla",
            "sInfo":           "Mostrando registros del _START_ al _END_",
            "sInfoEmpty":      "Mostrando registros del 0 al 0",
            "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix":    "",
            "sSearch":         "Buscar:",
            "sUrl":            "",
            "sInfoThousands":  ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
               "sFirst":    "Primero",
               "sLast":     "Último",
               "sNext":     "Siguiente",
               "sPrevious": "Anterior"
         },
         "oAria": {
            "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
         }
      }
   });
}
/* mostrar mensaje de alerta */
function alertaMensaje(posicion, icono, mensaje){
   swal({
      position: posicion,
      width: '300px',
      showConfirmButton: false,
      timer: 1500,
      html:'<p class="text-secondary">'+icono+'<span style="font-size: 14px"> '+mensaje+'</span></p>'
   });
}

function alertaMensaje1(posicion, tipo, mensaje){
   swal({
      toast: true,
      position: posicion,
      width: '400px',
      showConfirmButton: false,
      timer: 1500,
      type: tipo,
      title: mensaje
   });
}

function mostrarLocalesAulas(datos, cmbLocal, cmbEspecialidad){
   let template = '';
   $.ajax({
      url:"ajax/local.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success:function(response){
         response.forEach(valor =>{
            template +=`
               <option value="${valor.idLocal}">${valor.direccion}</option>
            `;
         });
         $('#'+cmbLocal).html(template);
         mostrarSelectCmb(cmbLocal, "Seleccione un local");
         $('#'+cmbEspecialidad).html('');
         $('#'+cmbEspecialidad).prepend($("<option>", {value: "",text: "Seleccionar especialidad", selected: "selected"}));
      }
   });     
}

function mostrarCarrerasAulas(datos, cmbCarrera){
   let template = '';
   $.ajax({
      url:"ajax/carrera.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success:function(response){
         response.forEach(valor =>{
            template +=`
               <option value="${valor.idLocalCarrera}">${valor.nombreCarrera}</option>
            `;
         });
         $('#'+cmbCarrera).html(template);
         mostrarSelectCmb(cmbCarrera, "Seleccionar una especialidad");
      }
   });  
}

function mostrarCiclo(datos, cmb){
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
               <option value="${valor.cicloSeccion}">${valor.cicloSeccion}</option>
            `;
         });
         $('#'+cmb).html(template);
         mostrarSelectCmb(cmb, "Seleccionar un ciclo");
      }
   });  
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
         let turno = '';
         response.forEach(valor =>{
            if (valor.turno == 'M') {
               turno = 'MAÑANA';
            }else{
               turno = 'TARDE';
            }
            template +=`
               <option value="${valor.idSeccion}">${valor.nombreSeccion} (${turno})</option>
            `;
         });
         $('#'+cmb).html(template);
         mostrarSelectCmb(cmb, "Seleccionar sección");
      }
   });  
}

function tiempo(minutos, hora) {
  let tiempo;
  tiempo = new Date("2000-01-01T" + hora + ":00Z");
  /* Si es una fecha inválida restauramos a 00:00 */
  if (isNaN(tiempo)) {
    tiempo = new Date("2000-01-01T00:00:00Z");
  }
  /* Operamos con los minutos */
  tiempo.setMinutes(tiempo.getMinutes() + minutos);
  /* Nos quedamos solo con hora y minuto */
  nuevahora = tiempo.toISOString().substr(11, 5);
  return nuevahora; 
}