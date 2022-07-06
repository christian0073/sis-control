<?php 
	date_default_timezone_set("America/Lima");
	class ControladorPeriodo {
	/* metodo para registrar nuevo periodo */
		static public function ctrRegistrarPeriodo(){
			if (isset($_POST['txtYear']) && !empty($_POST['txtYear']) &&
				isset($_POST['txtEtapa']) && !empty($_POST['txtEtapa']) &&
				isset($_POST['txtNombrePeriodo']) && !empty($_POST['txtNombrePeriodo']) &&
				isset($_POST['txtFechaInicio']) && !empty($_POST['txtFechaInicio']) &&
				isset($_POST['txtFechaFin']) && !empty($_POST['txtFechaFin'])
			) {
				$fechaInicio = $_POST['txtFechaInicio'];
				$fechaFin = $_POST['txtFechaFin'];
				if ($fechaFin <= $fechaInicio) {
					return 'novalido';
				}
				$yearPeriodo = $_POST['txtYear'];
				$etapaPeriodo = $_POST['txtEtapa'];
				$nombrePeriodo = trim($_POST['txtNombrePeriodo']);
				if (preg_match('/^[\/\-\\0-9a-zA-Z ]+$/', $nombrePeriodo)) {
					$modeloPeriodo = new ModeloPeriodo();
					$respuesta  = $modeloPeriodo->mdlRegistrarPeriodo($yearPeriodo, $etapaPeriodo, $nombrePeriodo, $fechaInicio, $fechaFin);
					if ($respuesta > 0) {
						return 'ok';
					}
					return $respuesta;
				}else{
					return 'no';
				}
			}
		}
		/* metodo para mostrar todos loe periodes registrados */
		static public function ctrMostrarPeriodos(){
			$modeloPeriodo = new ModeloPeriodo();
			$respuesta = $modeloPeriodo->mdlMostrarPeriodos();
			return $respuesta;
		}
		/* metodo par mostrar todos los datos de una persona */
		static public function ctrMostrarPeriodo($idPeriodo){
			$modeloPeriodo = new ModeloPeriodo();
			$respuesta = $modeloPeriodo->mdlMostrarPeriodo($idPeriodo);
			return $respuesta;	
		}
		/* metodo para editar un periodo */
		static public function ctrEditarPeriodo(){
			if (isset($_POST['txtYear']) && !empty($_POST['txtYear']) &&
				isset($_POST['txtEtapa']) && !empty($_POST['txtEtapa']) &&
				isset($_POST['txtNombrePeriodo']) && !empty($_POST['txtNombrePeriodo']) &&
				isset($_POST['txtFechaInicio']) && !empty($_POST['txtFechaInicio']) &&
				isset($_POST['txtFechaFin']) && !empty($_POST['txtFechaFin']) &&
				isset($_POST['idPeriodo']) && !empty($_POST['idPeriodo'])
			) {
				$fechaInicio = $_POST['txtFechaInicio'];
				$fechaFin = $_POST['txtFechaFin'];
				if ($fechaFin <= $fechaInicio) {
					return 'novalido';
				}
				$yearPeriodo = $_POST['txtYear'];
				$etapaPeriodo = $_POST['txtEtapa'];
				$nombrePeriodo = trim($_POST['txtNombrePeriodo']);
				$idPeriodo = $_POST['idPeriodo'];
				if (preg_match('/^[\/\-\\0-9a-zA-Z ]+$/', $nombrePeriodo)) {
					$modeloPeriodo = new ModeloPeriodo();
					$respuesta  = $modeloPeriodo->mdlEditarPeriodo($yearPeriodo, $etapaPeriodo, $nombrePeriodo, $fechaInicio, $fechaFin, $idPeriodo);
					if ($respuesta) {
						return 'ok';
					}
					return $respuesta;
				}else{
					return 'no';
				}
			}
		}
		/* metodo para editar el estado del periodo */
		static public function ctrCambiarEstadoPerdiodo($idPeriodo, $estado){
			$respuesta = '';
			$modeloPeriodo = new ModeloPeriodo();
			if ($estado) {
				$respuesta = $modeloPeriodo->mdlMostrarPeriodoCampo('estadoPeriodo', 1);
				if (!empty($respuesta)) {
					return 'existe';
				}
			}
			$respuesta  = $modeloPeriodo->mdlEditarPeriodoCampo($idPeriodo, 'estadoPeriodo', $estado);
			if ($respuesta) {
				return 'ok';
			}
			return $respuesta;
		}

		static public function ctrMostrarPeriodoActivo(){
			$modeloPeriodo = new ModeloPeriodo();
			$respuesta = $modeloPeriodo->mdlMostrarPeriodoCampo('estadoPeriodo', TRUE);
			return $respuesta;	
		}
	}