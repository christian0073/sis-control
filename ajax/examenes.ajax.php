<?php
	require_once "../controlador/cursoaula.controlador.php";
	require_once "../modelo/cursoaula.modelo.php";
	/* condiciópn ajax para registrar nuevo carrera*/
	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'registrarParcial') {
		$respuesta = ControladorCursoAula::ctrRegistrarExamenesDocente();
		echo $respuesta;
	} 

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'cantidadExamenes') {
		$cantidadExamenes = ControladorCursoAula::ctrCantidadExamenes();
		echo json_encode($cantidadExamenes);
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'mostrarListaExamenes') {
		$respuesta = ControladorCursoAula::ctrMostrarListaExamenes($_POST['idParcial']);
		echo $respuesta;
	}