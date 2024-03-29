<?php 
	date_default_timezone_set("America/Lima");
	session_start();
	require_once "../controlador/personal.controlador.php";
	require_once "../modelo/personal.modelo.php";

	require_once "../controlador/persona.controlador.php";
	require_once "../modelo/persona.modelo.php";

	require_once "../controlador/cursohorario.controlador.php";
	require_once "../modelo/cursohorario.modelo.php";

	require_once "../modelo/cursoaula.modelo.php";

	require_once "../helpers/funciones.php";
	/* condición para buscar a una persona */
	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'buscarDni') {
		$respuesta = ControladorPersonal::ctrMostrarPersonalDni($_POST['dni']);
		if (!empty($respuesta)) {
			$respuesta = array("valor" => 'existe');
		}else{
			$respuesta = ControladorPersona::ctrMostrarPersonaDni($_POST['dni']);
			if ((isset($respuesta['success']) && empty($respuesta['success'])) || empty($respuesta)) {
				//$persona = buscarPersona($_POST['dni']);
				$respuesta = buscarPersona1($_POST['dni']);
				if (empty($respuesta)) {
					$respuesta = array("valor" => 'no');	
				}
			}
		}
		echo json_encode($respuesta);
	}

	/* condición para registrar PERSONAL */
	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'registrarPersonal') {
		$respuesta = ControladorPersonal::ctrRegistrarPersonal();
		echo $respuesta;
	}
	/* Condición para mostrar los datos de los trabajadores */
	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'mostrarPersonales') {
		$respuesta = ControladorPersonal::ctrMostrarPersonales();
		echo $respuesta;
	}
	/* Condicional para mostrar datos de los docenetes */
	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'mostrarListaDocentes') {
		$respuesta = ControladorPersonal::ctrMostrarListaDocentes();
		echo $respuesta;
	}
	/* condición para mostrar datos de un personal*/
	if(isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'mostrarPersonal'){
		$respuesta = ControladorPersonal::ctrMostrarPersonalId($_POST['idPersonal']);
		echo json_encode($respuesta);
	}
	/* condición para editar los datos de una persona */
	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'editarPersonal') {
		$respuesta = ControladorPersonal::ctrEditarPersonal();
		echo $respuesta;	
	}
	/* condición para editar los detalles de pago de un personal */
	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'editarDetalles') {
		$respuesta = ControladorPersonal::ctrEditarDetallesPersonal();
		echo $respuesta;
	}
	/* condición para mostrar horarios */
	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'mostrarHorario') {
		if ($_POST['nombreCargo'] == "DOCENTE") {
			$respuesta = ControladorCursoHorario::ctrDocenteHorario($_POST['idPersonal']);
			echo json_encode($respuesta);
		}
	}
	/* condición para buscar a una persona */
	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'buscarDniPersonal') {
		$respuesta = ControladorPersonal::ctrMostrarPersonalDni($_POST['dni']);
		if (empty($respuesta)) {
			$respuesta = array("valor" => 'no');
		}
		echo json_encode($respuesta);
	}
	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'eliminarPersonal') {
		$respuesta = ControladorPersonal::ctrEditarEstadoPersonal();
		echo $respuesta;
	}
	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'mostrarDocentes') {
		$respuesta = ControladorPersonal::ctrMostrarDocentes();
		echo json_encode($respuesta);	
	}
?>