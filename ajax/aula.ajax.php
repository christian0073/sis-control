<?php
	require_once "../controlador/aula.controlador.php";
	require_once "../modelo/aula.modelo.php";
	require_once "../modelo/periodo.modelo.php";
	require_once "../modelo/carrera.modelo.php";
	require_once "../modelo/curso.modelo.php";
	require_once "../modelo/cursoaula.modelo.php";
	/* condiciópn ajax para registrar nuevo aula*/
	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'registrarAula') {
		$respuesta = ControladorAula::ctrRegistrarAula();
		echo $respuesta;
	}
	/* condición que muestro los datos de un aula */
	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'verAula') {
		$respuesta = ControladorAula::ctrMostrarAulaId($_POST['idAula']);
		echo json_encode($respuesta);
	}	
	/* condición para editar un aula */
	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'editarAula') {
		$respuesta = ControladorAula::ctrEditarAula();
		echo $respuesta;
	}	
	/* condición para editar el estado de un aula */
	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'editarCampoAula') {
		$respuesta = ControladorAula::ctrEditarAulaCampo("estado", 0, $_POST['idAula']);
		echo $respuesta;
	}	
	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'mostrarCiclos') {
		$respuesta = ControladorAula::ctrMostrarCiclo($_POST['idLocalCarrera']);
		echo json_encode($respuesta);
	}
	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'mostrarSecciones') {
		$respuesta = ControladorAula::ctrMostrarSecciones($_POST['idLocalCarrera'], $_POST['idCiclo']);
		echo json_encode($respuesta);
	}
	/* condición que muestra los detalles de la sección */
	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == "mostrarDetallesCurso") {
		$respuesta = ControladorAula::ctrDetallesSeccion($_POST['idSeccion']);
		echo json_encode($respuesta);
	}
	