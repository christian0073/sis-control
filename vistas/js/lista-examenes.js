
var idParcialLink = 0;
var fechaLink = '';
$(document).ready(function(){
   $('.select2').select2();
   activarLinkMenu("lista-examenes", "#examenes");
});

$(document).on("change", "#cmbParcial", function(e){
   let idParcial = $(this).val();
   idParcialLink = idParcial;
   ocultarSelectCmb("cmbParcial");
   let mostrarListaDocentes = new FormData();
   mostrarListaDocentes.append("funcion", "mostrarListaExamenes");
   mostrarListaDocentes.append("idParcial", idParcial);
   buscarEnTabla('tablaDoenteExamenes', 'examenes.ajax.php', mostrarListaDocentes, 100);
   $("#btnDescarga").css({'display':'block'});
   $("#btnGenerarExcel").attr("href", 'excel?idParcial='+idParcialLink);
});

$(document).on("change", "input[name='fechaDescarga']", function(e){
   fechaLink = $(this).val();
   $("#btnGenerarExcel").attr("href", 'excel?idParcial='+idParcialLink+'&fecha='+fechaLink);
});