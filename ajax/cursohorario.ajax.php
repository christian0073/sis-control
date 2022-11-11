<?php 
	require_once "../controlador/cursohorario.controlador.php";
	require_once "../modelo/cursohorario.modelo.php";

	require_once "../modelo/asistencia.modelo.php";
	
	/* condición para registar horario de un curso*/
	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'registrarHorario') {
		$respuesta = ControladorCursoHorario::ctrRegistrarHorario();
		echo $respuesta;
	}	

	if(isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'mostrarDatosAsis'){
		$respuesta = ControladorCursoHorario::ctrMostrarAsistenciaCurso($_POST['idHorarioCurso']);
		if (isset($_POST['idReprogramar']) && !empty($_POST['idReprogramar'])) {
			$modeloCurso = new ModeloAsistencia();
			$reprogramacion = $modeloCurso->mdlMostrarReprogramacionId($_POST['idReprogramar']);
			$respuesta += ['fechaReprogramacion' => $reprogramacion['fecha']];
		}
		echo json_encode($respuesta);
	}

	if(isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'verHoras'){
		$respuesta = ControladorCursoHorario::ctrMostrarHorasDocente($_POST['idPersonal']);
		echo $respuesta;
	}
	if(isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'mostrarAsistencia'){

	}

		
	