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
			foreach(){

			}
			return $horario;
		}
	}