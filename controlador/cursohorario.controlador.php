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
						if (($start == $horaEntrada1 && $end == $horaSalida1) || ($horaEntrada1 < $end && $horaSalida1 > $end) || 
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

		static public function ctrDocenteHorario($idPersonal, $idSeccion = null){
			$idPeriodo = $_SESSION['idPeriodo'];
			$horario = '';
			if ($idPersonal != null) {
				$modeloDocenteHorario = new ModeloCursoHorario();
				$horario = $modeloDocenteHorario->mdlDocenteHorario($idPersonal, $idPeriodo);
			}else if ($idSeccion != null) {
				$modeloDocenteHorario = new ModeloCursoHorario();
				$horario = $modeloDocenteHorario->mdlSeccionHorario($idSeccion, $idPeriodo);
			}
			if (empty($horario)) {
				return 'no';
			}
			$horaInicio =	$horario[0]['horaEntrada'];
			$horaTarde = strtotime('13:30');
			$horaExtraordinario = strtotime('07:00');
			$horaTarde0 = strtotime($horaInicio);
			$arrHoras = [];
			if ($horaTarde0 == $horaExtraordinario) {
				$horaTemporal =  strtotime('+50 minute', $horaExtraordinario);
				$rangoHoraExtra = array(
									"rangoHora"=> date("H:i", $horaExtraordinario).' - '.date("H:i", $horaTemporal), "horaEntrada" => $horaExtraordinario, "horaSalida" => $horaTemporal, "dia1"=>"",
									"dia2"=>"","dia3"=>"","dia4"=>"","dia5"=>"","dia6"=>""
								);	
				array_push($arrHoras, $rangoHoraExtra);
				$horaInicio =	$horario[1]['horaEntrada'];
				$horaTarde0 = strtotime($horaInicio);
			}
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
			$tipoCurso = '';
			$color = '';
			foreach ($horario as $key => $value) {
				foreach ($arrHoras as $key => $value1) {
					$horaEntrada1 = strtotime($value['horaEntrada']);
					$horaSalida1 = strtotime($value['horaSalida']);
					if ($value1['horaEntrada'] >= $horaEntrada1 && $value1['horaSalida'] <= $horaSalida1) {
						if($value['tipo'] == 'T'){
							$tipoCurso = 'TEÓRICA';
							$color = 'bg-info';
						}elseif ($value['tipo'] == 'P') {
							$tipoCurso = 'PRÁCTICA';
							$color = 'bg-success';
						}
						$trozos = explode(" ", $value['nombreCarrera']);
						$contar = count($trozos);
						$nombre = '';
						for ($i=0; $i < $contar ; $i++) { 
							$nombre .= substr($trozos[$i], 0, 3).". ";
						}
						//$nombre .= "- ".$value['periodo']." - ".mb_strtoupper($value['nombreSede'], 'UTF-8')."<br>".$value['nombreCurso']." SECCIÓN ".$value['nombreSeccion']." (".$tipoCurso.")";
						$nombre .= " ".$value['nombreSeccion']." ".mb_strtoupper($value['nombreSede'], 'UTF-8')."<br>".$value['nombreCurso']." (".$tipoCurso.")";
						$datos = '<div style="widht:100%; height:100%;" class="'.$color.'">'.$nombre.'</div>';

						$dia = $value['dia'];
						$arrHoras[$key]['dia'.$dia]= $datos;
					}
				}
			}
			return $arrHoras;
		}
		static public function ctrMostrarAsistenciaCurso($idHorarioCurso){
			$modeloCurso = new ModeloCursoHorario();
			$respuesta = $modeloCurso->mdlMostrarAsistenciaCurso($idHorarioCurso);
			return $respuesta;
		}

		static public function ctrMostrarHorasDocente($idPersonal){
			$idPeriodo = $_SESSION['idPeriodo'];
			$modeloCurso = new ModeloCursoHorario();
			$respuesta = $modeloCurso->mdlMostrarHorasDocente($idPersonal, $idPeriodo);
			return $respuesta['horas'];	
		}
		/* Codigo para calcular la cantidad de horas al mes y registrar el historial de horas */
		static public function ctrCalcularHorasDocente($idPersonal){
			$idPeriodo = $_SESSION['idPeriodo'];
			$dt = new DateTime();
			$fecha =  $dt->format('Y').'-'.$dt->format('m');
			$modeloCurso = new ModeloCursoHorario();
			$horasMes = $modeloCurso->mdlHorasDocenetMes($idPersonal, $fecha);
			$fechaRegistro = $dt->format('Y-m-d');
			$count = count($horasMes);
			$horasDias = $modeloCurso->mdlCantidadHorasDia($idPersonal, $idPeriodo);
			if (!empty($horasMes)) {
				$arrDias = json_decode($horasMes[$count-1]['diasHoras'],true);
				$horaSemanaViejo =  contarHoras($arrDias);
				$horaSemanaNuevo = contarHoras($horasDias);
				if ($horaSemanaNuevo > $horaSemanaViejo) {
					$diferencia = $horaSemanaNuevo - $horaSemanaViejo;
				}else if($horaSemanaViejo > $horaSemanaNuevo){
					$diferencia = $horaSemanaViejo - $horaSemanaNuevo;
				}
				$diferencia = 0;
				$fila = ['fechaHoras'=>$fechaRegistro, 'diasHoras'=>json_encode($horasDias)];
					array_push($horasMes, $fila);
				$horasTotales = calcularHorasMes($horasMes, $fecha, $dt);
				if ($diferencia > 0) {
					$registrarHistorial = $modeloCurso->mdlRegistrarHistorialHoras($idPersonal, $fechaRegistro,  json_encode($horasDias));
					if ($registrarHistorial) {
						return $horasTotales;
					}
					return 'error';
				}
				return $horasTotales;
			}else{
				$fechaRegistro = $dt->format('Y-m').'-01';
				$registrarHistorial = $modeloCurso->mdlRegistrarHistorialHoras($idPersonal, $fechaRegistro, json_encode($horasDias));
				if ($registrarHistorial) {
					$dias_mes=cal_days_in_month(CAL_GREGORIAN, $dt->format('m'), $dt->format('Y'));
					return cuenta_dias($fecha, $horasDias, $dias_mes+1);
				}
				return "error";
			}
			return "error";
		}
		/* contar las horas mes */
		static public function contarHorasMes($idPersonal){
			$idPeriodo = $_SESSION['idPeriodo'];
			$modeloCurso = new ModeloCursoHorario();
			$dt = new DateTime();
			$fecha =  $dt->format('Y').'-'.$dt->format('m');
			$horasMes = $modeloCurso->mdlHorasDocenetMes($idPersonal, $fecha);
			$horasTotales = 0;
			if (!empty($horasMes)) {
				$horasTotales = calcularHorasMes($horasMes, $fecha, $dt);
			}else{
				$modeloCurso = new ModeloCursoHorario();
				$horasDias = $modeloCurso->mdlCantidadHorasDia($idPersonal, $idPeriodo);
				if (!empty($horasDias)) {
					$registrarHistorial = $modeloCurso->mdlRegistrarHistorialHoras($idPersonal, $fecha.'-01', json_encode($horasDias));
					if ($registrarHistorial) {
						$dias_mes=cal_days_in_month(CAL_GREGORIAN, $dt->format('m'), $dt->format('Y'));		
						$horasTotales = cuenta_dias($fecha, $horasDias, $dias_mes+1);	
					}
				}

			}
			return $horasTotales;
		}
		/* mostrar el template para el historial de las horas */
		static public function ctrMostrarHistorial($idPersonal, $dt){
			$idPeriodo = $_SESSION['idPeriodo'];
			$template = '';
			$modeloCurso = new ModeloCursoHorario();
			$fechaCorta = $dt->format('Y-m');
			$horasMes = $modeloCurso->mdlHorasDocenetMes($idPersonal, $fechaCorta);
			if (!empty($horasMes)) {
				$template = historialHoras($dt, $horasMes, $fechaCorta);
			}else{
				$template = "<div class='w-100 text-center'><span class='badge badge-info'>No se registró historial</span></div>";
			}
			$respuesta = ["template" => $template, "mes" => $dt->format('m'), 'year' => $dt->format('Y')];
			return $respuesta;			
		}
		
		
	} 
