<?php
	class ControladorAsistencia{ 

		static public function ctrMostrarSupervision(){
			$idPeriodo = $_SESSION['idPeriodo'];
			$dia = date("N", strtotime($_POST['fecha']));
			$idSede = $_POST['idSede'];
			$asistencias = '';
			$modeloAsistencia = new ModeloAsistencia();
			$asistencias = $modeloAsistencia->mdlMostrarSupervision($idSede, $dia, $idPeriodo, $_POST['fecha']);
			if (count($asistencias) == 0) { 
				$datosJson = '{"data":[]}';
				echo $datosJson;
				return;
			}else{
				$datosJson = '{
				"data":[';
				foreach ($asistencias as $key => $value) {
					$acciones = '';
					if (!empty($value['linkCurso'])) {
						$acciones = "<div class='btn-group'><button class='btn btn-primary btn-sm mostrarAsistencia' data-toggle='modal' data-target='#modalAsistencia' title='Registrar asistencia' idHorarioCurso='".$value['idHorarioCurso']."' idPersonal='".$value['idPersonal']."' idDetalle='".$value['idDetalle']."'><i class='fa-solid fa-calendar-check'></i></button><a class='btn btn-danger btn-sm' href='".$value['linkCurso']."' title='Ingresar a la clase' target='_blank'><i class='fa-solid fa-link'></i></a></div>"; 	
					}else{
						$acciones = "<div class='btn-group'><button class='btn btn-primary btn-sm mostrarAsistencia' data-toggle='modal' data-target='#modalAsistencia' title='Registrar asistencia' idHorarioCurso='".$value['idHorarioCurso']."' idPersonal='".$value['idPersonal']."' idDetalle='".$value['idDetalle']."'><i class='fa-solid fa-calendar-check'></i></button><button class='btn btn-warning btn-sm agregarLink' idHorarioCurso='".$value['idHorarioCurso']."' title='Registrar link'><i class='fa-solid fa-link'></i></button></div>"; 	
					}
					
					
					$estado = "<span class='badge badge-danger' style='font-size: 14px;'>Pendiente</span>";
					if (!empty($value['idAsistenciaDocente'])) {
						$estado = "<span class='badge badge-info' style='font-size: 14px;'>Registrado</span>";
					}
					
					
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
							"'.$estado.'",
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
			if (!empty($asistencia) && $asistencia['tipo'] == 3) {
				$rep = $modeloAsistencia->mdlMostrarReprogramacion($fecha, $idHorarioCurso);
				if (!empty($rep)) {
					$asistencia['horaEntrada'] = $rep['horaIngreso'];
					$asistencia['horaSalida'] = $rep['horaSalida'];
					$asistencia += [ "idReprogramar"=>$rep['idReprogramacion'] ];
					$asistencia += [ "fechaRep"=>$rep['fechaReprogramacion'] ];
				}else{
					$borrar = $modeloAsistencia->mdlEliminarAsistencia($asistencia['idAsistenciaDocente']);
					$asistencia = false;
				}
			}
			return $asistencia;
		}
		static public function ctrRegistrarAsistencia(){
			if (empty($_SESSION['idUsuarioSis'])) {
				return 'error';
			}
			if (isset($_POST['cmbTipoClase']) && !empty($_POST['cmbTipoClase'])) {
				$tipoClase = $_POST['cmbTipoClase'];

				if (!empty($_POST['txtHoraEntrada']) && !empty($_POST['txtHoraSalida'])) {
					$horaEntrada = strtotime($_POST['txtHoraEntrada']);
					$horaSalida = strtotime($_POST['txtHoraSalida']);
					if ($horaSalida < $horaEntrada || $horaSalida == $horaEntrada) {
						return 'noval';
					}
				}
				$estado = 1;
				if ($tipoClase > 2) {
					$estado = 0;
				}
				$modeloAsistencia = new ModeloAsistencia();
				if ($tipoClase == 3) {
					if ($_POST['editar'] == 'true') {
						$respuesta = $modeloAsistencia->mdlEditarAsistencia($tipoClase, $_SESSION['idUsuarioSis'], $_POST['txtHoraEntrada'], $_POST['txtHoraSalida'], $_POST['txtObservacion'], $estado, $_POST['idAsistenciaDocente']);
						if ($respuesta) {
							$respuesta1 = $modeloAsistencia->mdlReprogramarAsistencia($_POST['idCursoHorario'], $_POST['fechaAsistencia'], $_POST['txtFechaRep'], $_POST['txtHoraEntrada'], $_POST['txtHoraSalida'], $_POST['idReprogramar']);
							if ($respuesta1>0) {
								return 'ok';
							}
						}
						return 'error';
					}else{
						$respuesta  = $modeloAsistencia->mdlRegistrarAsistencia($tipoClase, $_POST['idPersonalDocente'], $_POST['idCursoHorario'], $_SESSION['idUsuarioSis'], $_POST['fechaAsistencia'], $_POST['txtHoraEntrada'], $_POST['txtHoraSalida'], $_POST['txtObservacion'], $estado);
						if ($respuesta > 0) {
							$respuesta1 = $modeloAsistencia->mdlReprogramarAsistencia($_POST['idCursoHorario'], $_POST['fechaAsistencia'], $_POST['txtFechaRep'], $_POST['txtHoraEntrada'], $_POST['txtHoraSalida'], $_POST['idReprogramar']);
							if ($respuesta1>0) {
						 		return 'ok';
						 	} 	
						}
						return 'error';
					}
				}else{
					if ($_POST['editar'] == 'true'){ 
						$respuesta = $modeloAsistencia->mdlEditarAsistencia($tipoClase, $_SESSION['idUsuarioSis'], $_POST['txtHoraEntrada'], $_POST['txtHoraSalida'], $_POST['txtObservacion'], $estado, $_POST['idAsistenciaDocente']);
						if ($respuesta) {
							return 'ok';
						}
					}else{
						$respuesta  = $modeloAsistencia->mdlRegistrarAsistencia($tipoClase, $_POST['idPersonalDocente'], $_POST['idCursoHorario'], $_SESSION['idUsuarioSis'], $_POST['fechaAsistencia'], $_POST['txtHoraEntrada'], $_POST['txtHoraSalida'], $_POST['txtObservacion'], $estado);
						if ($respuesta > 0) {
							return 'ok';
						}
					}

				}
			}else{
				return 'no';
			}
		}
		static public function ctrMostrarReprogramaciones(){
			$fecha = $_POST['fecha'];
			$reprogramar = '';
			$modeloAsistencia = new ModeloAsistencia();
			$reprogramar = $modeloAsistencia->mdlMostrarReprogramaciones($fecha);
			if (count($reprogramar) == 0) {
				$datosJson = '{"data":[]}';
				echo $datosJson;
				return;
			}else{
				$datosJson = '{
				"data":[';
				foreach ($reprogramar as $key => $value) {
					if (!empty($value['linkCurso'])) {
						$acciones = "<div class='btn-group'><button class='btn btn-primary btn-sm mostrarAsistencia' data-toggle='modal' data-target='#modalAsistencia' title='Registrar asistencia' idHorarioCurso='".$value['idHorCurso']."' idPersonal='".$value['idPersonal']."'><i class='fa-solid fa-calendar-check'></i></button><button class='btn btn-dark btn-sm eliminarRep' title='Elimnar registro' idHorarioCurso='".$value['idHorCurso']."' idPersonal='".$value['idPersonal']."' idReprogramar='".$value['idReprogramacion']."' fechaRep='".$value['fechaReprogramacion']."'><i class='fa-solid fa-calendar-xmark'></i></button><a class='btn btn-danger btn-sm' href='".$value['linkCurso']."' title='Ingresar a la clase' target='_blank'><i class='fa-solid fa-link'></i></a></div>"; 
					}else{
						$acciones = "<div class='btn-group'><button class='btn btn-primary btn-sm mostrarAsistencia' data-toggle='modal' data-target='#modalAsistencia' title='Registrar asistencia' idHorarioCurso='".$value['idHorCurso']."' idPersonal='".$value['idPersonal']."'><i class='fa-solid fa-calendar-check'></i></button><button class='btn btn-dark btn-sm eliminarRep' title='Elimnar registro' idHorarioCurso='".$value['idHorCurso']."' idPersonal='".$value['idPersonal']."' idReprogramar='".$value['idReprogramacion']."' fechaRep='".$value['fechaReprogramacion']."'><i class='fa-solid fa-calendar-xmark'></i></button></button><button class='btn btn-warning btn-sm agregarLink' idHorarioCurso='".$value['idHorCurso']."' title='Registrar link'><i class='fa-solid fa-link'></i></button></div>";
					}					
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
							"'.$value['fecha'].'",
							"'.$ciclo.'",
							"'.$seccion.'",
							"'.$value['horaIngreso'].' - '.$value['horaSalida'].'",
							"'.$acciones.'"
					],';
				}
				$datosJson = substr($datosJson, 0, -1);
				$datosJson .= ']}';
				return $datosJson;			
			}
		}
		static public function ctrEliminarReprogramacion(){
			$modeloAsistencia = new ModeloAsistencia();
			if(!empty($_POST['idAsistenciaDocente'])){
				$asistencia = $modeloAsistencia->mdlEliminarAsistencia($_POST['idAsistenciaDocente']);
				if (!$asistencia) {
					return 'error';
				}
			}
			$reprogramar = $modeloAsistencia->mdlEliminarReprogramacion($_POST['idReprogramar']);
			if($reprogramar){
				return 'ok';
			}
			return ' error';
		}
		static public function ctrMostrarAsistencias(){
			if (isset($_POST['idPersonal']) && !empty($_POST['idPersonal'])) {
				$modeloAsistencia = new ModeloAsistencia();
				$asistencias = $modeloAsistencia->mdlMostrarAsistencias($_POST['idPersonal'], $_POST['txtFechaBuscar']);
				$modeloPersonal = new ModeloPersonal();
				$personal = $modeloPersonal->mdlMostrarPersonalCampo('idPersonal', $_POST['idPersonal']);
				$template = '';
				$pagoHora = 0;
				if (!empty($personal['montoPago'])) {
					$template .= "<thead>
				                <tr>
				                  <th>N°</th>
				                  <th>Supervisora</th>
				                  <th>Docente</th>
				                  <th>DNI</th>
				                  <th>Día asis.</th>
				                  <th>Curso</th>
				                  <th>Aula</th>
				                  <th>Observación</th>
				                  <th>Estado</th>
				                  <th>Tiempo</th> 
				                  <th>x hora</th>
				                  <th>Pago</th>
				                </tr>
				              </thead>";
					$pagoTotal = 0;
					$totalMin = 0;
					$totalHoras = 0; 
					$horaMaTard = $personal['montoPago'] / 50;
					$horaNoche = $personal['montoPago'] / 45;
					$horatarde = strtotime('18:30:00');
					foreach ($asistencias as $key => $value) {
						$montoPago = 0;
						$minutos = 0;
						$horasTrab = 0;
						$horaEntrada = strtotime($value['horaEntrada']);
						$horaSalida = strtotime($value['horaSalida']);
							$pagxhora = 0;
						if (($value['tipo'] == 1 || $value['tipo'] == 2) && $value['estado'] == 1) {
							if ($value['tipo'] == 1) {
								$estado = "<h4 class='badge badge-info'>VIRTUAL OK</h4>";	
							}else{
								$estado = "<h4 class='badge badge-success'>PRESENCIAL OK</h4>";
							}
							
							if ($horaEntrada < $horatarde && $horaSalida <= $horatarde) {
								$min = ($horaSalida - $horaEntrada)/60;
								$montoPago = ($horaMaTard *$min);
								$horasTrab = round(($horaSalida - $horaEntrada)/(50*60));
							}else if($horaEntrada< $horatarde && $horaSalida > $horatarde){
								$montoPago = $montoPago + ($horaMaTard *(($horatarde - $horaEntrada)/60));
								$horasTrab = round(($horatarde - $horaEntrada)/(50*60));
								$montoPago = $montoPago + ($horaNoche * (($horaSalida - $horatarde)/60));
								$horasTrab = $horasTrab + round(($horaSalida - $horatarde)/(45*60));
							}else if ($horaEntrada >= $horatarde) {
								$montoPago = ($horaNoche* (($horaSalida - $horaEntrada)/60));
								$horasTrab = round(($horaSalida - $horaEntrada)/(50*60));
							}
							$montoPago = round($montoPago, 2);
							$minutos = ($horaSalida - $horaEntrada)/60;
							$totalMin = $totalMin + $minutos;
							$totalHoras = $totalHoras + $horasTrab;
							if ($personal['tipoPago'] == 1) {
								$montoPago = 0;
								$pagxhora = 0;
							}else{
								$pagxhora = $personal['montoPago'];
							}							
							$pagoTotal = $pagoTotal + $montoPago;
						}else if($value['tipo'] == 3){
							$estado = "<h4 class='badge badge-warning'>REPROGRAMADO</h4>";
						}else{
							$estado = "<h4 class='badge badge-danger'>NO REALIZADO</h4>";
						}
						array_push($asistencias[$key], array("minutos"=>$minutos, "pago"=>$montoPago));
						$template .= "<tr>
				                        <td>".($key+1)."</td>
				                        <td>".$value['datosUsuario']."</td>
				                        <td>".$value['datos']."</td>
				                        <td>".$value['dniPersona']."</td>
				                        <td>".$value['fechaAsiste']."</td>
				                        <td>".$value['nombreCurso']."</td>
				                        <td>".$value['nombreSeccion']."</td>
				                        <td>".$value['observacion']."</td>
				                        <td>$estado</td>
				                        <td>$minutos - $horasTrab</td>
				                        <td>S/. $pagxhora</td>
				                        <td>S/. $montoPago</td>
				                    </tr>";
					}
					if ($personal['tipoPago'] == 1) {
						$pagoTotal = $personal['montoPago'];
					}
					$template .= "<tfoot class='table-dark'>
									<tr class='font-weight-bold'>
				                        <td colspan='9'>TOTAL</td>
				                        <td>$totalMin - $totalHoras</td>
				                        <td colspan='2'>S/. $pagoTotal</td>
				                    </tr>
								</tfoot>";
					return $template;
				}else{
					return 'no';
				}
			}
		}

		static public function ctrMostrarAvance($fecha, $idUsuario){
			$asistencias = '';
			$modeloAsistencia = new ModeloAsistencia();
			$asistencias = $modeloAsistencia->mdlMostrarAvance($fecha, $idUsuario);
			if (count($asistencias) == 0) {
				$datosJson = '{"data":[]}';
				echo $datosJson;
				return;
			}else{
				$datosJson = '{
				"data":[';
				foreach ($asistencias as $key => $value) {
					$acciones = "<div class='btn-group'><button class='btn btn-danger btn-sm btnEliminarAsistencia' title='eliminarRegistro' idAsistenciaDocente='".$value['idAsistenciaDocente']."'><i class='fa-solid fa-delete-left'></i></button></div>"; 
					$ciclo = "<h5><span class='badge badge-warning'>".$value['cicloSeccion']."° Ciclo</span></h5></div>"; 
					$estado = "";
					$horatarde = strtotime('18:30:00');
					$horasTrab = 0;
					if ($value['estado'] == 1) {
						$estado = "<h6><span class='badge badge-info'>VIRTUAL OK</span></h6></div>"; 
						$horaEntrada = strtotime($value['horaEntrada']);
						$horaSalida = strtotime($value['horaSalida']);
						if ($horaEntrada < $horatarde && $horaSalida <= $horatarde) {
							$min = ($horaSalida - $horaEntrada)/60;
							$horasTrab = round(($horaSalida - $horaEntrada)/(50*60));
						}else if($horaEntrada< $horatarde && $horaSalida > $horatarde){
							$horasTrab = round(($horatarde - $horaEntrada)/(50*60));
							$horasTrab = $horasTrab + round(($horaSalida - $horatarde)/(45*60));
						}else if ($horaEntrada >= $horatarde) {
							$horasTrab = round(($horaSalida - $horaEntrada)/(50*60));
						}						
					}else if($value['tipo'] == 2){
						$estado = "<h6><span class='badge badge-success'>PRESENCIAL</span></h6></div>"; 
					}else if($value['tipo'] == 3){
						$estado = "<h6><span class='badge badge-warning'>REPROGRAMADO</span></h6></div>"; 
					}else if($value['tipo'] == 4){
						$estado = "<h6><span class='badge badge-danger'>NO REALIZÓ</span></h6></div>"; 
					}
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
							"'.$estado.'",
							"'.$value['horaEntrada'].' - '.$value['horaSalida'].'",
							"'.$horasTrab.'",
							"'.$acciones.'"
					],';
				}
				$datosJson = substr($datosJson, 0, -1);
				$datosJson .= ']}';
				return $datosJson;			
			}
		}
		static public function ctrEliminarAsistencia($idAsistenciaDocente){
			$modeloAsistencia = new ModeloAsistencia();
			$respuesta = $modeloAsistencia->mdlEliminarAsistencia($idAsistenciaDocente);
			if ($respuesta) {
				return 'ok';
			}
			return 'no';
		}

		static public function ctrEditarLink($link, $idHorarioCurso){
			$modeloAsistencia = new ModeloAsistencia();
			$respuesta = $modeloAsistencia->mdlEditarLink($link, $idHorarioCurso);
			if ($respuesta) {
				return 'ok';
			}
			return 'error';	
		}
	}