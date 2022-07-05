<?php
	require_once "../controlador/carrera.controlador.php";
	require_once "../modelo/carrera.modelo.php";
	/* condiciópn ajax para registrar nuevo carrera*/
	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'registrarCarrera') {
		$respuesta = ControladorCarrera::ctrRegistrarCarrera(trim($_POST['txtNombreCarrera']), $_POST['idPlanLectivo']);
		echo $respuesta;
	}
	/* condicio para mostrar todos las carreras registrados*/
	if(isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'mostrarCarreras'){
		$respuesta = ControladorCarrera::ctrMostrarCarreras();
		echo json_encode($respuesta);	
	}
	/* condición par editar una nueva carrera */
	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'verCarrera') {
		$respuesta = ControladorCarrera::ctrMostrarCarrera($_POST['idCarrera']);
		echo json_encode($respuesta);	
	}
	/* condición para editar una carrera */
	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'editarCarrera') {
		$respuesta = ControladorCarrera::ctrEditarCarrera(trim($_POST['txtNombreCarrera']),  intval($_POST['idCarrera']));
		echo $respuesta;
	}
	/* condicioón para agregar una carrera a un local */
	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'registrarCarreraLocal') {
		$respuesta = ControladorCarrera::ctrRegistrarCarreraLocal();
		echo $respuesta;
	}
	/* condición que muestre todas las carreras registradas en un local */
	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'mostrarCarrerasLocal') {
		$respuesta = ControladorCarrera::ctrMostrarCarrerasLocal($_POST['idLocal']);
		echo json_encode($respuesta);
	}
	/* condición par editar campo de un carrera dentro de un local */
	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'editarLocalCarrera') {
		$respuesta = ControladorCarrera::ctrEditarEstadoLocalCarrera(intval($_POST['idLocalCarrera']),  $_POST['estado']);
		echo $respuesta;
	}

		/* condicioón para agregar una carrera a un local */
	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'mostrarCarrerasLocalActivo') {
		$respuesta = ControladorCarrera::ctrMostrarCarrerasLocalActivo($_POST['idLocal']);
		echo json_encode($respuesta);
	}