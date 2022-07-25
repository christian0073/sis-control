<?php 
	session_start();
	date_default_timezone_set("America/Lima");
	require_once "../controlador/asistencia.controlador.php";
	require_once "../modelo/asistencia.modelo.php";

	if(isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'mostrarSupervision'){
		$respuesta = ControladorAsistencia::ctrMostrarSupervision();
		echo $respuesta;
	}
	if(isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'mostrarAsistencia'){
		$respuesta = ControladorAsistencia::ctrMostrarAsistencia($_POST['fecha'], $_POST['idPersonal'], $_POST['idHorarioCurso']);
		echo json_encode($respuesta);
	}
	if(isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'registrarAsistencia'){
		$respuesta = ControladorAsistencia::ctrRegistrarAsistencia();
		echo $respuesta;		
	}
 ?>