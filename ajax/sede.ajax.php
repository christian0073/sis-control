<?php
	require_once "../controlador/sede.controlador.php";
	require_once "../modelo/sede.modelo.php";
	/* funcioón ajax para registrar nueva sede*/
	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'registrarSede') {
		$respuesta = ControladorSede::ctrRegistrarSede($_POST['txtNombreSede']);
		echo $respuesta;
	}
	/* funcion ajax para mostrar las sedes existentes */
	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'mostrarSedes') {
		$respuesta = ControladorSede::ctrMostrarSedes();
		echo json_encode($respuesta);
	}
 ?>