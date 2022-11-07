<?php
	require_once "../controlador/datos.controlador.php";
	require_once "../modelo/datos.modelo.php";

	require_once "../modelo/periodo.modelo.php";
	
	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'mostrarAsistenciaMeses') {
		$respuesta = ControladorDatos::ctrAsistenciasDocentesMeses($_POST['idPersonal']);
		echo $respuesta;
	} 