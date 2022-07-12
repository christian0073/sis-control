<?php 
	Class ControladorAula{
		/* metodo par registrar un nuevo aula*/
		static public function ctrRegistrarAula(){
			if (isset($_POST['cmbSedeAula']) && !empty($_POST['cmbSedeAula']) &&
				isset($_POST['cmbLocalesAula']) && !empty($_POST['cmbLocalesAula']) &&
				isset($_POST['cmbEspecialidadAula']) && !empty($_POST['cmbEspecialidadAula']) &&
				isset($_POST['txtNombreAula']) && !empty($_POST['txtNombreAula']) &&
				isset($_POST['cmbTurnoAula']) && !empty($_POST['cmbTurnoAula']) &&
				isset($_POST['cmbCicloAula']) && !empty($_POST['cmbCicloAula'])
			) {
				$modeloPeriodo = new ModeloPeriodo();
				$periodo = $modeloPeriodo->mdlMostrarPeriodoCampo('estadoPeriodo', TRUE);
				if (empty($periodo)) {
					return "error";
				}
				$idSedeAula = intval($_POST['cmbSedeAula']);
				$idLocalAula = intval($_POST['cmbLocalesAula']);
				$idEspecialidadAula = intval($_POST['cmbEspecialidadAula']);
				$nombreAula = trim($_POST['txtNombreAula']);
				$turnoAula = $_POST['cmbTurnoAula'];
				$cicloAula = $_POST['cmbCicloAula'];
				if (preg_match('/^[\/\=\\_\\.\\-\\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $nombreAula)) {
					$modeloAula = new ModeloAula();
					$respuesta  = $modeloAula->mdlRegistrarAula($idEspecialidadAula, $periodo['idPeriodo'], $nombreAula, $turnoAula, $cicloAula);
					if ($respuesta > 0) {
						$modeloCarrera = new ModeloCarrera();
						$carrera = $modeloCarrera->mdlMostrarCarreraLocalActivo($idEspecialidadAula);
						$modeloCurso = new ModeloCurso();
						$cursos = $modeloCurso->mdlMostrarCursosCarrera($carrera['idCarrera'], 'periodo', $cicloAula);
						$arrData = [];
						foreach ($cursos as $key => $value) {
							$fila = array($respuesta, $value['idCurso']);
							array_push($arrData, $fila);
						}
						$modeloCursoAula = new ModeloCursoAula();
						$cursosRespuesta = $modeloCursoAula->mdlRegistrarCursosAula($arrData);
						if ($cursosRespuesta) {
							return 'ok';
						}

					}
					return $respuesta;
				}else{
					return 'no';
				}
			}
		}
		static public function ctrMostrarAulas($idPeriodo, $idSede, $idCarrera){
			$modeloAula = new ModeloAula();
			$respuesta = $modeloAula->mdlMostrarAulas($idPeriodo, $idSede, $idCarrera);
			return $respuesta;
		}
		static public function ctrMostrarAulaId($idAula){
			$modeloAula = new ModeloAula();
			$respuesta = $modeloAula->mdlMostrarAulaId($idAula);
			return $respuesta;	
		}
		static public function ctrEditarAula(){
			if (isset($_POST['txtAula']) && !empty($_POST['txtAula']) &&
				isset($_POST['cmbTurno']) && !empty($_POST['cmbTurno']) &&
				isset($_POST['cmbCiclo']) && !empty($_POST['cmbCiclo']) &&
				isset($_POST['idAula']) && !empty($_POST['idAula'])
			) {
				$nombreAula = trim($_POST['txtAula']);
				$turnoAula = $_POST['cmbTurno'];
				$cicloAula = $_POST['cmbCiclo'];
				$idAula = intval($_POST['idAula']);
				$idPeriodo = intval($_POST['idPeriodoAula']);
				$idLocalidadAula = intval($_POST['idLocalidadAula']);
				if (preg_match('/^[\/\=\\_\\.\\-\\,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $nombreAula)) {
					$modeloAula = new ModeloAula();
					$respuesta  = $modeloAula->mdlEditarAula($nombreAula, $turnoAula, $cicloAula, $idAula, $idPeriodo, $idLocalidadAula);
					if ($respuesta == 1) {
						return 'ok';
					}
					return $respuesta;
				}else{
					return 'no';
				}
			}
		}
		/* metodo para editar un solo campo de un aula */
		public function ctrEditarAulaCampo($item, $valor, $idAula){
			$modeloAula = new ModeloAula();
			$respuesta  = $modeloAula->mdlEditarAulaCampo($item, $valor, $idAula);
			if ($respuesta) {
				return 'ok';
			}else{
				return 'error';
			}
		}
		static public function ctrMostrarCiclo($idLocalAula){
			$modeloAula = new ModeloAula();
			$respuesta = $modeloAula->mdlMostrarCiclo($idLocalAula);
			return $respuesta;				
		}
		static public function ctrMostrarSecciones($idLocalAula, $idCiclo){
			$modeloAula = new ModeloAula();
			$respuesta = $modeloAula->mdlMostrarSecciones($idLocalAula, $idCiclo);
			return $respuesta;				
		}
		/* metodo para ver detalles de una sección */
		static public function ctrDetallesSeccion($idSeccion){
			$modeloAula = new ModeloAula();
			$respuesta = $modeloAula->mdlDetallesSeccion($idSeccion);
			return $respuesta;
		}
	}