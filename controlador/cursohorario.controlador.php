<?php 
	Class ControladorCursoHorario{
		static public function ctrRegistrarHorario(){
			$estado = true;
			$repetido = false;
			$cont = 1;
			$cantHoras = 0;
			$idHorarioCurso = $_POST['idCursoHorario'];
			$dia = $_POST['diaId'];
			$idPersonal = $_POST['idPersonal'];
			$modeloHorario = new ModeloCursoHorario();
			$horario = $modeloHorario->mdlMostrarCursoHorario($idHorarioCurso, $dia);
			$horasTotal = 0;
			$horarioPersonal = $modeloHorario->mdlMostrarHorarioPersona($idPersonal, $dia, $idHorarioCurso);
			$data = [];
			while ($estado) {
				if (isset($_POST['txtEntrada'.$cont]) && isset($_POST['txtSalida'.$cont]) && isset($_POST['tipo'.$cont]) && 
					!empty($_POST['txtEntrada'.$cont]) && !empty($_POST['txtSalida'.$cont]) && !empty($_POST['tipo'.$cont])
				) {
					$agregar = true;
					$horaEntrada = $_POST['txtEntrada'.$cont];
					$horaSalida = $_POST['txtSalida'.$cont];
					$tipo = $_POST['tipo'.$cont];
					$start = strtotime($horaEntrada);
					$end = strtotime($horaSalida);
					$minutes = ($end - $start) / 60;
					$cantHoras = $minutes / $_POST['minutos'];
					$horasTotal = $horasTotal + $cantHoras;
					foreach ($horarioPersonal as $key => $value) {
						$horaEntrada1 = strtotime($value['horaEntrada']);
						$horaSalida1 = strtotime($value['horaSalida']);
						if ($start == $horaEntrada1 && $end == $horaEntrada1 || ($horaEntrada1 > $start && $horaSalida > $start) || ($horaEntrada1 < $end && $horaSalida > $end) || 
							($horaEntrada1 > $start && $horaEntrada1 < $end)
						) {
							$repetido = true;
							break;
						}
					}
					if (!$repetido) {
						foreach ($horario as $key => $value) {
							if ($start == strtotime($value['horaEntrada']) && $end == strtotime($value['horaSalida'])) {
								unset($horario[$key]);
								$agregar = false;
								break;
							}
						}
						if ($agregar) {
							$fila = array($idHorarioCurso, $dia, $horaEntrada, $horaSalida, $cantHoras, $tipo);
							array_push($data, $fila);
						}
						$cont++;
					}else{
						$rest = 'novalido';
						$estado = false;
						break;
					}
				}else{
					$rest = 'vacio';
					$estado = false;
				}
			}
			if (!empty($data)) {
				$respuesta = $modeloHorario->mdlRegistrarHorario($data);
				if ($respuesta) {
					if (!empty($horario)) {
						$consulta = '';
						foreach ($horario as $key => $value) {
							$id = $value['idDetalle'];
							$consulta .= "DELETE FROM detallehorario WHERE idDetalle = $id;";
						}
						$borrarRegistro = $modeloHorario->mdlEliminarRegistro($consulta);
						if ($borrarRegistro) {
							return $horasTotal;
						}
						return $borrarRegistro;
					}
					return $horasTotal;
				}
			}else{
				if ($rest == 'vacio' && !empty($horario)) {
					$consulta = '';
					foreach ($horario as $key => $value) {
						$horasTotal = $horasTotal - $value['horas'];
						$id = $value['idDetalle'];
						$consulta .= "DELETE FROM detallehorario WHERE idDetalle = $id;";
					}
					$borrarRegistro = $modeloHorario->mdlEliminarRegistro($consulta);
					if ($borrarRegistro) {
						return $horasTotal;
					}
				}
				return $rest;
			}
		}

		static public function ctrDocenteHorario($idPersonal){
			$modeloDocenteHorario = new ModeloCursoHorario();
			$horario = $modeloDocenteHorario->mdlDocenteHorario($idPersonal);
			$arrData = [];
			$horaInicio =	$horario[0]['horaEntrada'];
			$horaTarde = strtotime('13:30');
			$horaTemporal0 = strtotime($horaInicio);
			if ($horaTemporal0 >= $horaTarde) {
				$horaTemporal0 = $horaTarde0;
			}
			$horaFin = strtotime('08:50');
			foreach ($horario as $key => $value) {
				$horaSalida1 = strtotime($value['horaSalida']);
				if ($horaSalida1 > $horaFin) {
					$horaFin = $horaSalida1;
				}
			}
			$horasAc = true;
			$arrHoras = [];
			$horaNoche = strtotime('18:30');
			$horaTarde = strtotime('13:00');
			while($horasAc){
				if ($horaNoche > $horaTemporal0) {
					$horaTemporal =  strtotime('+50 minute', $horaTemporal0);
				}else{
					$horaTemporal =  strtotime('+45 minute', $horaTemporal0);
				}
				if ($horaTemporal0 == $horaTarde) {
					$horaTemporal =  strtotime('+30 minute', $horaTemporal0);
				}
				$rangoHora = array(
									"rangoHora"=> date("H:i", $horaTemporal0).' - '.date("H:i", $horaTemporal), "horaEntrada" => $horaTemporal0, "horaSalida" => $horaTemporal, "dia1"=>"",
									"dia2"=>"","dia3"=>"","dia4"=>"","dia5"=>"","dia6"=>""
								);
				if ($horaTemporal0 == $horaFin) {
					$horasAc = false;
					break;
				}
				$horaTemporal0 = $horaTemporal;
				array_push($arrHoras, $rangoHora);
				$horasAc++;
			}
			$dias = ["lunes", "martes", "miercoles", "viernes", "sabado"];
			$arrHorasNuevo = [];
			$tipoCurso = '';
			foreach ($horario as $key => $value) {
				foreach ($arrHoras as $key => $value1) {
					$horaEntrada1 = strtotime($value['horaEntrada']);
					$horaSalida1 = strtotime($value['horaSalida']);
					if ($value1['horaEntrada'] >= $horaEntrada1 && $value1['horaSalida'] <= $horaSalida1) {
						if($value['tipo'] == 'T'){
							$tipoCurso = 'TEORICA';
						}elseif ($value['tipo'] == 'P') {
							$tipoCurso = 'PRACTICA';
						}
						$datos = '<div style="height: 100%; widht:100%;" class="bg-danger">'.$value['nombreCarrera'].'</div>';

						$dia = $value['dia'];
						$arrHoras[$key]['dia'.$dia]= $datos;
					}
				}
			}
			return $arrHoras;
		}
	}