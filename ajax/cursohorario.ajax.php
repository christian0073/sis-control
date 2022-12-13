<?php 
	date_default_timezone_set("America/Lima");
	require_once "../controlador/cursohorario.controlador.php";
	require_once "../modelo/cursohorario.modelo.php";

	require_once "../modelo/asistencia.modelo.php";

	require_once "../helpers/funciones.php";

	session_start();
	
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
			$respuesta += ['fechaReprogramacion' => $reprogramacion['fecha'], 'horaIngreso' => $reprogramacion['horaIngreso'], 'horaSalida' => $reprogramacion['horaSalida']];
		}
		echo json_encode($respuesta);
	}

	if(isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'verHoras'){
		$respuesta = ControladorCursoHorario::ctrMostrarHorasDocente($_POST['idPersonal']);
		echo $respuesta;
	}
	if(isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'mostrarHistorial'){
		setlocale(LC_TIME, "spanish");
		$dt = new DateTime();
		if (isset($_POST['mes']) && !empty($_POST['mes'])) {
			$dt = new DateTime($dt->format('Y').'-'.$_POST['mes'].'-01');
		}
		$respuesta = ControladorCursoHorario::ctrMostrarHistorial($_POST['idPersonal'], $dt);
		echo json_encode($respuesta);
	}
	/* Codigo para hacerel calculo de horas mensuales y registrar el historial de horas */
	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'calcularHoras') {
		$respuesta = ControladorCursoHorario::ctrCalcularHorasDocente($_POST['idPersonal']);
		sleep(1);
		$arrRespt = ['ok'=>$respuesta];
		echo json_encode($arrRespt);
	}
	/* condición para mostrar horarios */
	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'mostrarHorario') {
		$respuesta = ControladorCursoHorario::ctrDocenteHorario(null, $_POST['idSeccion']);
		echo json_encode($respuesta);
	}