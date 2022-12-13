<?php
	require_once "../controlador/usuario.controlador.php";
	require_once "../modelo/usuario.modelo.php";

	require_once "../controlador/periodo.controlador.php";
	require_once "../modelo/periodo.modelo.php";

	require_once "../controlador/persona.controlador.php";
	require_once "../modelo/persona.modelo.php";
	require_once "../helpers/funciones.php";
	session_start();

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'inciarSesion') {
		$respuesta = ControladorUsuario::ctrIngresoUsuario($_POST['txtUser'], $_POST['txtContra']);
		echo $respuesta;
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'buscarDni') {
		$respuesta = ControladorUsuario::ctrMostrarUsuarioDni($_POST['dni']);
		if (!empty($respuesta)) {
			$respuesta = array("valor" => 'existe');
		}else{
			$respuesta = ControladorPersona::ctrMostrarPersonaDni($_POST['dni']);
			if(empty($respuesta)){
				//$persona = buscarPersona($_POST['dni']);
				$respuesta = buscarPersona1($_POST['dni']);
				if (empty($respuesta)) {
					$respuesta = array("valor" => 'no');	
				}
			}
		}
		echo json_encode($respuesta);
	}
	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'registrarUsuario') {
		$respuesta = ControladorUsuario::ctrRegistrarUsuario();
		echo $respuesta;
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'mostrarUsuarios') {
		$respuesta = ControladorUsuario::ctrMostrarUsuarios();
		echo $respuesta;
	}


	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'mostrarUsuario') {
		$respuesta = ControladorUsuario::ctrMostrarUsuarioId($_POST['idUsuario']);
		echo json_encode($respuesta);
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'desactivarUsuario') {
		$respuesta = ControladorUsuario::ctrEditarUsuarioCampo('estadoUsuario', 0, $_POST['idUsuario']);
		echo $respuesta;
	}
 ?>