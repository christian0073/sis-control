<?php 
	$url= $_SERVER["REQUEST_URI"];
	$components = parse_url($url);
	if (!isset($components['query'])) {
		header('location: inicio');
		return;		
	}
	parse_str($components['query'], $archivo); 
	require 'dompdf/vendor/autoload.php';
	use Dompdf\Dompdf;
	use Dompdf\Options;
	if (isset($archivo['idPersonal']) && !empty($archivo['idPersonal'])) {
		$idPersonal = $archivo['idPersonal'];
		$idPeriodo = $_SESSION['idPeriodo'];
		$modeloDocenteHorario = new ModeloCursoHorario();
		$horario = $modeloDocenteHorario->mdlDocenteHorario($idPersonal, $idPeriodo);
		$arrData = [];
		if (empty($horario)) {
			return 'no';
		}
		$horasSemana = ControladorCursoHorario::ctrMostrarHorasDocente($idPersonal);
		$modeloPersonal = new ModeloPersonal();
		$personal = $modeloPersonal->mdlMostrarPersonalCampo('idPersonal', $idPersonal);
		$horaInicio =	$horario[0]['horaEntrada'];
		$horaTarde = strtotime('13:30');
		$horaExtraordinario = strtotime('07:00');
		$horaTarde0 = strtotime($horaInicio);
		$arrHoras = [];
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
		$campo = "<td><div></div></td>";
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
								"rangoHora"=> date("H:i", $horaTemporal0).' - '.date("H:i", $horaTemporal), "horaEntrada" => $horaTemporal0, "horaSalida" => $horaTemporal, "dia1"=>$campo,
								"dia2"=>$campo,"dia3"=>$campo,"dia4"=>$campo,"dia5"=>$campo,"dia6"=>$campo
							);
			if ($horaTemporal0 == $horaFin) {
				$horasAc = false;
				break;
			}
			$horaTemporal0 = $horaTemporal;
			array_push($arrHoras, $rangoHora);
			$horasAc++;
		}
		$contNumero=0;

			$tipoCurso = '';
			$color = '';
			foreach ($horario as $key => $value) {
				foreach ($arrHoras as $key => $value1) {
					$horaEntrada1 = strtotime($value['horaEntrada']);
					$horaSalida1 = strtotime($value['horaSalida']);
					if ($value1['horaEntrada'] == $horaEntrada1) {
						if($value['tipo'] == 'T'){
							$tipoCurso = 'TEÓRICA';
							$color = 'teorica';
						}elseif ($value['tipo'] == 'P') {
							$tipoCurso = 'PRÁCTICA';
							$color = 'practica';
						}
						$trozos = explode(" ", $value['nombreCarrera']);
						$contar = count($trozos);
						$nombre = '';
						for ($i=0; $i < $contar ; $i++) { 
							$nombre .= substr($trozos[$i], 0, 3).". ";
						}
						//$nombre .= "- ".$value['periodo']." - ".mb_strtoupper($value['nombreSede'], 'UTF-8')."<br>".$value['nombreCurso']." SECCIÓN ".$value['nombreSeccion']." (".$tipoCurso.")";
						$nombre .= " ".$value['nombreSeccion']." ".mb_strtoupper($value['nombreSede'], 'UTF-8')."<br>".$value['nombreCurso']."<br>(".$tipoCurso.")";
						$datos =$nombre;

						$dia = $value['dia'];
						$campo1 = "<td rowspan='".$value['horas']."' class='".$color."'>$nombre</td>";
						$arrHoras[$key]['dia'.$dia]= $campo1;
					}
					if ($value1['horaEntrada'] > $horaEntrada1 &&$value1['horaSalida'] <= $horaSalida1) {
						unset($arrHoras[$key]['dia'.$dia]);
					}
				}
			}





		ob_start();
	    include('vistas/paginas/pdf/horario-docente.php');
	    $html = ob_get_clean();

		// instantiate and use the dompdf class
		$options = new Options();
		$options->set('isRemoteEnabled', TRUE);
		$dompdf = new Dompdf($options);

		$dompdf->loadHtml($html);
		// (Optional) Setup the paper size and orientation
		$dompdf->setPaper('A4', 'landscape');
		// Render the HTML as PDF
		$dompdf->render();
		// Output the generated PDF to Browser
		$dompdf->stream('ficha.pdf',array('Attachment'=>0));
	}else{
		header('location: inicio');
		return;
	}

 ?>