<?php
	require_once "../controlador/cursoaula.controlador.php";
	require_once "../modelo/cursoaula.modelo.php";
	/* condiciópn ajax para registrar nuevo carrera*/
	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'mostrarCursosAula') {
		$respuesta = ControladorCursoAula::ctrMostrarCursosAula($_POST['idAula']);
		echo json_encode($respuesta);
	} 
	/* condición para registrar curso de un docente */
	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'registrarCurso') {
		$respuesta = ControladorCursoAula::ctrAgregarDocente();
		echo $respuesta;
	}
	/* condición para mostrar cursos */
	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'mostrarCursosDocente') {
		$respuesta = ControladorCursoAula::ctrMostrarCursosDocente();
		echo $respuesta;
	}
	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'mostrarCursosListaDocente') {
		$respuesta = ControladorCursoAula::ctrMostrarCursosListaDocente();
		echo json_encode($respuesta);
	}
	/* condicoón para mostrar el detalle del horario de las secciones */
	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'mostrarHoras') {
		$respuesta = ControladorCursoAula::ctrMostrarDetalleCurso($_POST['idhorariocurso']);
		echo json_encode($respuesta);	
	}
	/* condición para mostrar de una sección */
	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'mostrarCursosSeccion') {
		$respuesta = ControladorCursoAula::ctrMostrarCursosSeccion();
		echo $respuesta;
	}
	/* condición para registrar curso de un docente */
	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'registrarDocenteCurso') {
		$respuesta = ControladorCursoAula::ctrRegistrarDocenteCurso();
		echo $respuesta;
	}
	if(isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'eliminarDocenteCurso'){
		$respuesta = ControladorCursoAula::ctrEliminarCursoDocente();
		echo $respuesta;
	}