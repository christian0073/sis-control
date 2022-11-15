<?php
	date_default_timezone_set("America/Lima");
	require_once "../controlador/asistencia.controlador.php";
	require_once "../modelo/asistencia.modelo.php";

	require_once "../modelo/personal.modelo.php";

	require_once "../helpers/funciones.php";

	/* condiciópn ajax para registrar nuevo carrera*/
	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'mostrarAsistencia2') {		
		$respuesta = ControladorAsistencia::ctrMostrarAsistencias();
		if ($respuesta!='no' && !empty($respuesta)) {
			$cantidadHoras = ControladorAsistencia::ctrCantidadHorasDia($_POST['idPersonal']);
			$horasDocentes = [];
			$idPersonal = $cantidadHoras[0]['idPersonalHor'];
			$arrTemp = [];
			$totalCantidad = count($cantidadHoras);
			$cont = 0;
			do {
				$fila = ['dia'=> $cantidadHoras[$cont]['dia'], 'horasDia'=>$cantidadHoras[$cont]['horasDia']];
				array_push($arrTemp, $fila);
				//echo '<pre>'; print_r($arrTemp); echo '</pre>';
				if (isset($cantidadHoras[($cont+1)]['idPersonalHor'])) {
					if ($idPersonal != $cantidadHoras[($cont+1)]['idPersonalHor']) {
						$cantHoras = cuenta_dias($_POST['txtFechaBuscar'], $arrTemp);
						$filas2 = [$idPersonal, ($_POST['txtFechaBuscar'].'-01'), $cantHoras];
						array_push($horasDocentes, $filas2);
						$arrTemp = [];
						$idPersonal = $cantidadHoras[($cont+1)]['idPersonalHor'];
					}
				}else{
					break;
				}
				$cont++;
			} while ($cont < $totalCantidad);
			$insert = new ModeloAsistencia();
			$si = $insert->mdlRegistrarHorasDocente($horasDocentes);
			if ($si) {
				echo "ok";
			}
			
			//$cantHoras = cuenta_dias($_POST['txtFechaBuscar'], $cantidadHoras);
			//$respuestaArr = ['cantidadHoras'=>$cantHoras, 'tabla'=>$respuesta];
			//echo json_encode($respuestaArr);
		}else{
			echo json_encode($respuesta);
		}
	}
	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'registrarAsistencias') {
		if (isset($_FILES['fileAsistencia']) && !empty($_FILES['fileAsistencia'])) {
			require_once "../PHPExcel/Classes/PHPExcel.php";
			$nombreTemp = $_FILES['fileAsistencia']['tmp_name'];
			$leerExcel = PHPExcel_IOFactory::createReaderForFile($nombreTemp);
			$excelObj = $leerExcel->load($nombreTemp);
			$hoja = $excelObj->getSheet(0);
			$filas = $hoja->getHighestRow();
			$template = "<table>
				<thead>
					<tr>
						<td>Local</td>
						<td>Nombre</td>
						<td>No.</td>
						<td>Fecha</td>
						<td>Inicio - Fin</td>
						<td>Horas</td>
					</tr>
				</thead>
				<tbody>";
			$dep1 = $hoja->getCell('A1')->getValue();
			if ($dep1 == 'Department') {
				$fil1 = 2;
				$totalHoras = 0;
				$horatarde = strtotime('18:30:00');
				for ($i=1; $i < $filas; $i++) { 
				$fil = $i+1;
				$dep = $hoja->getCell('A'.$fil)->getValue();
				$nombre = $hoja->getCell('B'.$fil)->getValue();
				$nro = $hoja->getCell('C'.$fil)->getValue();
				$id = $hoja->getCell('E'.$fil)->getValue();
				$fecha = $hoja->getCell('D'.$fil)->getValue();
				$unixDT=($fecha - 25569) * 86400;

				$horaInicio = '';
				$horaInicio1 = '';
				#Convertimos a GMT
				$gmtDate= gmdate("d-m-Y H:i:s", $unixDT);
				#Creamos un objeto DateTime para trabajr con él
				$mDate = new DateTime($gmtDate);
				$fechaAsist = $mDate->format("Y-m-d").PHP_EOL; 
				if ($fil%2==0) {
					$horaInicio1 = $mDate->format("H:i:s").PHP_EOL;
					$numHora1 = strtotime($horaInicio1);
					$horas = $horaInicio1.' - '; 
					$fecha1 = $fechaAsist;
					$fil1++;
					
				}else{
					$horasTrab = 0;
					if ($fechaAsist == $fecha1) {
						$fechaAs = $mDate->format("d/m/Y").PHP_EOL; 
						$horaInicio = $mDate->format("H:i:s").PHP_EOL;
						$horas .= $horaInicio;
						$numHora = strtotime($horaInicio);
						if ($numHora > $numHora1) {								
							if ($numHora1 < $horatarde && $numHora <= $horatarde) {
								$horasTrab = round(($numHora - $numHora1)/(50*60));
							}else if($numHora1< $horatarde && $numHora > $horatarde){
								$horasTrab = round(($horatarde - $numHora1)/(50*60));
								$horasTrab = $horasTrab + round(($numHora - $horatarde)/(45*60));
							}else if ($numHora1 >= $horatarde) {
								$horasTrab = round(($numHora - $numHora1)/(50*60));
							}
						}

					}
					$totalHoras = $totalHoras + $horasTrab;
					$template .= "<tr>
									<td>$dep</td>
									<td>$nombre</td>
									<td>$nro</td>
									<td>$fechaAs</td>
									<td>$horas</td>
									<td>$horasTrab</td>
								</tr>";

					}
				}	
				$template .= "</tbody>
							<tfoot class='table-dark'>
								<tr class='font-weight-bold'>
									<td colspan='5'>TOTAL</td>
									<td>$totalHoras</td>
								</tr>
							</tfoot>
							</table>";
				echo $template;
			}else{
				echo "error";
				exit();
			}

		}
	}