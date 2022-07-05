<?php
	require_once "../controlador/usuario.controlador.php";
	require_once "../modelo/usuario.modelo.php";

	session_start();

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'inciarSesion') {
		$respuesta = ControladorUsuario::ctrIngresoUsuario($_POST['txtUser'], $_POST['txtContra']);
		echo $respuesta;
	}
 ?>