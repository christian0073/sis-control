<?php 
	Class ControladorCurso{
		/* metodo par registrar una nueva carrera*/
		static public function ctrRegistrarCurso(){
			if (isset($_POST['txtNombreCurso']) && !empty($_POST['txtNombreCurso']) &&
				isset($_POST['cmbPeriodoCurso']) && !empty($_POST['cmbPeriodoCurso']) &&
				isset($_POST['txtCodigoCurso']) && !empty($_POST['txtCodigoCurso']) &&
				isset($_POST['idCarreraCurso']) && !empty($_POST['idCarreraCurso']) &&
				isset($_POST['txtCreditosCurso']) && !empty($_POST['txtCreditosCurso']) &&
				isset($_POST['cmbTipoCurso']) && !empty($_POST['cmbTipoCurso'])
			) {
				$nombreCurso = trim($_POST['txtNombreCurso']);
				$periodo = intval($_POST['cmbPeriodoCurso']);
				$codigoCurso = trim($_POST['txtCodigoCurso']);
				$correlativoCurso = trim($_POST['txtCorrelativoCurso']);
				$idCarrera = intval($_POST['idCarreraCurso']);
				$creditosCurso = intval($_POST['txtCreditosCurso']);
				$tipoCurso = $_POST['cmbTipoCurso'];
				if (preg_match('/^[\/\=\\_\\.\\-\\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $nombreCurso) &&
					preg_match('/^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $codigoCurso) &&
					(preg_match('/^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $correlativoCurso) || empty($correlativoCurso))
				) {
					$modeloCurso = new ModeloCurso();
					$respuesta  = $modeloCurso->mdlRegistrarCurso($idCarrera, $nombreCurso, $periodo, $codigoCurso, $correlativoCurso, $creditosCurso, $tipoCurso);
					if ($respuesta > 0) {
						return 'ok';
					}
					return $respuesta;
				}else{
					return 'no';
				}
			}
		}

		static public function ctrMostrarCursos($idCarrera, $item, $valor){
			$modeloCurso = new ModeloCurso();
			$respuesta = $modeloCurso->mdlMostrarCursos($idCarrera, $item, $valor);
			return $respuesta;
		}
		/* metodo para mostrar curso por ID */
		static public function ctrMostrarCursoId($idCurso){
			$modeloCurso = new ModeloCurso();
			$respuesta = $modeloCurso->mdlMostrarCurso('idCurso', $idCurso);
			return $respuesta;
		}
		/* metodo para editar un curso */
		static public function ctrEditarCurso(){
			if (isset($_POST['txtNombreCurso']) && !empty($_POST['txtNombreCurso']) &&
					isset($_POST['cmbPeriodoCurso']) && !empty($_POST['cmbPeriodoCurso']) &&
					isset($_POST['txtCodigoCurso']) && !empty($_POST['txtCodigoCurso']) &&
					isset($_POST['idCurso']) && !empty($_POST['idCurso']) &&
					isset($_POST['txtCreditosCurso']) && !empty($_POST['txtCreditosCurso']) &&
					isset($_POST['cmbTipoCurso']) && !empty($_POST['cmbTipoCurso'])
			) {		
				$nombreCurso = trim($_POST['txtNombreCurso']);
				$periodo = intval($_POST['cmbPeriodoCurso']);
				$codigoCurso = trim($_POST['txtCodigoCurso']);
				$correlativoCurso = trim($_POST['txtCorrelativoCurso']);
				$idCurso = intval($_POST['idCurso']);
				$creditosCurso = intval($_POST['txtCreditosCurso']);
				$tipoCurso = $_POST['cmbTipoCurso'];
				if (preg_match('/^[\/\=\\_\\.\\-\\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $nombreCurso) &&
					preg_match('/^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $codigoCurso) &&
					(preg_match('/^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $correlativoCurso) || empty($correlativoCurso))
				) {
					$modeloCurso = new ModeloCurso();
					$respuesta  = $modeloCurso->mdlEditarCurso($nombreCurso, $periodo, $codigoCurso, $correlativoCurso, $creditosCurso, $tipoCurso, $idCurso);
					if ($respuesta) {
						return 'ok';
					}
					return $respuesta;
				}else{
					return 'no';
				}
				
			}
		}
		/* metodo para editar el estado de un curso */
		static public function ctrEditarCursoEstado($estado, $idCurso){
			$modeloCurso = new ModeloCurso();
			$respuesta = $modeloCurso->mdlEditarCampoCurso('estado', $estado, $idCurso);
			if ($respuesta) {
				return 'ok';
			}
			return 'error';
		}
	}