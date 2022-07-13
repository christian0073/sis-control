<?php 
	require_once "../controlador/personal.controlador.php";
	require_once "../modelo/personal.modelo.php";

	require_once "../controlador/persona.controlador.php";
	require_once "../modelo/persona.modelo.php";

	require_once "../controlador/cursohorario.controlador.php";
	require_once "../modelo/cursohorario.modelo.php";

	require_once "../helpers/funciones.php";
	/* condición para buscar a una persona */
	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'buscarDni') {
		$respuesta = ControladorPersonal::ctrMostrarPersonalDni($_POST['dni']);
		if (!empty($respuesta)) {
			$respuesta = array("valor" => 'existe');
		}else{
			$respuesta = ControladorPersona::ctrMostrarPersonaDni($_POST['dni']);
			if(empty($respuesta)){
				$persona = buscarPersona($_POST['dni']);
				if ($persona['success']) {
					$respuesta = $persona['result'];
				}else{
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

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'mostrarPersonales') {
		$respuesta = ControladorPersonal::ctrMostrarPersonales();
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
			$horarioDocente = ControladorCursoHorario::ctrDocenteHorario($_POST['idPersonal']);
			echo '<pre>'; print_r($horarioDocente); echo '</pre>';
		}
	}
?>