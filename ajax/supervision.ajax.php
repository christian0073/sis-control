<?php 
	date_default_timezone_set("America/Lima");
	require_once "../controlador/cursohorario.controlador.php";
	require_once "../modelo/cursohorario.modelo.php";

	/* condición para mostrar datos de un personal*/
	if(isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'mostrarSupervision'){
			$dia = date("N");
		if(!empty($_POST['fecha']) && validarFecha($_POST['fecha'])){
			$dia = date("N", $_POST['fecha']);
		}
		$respuesta = ControladorCursoHorario::mostrarSupervision($dia);
		
	}
 ?>