<?php 
	session_start();
	require_once "../controlador/alumno.controlador.php";
	require_once "../modelo/alumno.modelo.php";

	require_once "../controlador/persona.controlador.php";
	require_once "../modelo/persona.modelo.php";

	require_once "../helpers/funciones.php";
	/* condición para buscar a una persona */
	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'buscarDni') {
		$respuesta = ControladorAlumno::ctrMostrarAlumnoDni($_POST['dni']);
		if (empty($respuesta)) {
			$respuesta = ControladorPersona::ctrMostrarPersonaDni($_POST['dni']);
			if(empty($respuesta)){
				//$persona = buscarPersona($_POST['dni']);
				$respuesta = buscarPersona1($_POST['dni']);
				if ((isset($respuesta['success']) && empty($respuesta['success'])) || empty($respuesta)) {
					$respuesta = array("valor" => 'no');	
				}
			}
		}
		echo json_encode($respuesta);
	}
	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'registrarSubsanacion') {
		$respuesta = ControladorAlumno::ctrRegistrarAlumno();
		echo $respuesta;

	}
	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'mostrarCursosAlumnos') {
		$respuesta = ControladorAlumno::ctrMostrarAlumnos();
		echo $respuesta;		
	}
	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'editarCampoSubsanar') {
		$respuesta = ControladorAlumno::ctrEditarEstadoSubsanar();
		echo $respuesta;			
	}