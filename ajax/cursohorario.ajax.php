<?php 
	require_once "../controlador/cursohorario.controlador.php";
	require_once "../modelo/cursohorario.modelo.php";

	/* condición para registar horario de un curso*/
	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'registrarHorario') {
		$respuesta = ControladorCursoHorario::ctrRegistrarHorario();
		echo $respuesta;
	}	

	if(isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'mostrarDatosAsis'){
		$respuesta = ControladorCursoHorario::ctrMostrarAsistenciaCurso($_POST['idHorarioCurso']);
		echo json_encode($respuesta);
	}