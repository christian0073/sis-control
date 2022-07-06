<?php
	require_once "../controlador/local.controlador.php";
	require_once "../modelo/local.modelo.php";
	/* condiciópn ajax para registrar nuevo local*/
	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'registrarLocal') {
		$respuesta = ControladorLocal::ctrRegistrarLocal();
		echo $respuesta;
	}
	/* condicio para mostrar todos los locales registrados*/
	if(isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'mostrarLocales'){
		$respuesta = ControladorLocal::ctrMostrarLocales($_POST['idSede']);
		echo json_encode($respuesta);	
	}
	/* Condición para mostrar los datos de un local */
	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'verLocal') {
		$respuesta = ControladorLocal::ctrMostrarLocal($_POST['idLocal']);
		echo json_encode($respuesta);		
	}
	/* condición para editar los datos de un local */
	if(isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'editarLocal'){
		$respuesta = ControladorLocal::ctrEditarLocal();
		echo $respuesta;
	} 
	/* condición par elimar un local */
	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'eliminarLocal') {
		$respuesta = ControladorLocal::ctrEditarLocalCampo('estadoLocal', FALSE, $_POST['idLocal']);
		echo $respuesta;	
	}
