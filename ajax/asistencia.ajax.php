<?php
	date_default_timezone_set("America/Lima");
	require_once "../controlador/asistencia.controlador.php";
	require_once "../modelo/asistencia.modelo.php";

	require_once "../modelo/personal.modelo.php";
	/* condiciópn ajax para registrar nuevo carrera*/
	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'mostrarAsistencia') {
		$respuesta = ControladorAsistencia::ctrMostrarAsistencias();
		echo $respuesta;
	}