<?php
	require_once "../controlador/curso.controlador.php";
	require_once "../modelo/curso.modelo.php";
	/* condiciópn ajax para registrar nuevo carrera*/
	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'registrarCurso') {
		$respuesta = ControladorCurso::ctrRegistrarCurso();
		echo $respuesta;
	}
	/* condición para mostrar un curso */
	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'mostrarCurso') {
		$respuesta = ControladorCurso::ctrMostrarCursoId($_POST['idCurso']);
		echo json_encode($respuesta);
	}
	/* condición para editar los datos de un curso */
	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'editarCurso') {
		$respuesta = ControladorCurso::ctrEditarCurso();
		echo $respuesta;
	}
	/* condición para editar un solo campo de un curso */
	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'editarCampo') {
		$respuesta = ControladorCurso::ctrEditarCursoEstado(0, $_POST['idCurso']);
		echo $respuesta;
	}
	