<?php
	require_once "../controlador/cursoaula.controlador.php";
	require_once "../modelo/cursoaula.modelo.php";
	/* condiciópn ajax para registrar nuevo carrera*/
	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'mostrarCursosAula') {
		$respuesta = ControladorCursoAula::ctrMostrarCursosAula($_POST['idAula']);
		echo json_encode($respuesta);
	}