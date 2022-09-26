$(document).ready(function(){
      $("[href='procesado']").addClass('active');
      $(".select2").select2()
      let mostrarSubsanaciones = new FormData();
      mostrarSubsanaciones.append("funcion", "mostrarProcesados");
      buscarEnTabla('tablaSubsanacion', 'alumno.ajax.php', mostrarSubsanaciones, 50);
});
$(document).on('change', '#cmbSedes', function(e){
   $(this).find("option[value='']").remove();
   idSedeGlobal = $(this).val();
   $("#btnGenerarExcel").attr("href", 'excel?idSede='+idSedeGlobal);
   console.log("idSedeGlobal", idSedeGlobal);
   let mostrarSubsanaciones = new FormData();
   mostrarSubsanaciones.append("funcion", "mostrarProcesados");
   mostrarSubsanaciones.append('idSede', idSedeGlobal)
   buscarEnTabla('tablaSubsanacion', 'alumno.ajax.php', mostrarSubsanaciones, 50);
});