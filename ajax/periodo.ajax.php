<?php
	require_once "../controlador/periodo.controlador.php";
	require_once "../modelo/periodo.modelo.php";
	/* condiciópn ajax para registrar nuevo periodo*/
	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'registrarPeriodo') {
		$respuesta = ControladorPeriodo::ctrRegistrarPeriodo();
		echo $respuesta;
	}
	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'mostrarPeriodos') {
		$respuesta = ControladorPeriodo::ctrMostrarPeriodos();
		echo json_encode($respuesta);
	}
	/* condición que muestra los datos de un solo periodo */
	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'verPeriodo') {
		$respuesta = ControladorPeriodo::ctrMostrarPeriodo($_POST['idPeriodo']);
		echo json_encode($respuesta);	
	}
	/* condiciópn ajax para editar un periodo*/
	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'editarPeriodo') {
		$respuesta = ControladorPeriodo::ctrEditarPeriodo();
		echo $respuesta;
	}
	/* editar el estado de un periodo */
	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'editarEstadoPeriodo') {
		$respuesta = ControladorPeriodo::ctrCambiarEstadoPerdiodo($_POST['idPeriodo'], $_POST['estado']);
		echo $respuesta;
	}
	