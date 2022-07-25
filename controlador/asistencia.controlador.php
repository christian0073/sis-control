<?php
	class ControladorAsistencia{

		static public function ctrMostrarSupervision(){
			$idPeriodo = $_SESSION['idPeriodo'];
			$dia = date("N", strtotime($_POST['fecha']));
			$idSede = $_POST['idSede'];
			$asistencias = '';
			$modeloAsistencia = new ModeloAsistencia();
			$asistencias = $modeloAsistencia->mdlMostrarSupervision($idSede, $dia, $idPeriodo);
			if (count($asistencias) == 0) {
				$datosJson = '{"data":[]}';
				echo $datosJson;
				return;
			}else{
				$datosJson = '{
				"data":[';
				foreach ($asistencias as $key => $value) {
					$acciones = "<div class='btn-group'><button class='btn btn-primary btn-sm mostrarAsistencia' data-toggle='modal' data-target='#modalAsistencia' title='Registrar asistencia' idHorarioCurso='".$value['idHorarioCurso']."' idPersonal='".$value['idPersonal']."'><i class='fa-solid fa-calendar-check'></i></button></div>"; 
					$ciclo = "<h5><span class='badge badge-warning'>".$value['cicloSeccion']."° Ciclo</span></h5></div>"; 
					$turno = '';
					if ($value['turno'] == 'M') {
						$turno = 'MAÑANA';
					}else if ($value['turno'] == 'T') {
						$turno = 'TARDE';
					}else if($value['turno'] == 'N'){
						$turno = 'NOCHE';
					}
					$seccion = $value['nombreSeccion'].' '.$turno;
					$datosJson .='[
							"'.($key+1).'",
							"'.$value['datos'].'",
							"'.$value['nombreCarrera'].'",
							"'.$value['nombreCurso'].'",
							"'.$ciclo.'",
							"'.$seccion.'",
							"'.$value['horaEntrada'].' - '.$value['horaSalida'].'",
							"'.$value['horas'].'",
							"'.$acciones.'"
					],';
				}
				$datosJson = substr($datosJson, 0, -1);
				$datosJson .= ']}';
				return $datosJson;			
			}
		}

		static public function ctrMostrarAsistencia($fecha, $idPersonal, $idHorarioCurso){
			$modeloAsistencia = new ModeloAsistencia();
			$asistencia = $modeloAsistencia->mdlMostrarAsistencia($fecha, $idPersonal, $idHorarioCurso);
			return $asistencia;
		}
		static public function ctrRegistrarAsistencia(){
			if (isset($_POST['cmbTipoClase']) && !empty($_POST['cmbTipoClase'])) {
				$tipoClase = $_POST['cmbTipoClase'];
				if (!empty($_POST['txtHoraEntrada']) && !empty($_POST['txtHoraSalida'])) {
					$horaEntrada = strtotime($_POST['txtHoraEntrada']);
					$horaSalida = strtotime($_POST['txtHoraSalida']);
					if ($horaSalida < $horaEntrada || $horaSalida == $horaEntrada) {
						return 'error';
					}
				}
				$modeloAsistencia = new ModeloAsistencia();
				if ($tipoClase == 3) {
					$estado = 0;
				}else{
					if ($_POST['editar'] == 'true') {
					}else{
						$respuesta  = $modeloAsistencia->mdlRegistrarAsistencia($tipoClase, $_POST['idPersonalDocente'], $_POST['idCursoHorario'], $_SESSION['idUsuarioSis'], $_POST['fechaAsistencia'], $_POST['txtHoraEntrada'], $_POST['txtHoraSalida'], $_POST['txtObservacion'], 1);
						if ($respuesta > 0) {
							return 'ok';
						}
					}
				}
			}else{
				return 'no';
			}
		}
	}