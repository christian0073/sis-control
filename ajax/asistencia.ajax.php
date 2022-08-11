<?php
	date_default_timezone_set("America/Lima");
	require_once "../controlador/asistencia.controlador.php";
	require_once "../modelo/asistencia.modelo.php";

	require_once "../modelo/personal.modelo.php";
	/* condiciópn ajax para registrar nuevo carrera*/
	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'mostrarAsistencia') {
		$respuesta = ControladorAsistencia::ctrMostrarAsistencias();
		echo $respuesta;
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
						<td>Department</td>
						<td>Name</td>
						<td>No.</td>
						<td>fecha</td>
						<td>Inicio - Fin</td>
						<td>Location ID</td>
					</tr>
				</thead>
				<tbody>";
			$dep1 = $hoja->getCell('A1')->getValue();
			if ($dep1 == 'Department') {
				$fil1 = 2;
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
					$horaInicio = $mDate->format("H:i:s").PHP_EOL;
					$horas = $horaInicio.' - '; 
					$fecha1 = $fechaAsist;
					$fil1++;
					
				}else{
					if ($fechaAsist == $fecha1) {
						$horaInicio = $mDate->format("H:i:s").PHP_EOL;
						$horas .= $horaInicio;
					}else{
						$horaInicio = $mDate->format("H:i:s").PHP_EOL;
						$horas = ' - '.$horaInicio;
						$fil1--;
					}
					$template .= "<tr>
									<td>$dep</td>
									<td>$nombre</td>
									<td>$nro</td>
									<td>$fecha1</td>
									<td>$horas</td>
									<td>$id</td>
								</tr>";

					}
				}	
				$template .= "</tbody></table>";
				echo $template;
			}else{
				echo "error";
				exit();
			}

		}
	}