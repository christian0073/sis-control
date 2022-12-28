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
	if(isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'mostrarReprogramacion'){
		$respuesta = ControladorAsistencia::ctrMostrarReprogramaciones();
		echo $respuesta;
	}
	if(isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'elimarRep'){
		$respuesta = ControladorAsistencia::ctrEliminarReprogramacion();
		echo $respuesta;
	}
	if(isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'mostrarAvance'){
		$respuesta = ControladorAsistencia::ctrMostrarAvance($_POST['fecha'], $_SESSION['idUsuarioSis']);
		echo $respuesta;
	}
	if(isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'eliminarAsistencia'){
		$respuesta = ControladorAsistencia::ctrEliminarAsistencia($_POST['idAsistenciaDocente']);
		echo $respuesta;
	}
	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'editarLink') {
		$respuesta = '';
		if (!empty($_POST['link']) && isset($_POST['link']) && !empty($_POST['idHorarioCurso']) && isset($_POST['idHorarioCurso'])) {
			$respuesta = ControladorAsistencia::ctrEditarLink($_POST['link'], $_POST['idHorarioCurso']);	
		}
		echo $respuesta;
	}

	if(isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'registrarAsistenciaExep'){
		$respuesta = ControladorAsistencia::ctrRegistrarAsistenciaExcep();
		echo $respuesta;		 
	}
 ?>