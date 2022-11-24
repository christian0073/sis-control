<?php 
	function buscarPersona($dni){
		$token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyX2lkIjoxMjUsImNvcnJlbyI6ImNocmlzdGlhbi52aWxjYUBpbnN0aXR1dG9maWJvbmFjY2kuY29tIiwiaWF0IjoxNjUyMzkwNDgzfQ.F2EMP-bvyjMij-8EOtK3rQrjYaLUGYy4WNZ1bVv1vOU";
		$dni = json_encode(array("dni"=>$dni));
		/* Iniciamos la API */
		$curl = curl_init();
		/* Comenzamos con la busqueda */
		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://www.dayangels.xyz/api/reniec/reniec-dni',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 2,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
		    CURLOPT_POSTFIELDS => $dni,
			CURLOPT_HTTPHEADER => array(
				'Authorization: Bearer '.$token,
				'Content-Type: application/json',
        		'Content-Length: ' . strlen($dni)
				),	
		));
		$respuesta = json_decode(curl_exec($curl), true);
		curl_close($curl);
		return $respuesta;
	}

	function validarFecha($fecha){
		$valores = explode('-', $fecha);
		if(count($valores) == 3 && checkdate($valores[1], $valores[2], $valores[0])){
			return true;
	    }
		return false;
	}	
	function buscarPersona1($dni){
		$persona = json_decode( file_get_contents('https://dniruc.apisperu.com/api/v1/dni/'.$dni.'?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6ImNocmlzdGlhbi52aWxjYUBpbnN0aXR1dG9maWJvbmFjY2kuY29tIn0.ZX3D5fmBOwmq_SPjVseUC4JWygn1cTaOaN1iF-S1JfM'), true );
		$respuesta = '';
		if (isset($persona['dni'])) {
			$respuesta = array("paterno" => $persona['apellidoPaterno'], "materno" => $persona['apellidoMaterno'], "nombres" => $persona['nombres']);
		}

		return $respuesta;
	}

	function cuenta_dias($fecha, $cantidadHoras, $diaFin, $diaInicio = 1){
		$dias = ["Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado", "Domingo"];
		$cantDias = [];
	    $count=0;
	    $totalHoras = 0;
	    foreach ($cantidadHoras as $key => $value) {
	    	for($i = $diaInicio; $i < $diaFin; $i++){
			    if(date('N',strtotime($fecha.'-'.$i))==$value['dia']){
			    	$count++;
			    }
		    }
		    $totalHoras += $count * $value['horasDia'];
		    $count = 0;
	    }
	    return $totalHoras;
	}
	function contarHoras($arrDiasHoras){
		$cont = 0;
		foreach ($arrDiasHoras as $key => $value) {
			$cont += $value['horasDia'];
		}
		return $cont;
	}
	/* funcion para contar las horas del mes */
	function calcularHorasMes($arrHorasMes, $fecha, $dt){
		$count = count($arrHorasMes);
		$horasTotales = 0;
		$i = 0;
		do {
			$cantHorasTemp = json_decode($arrHorasMes[$i]['diasHoras'], true);
			if (isset($arrHorasMes[$i+1]['fechaHoras'])) {
				$diaInicio = new DateTime($arrHorasMes[$i]['fechaHoras']);
				$diaFin = new DateTime($arrHorasMes[$i+1]['fechaHoras']);
				$horasTotales += cuenta_dias($fecha, $cantHorasTemp, $diaFin->format('d'), $diaInicio->format('d'));
			}else{
				$dias_mes=cal_days_in_month(CAL_GREGORIAN, $dt->format('m'), $dt->format('Y'));		
				$diaInicio = new DateTime($arrHorasMes[$i]['fechaHoras']);
				$horasTotales += cuenta_dias($fecha, $cantHorasTemp, $dias_mes+1, $diaInicio->format('d'));
			}
			$i++;			
		} while ($i < $count);
		return $horasTotales;
	}
	/* función para mostrar e historial de horas */
	function historialHoras($dt, $arrHorasMes, $fechaCorta){
		$template = '';
		$diferencia = 0;
		$i = 0;
		$count = count($arrHorasMes);
		$horasTotales = 0;
		do {
			$cantHorasTemp = json_decode($arrHorasMes[$i]['diasHoras'], true);
			$fecha = $arrHorasMes[$i]['fechaHoras'];
			if (isset($arrHorasMes[$i+1]['fechaHoras'])) {
				$mensaje = "Las horas se mantuvieron constante";
				$diaInicio = new DateTime($arrHorasMes[$i]['fechaHoras']);
				$diaFin = new DateTime($arrHorasMes[$i+1]['fechaHoras']);
				$horasTotales += cuenta_dias($fechaCorta, $cantHorasTemp, $diaFin->format('d'), $diaInicio->format('d'));
				$cantHorasTemp2 = json_decode($arrHorasMes[$i+1]['diasHoras'],true);
				if ($i > 0) {
					$diferencia = contarHoras($cantHorasTemp) - contarHoras($cantHorasTemp2);
					if ( $diferencia < 0) {
						$mensaje = "Se incremento ".abs($diferencia)." horas semaneles";
					}else if ($diferencia > 0) {
						$mensaje = "Se redujo ".$diferencia." horas semaneles";
					}					
				}
				$template .= crearTemplateHistorial($horasTotales, $cantHorasTemp, $fecha, $mensaje, $diaFin->format('Y-m-d'));
			}else{
				$mensaje = "Las horas se mantuvieron constante";
				if (isset($arrHorasMes[$i-1]['fechaHoras'])) {
					$cantHorasTemp2 = json_decode($arrHorasMes[$i-1]['diasHoras'],true);
					$diferencia = contarHoras($cantHorasTemp) - contarHoras($cantHorasTemp2);					
					if ( $diferencia > 0) {
						$mensaje = "Se aumento ".$diferencia." horas semaneles";
					}else if ($diferencia < 0) {
						$mensaje = "Se redujo ".abs($diferencia)." horas semaneles";
					}
				}
				$dias_mes=cal_days_in_month(CAL_GREGORIAN, $dt->format('m'), $dt->format('Y'));		
				$diaInicio = new DateTime($arrHorasMes[$i]['fechaHoras']);
				$horasTotales += cuenta_dias($fechaCorta, $cantHorasTemp, $dias_mes+1, $diaInicio->format('d'));
				$template .= crearTemplateHistorial($horasTotales, $cantHorasTemp, $fecha, $mensaje, $dt->format('Y-m').'-'.$dias_mes);
			}
			$i++;
		} while ($i < $count);
	    return $template;                
	}

	function crearTemplateHistorial($cantHoras, $cantHorasTemp, $fecha, $mensaje, $fechaFin){
		$fechaLarga = strftime("%d de %B de %Y", strtotime($fecha));
		$fechaLarga2 = strftime("%d de %B de %Y", strtotime($fechaFin));
		$dias = ["Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado", "Domingo"];
		$template = "<li class='timeline-item bg-white rounded ml-3 p-4 lista-anuncio'>
	                <div class='timeline-arrow'></div>
	                <h2 class='h6 mb-0'>$cantHoras Horas</h2><span class='small text-gray'><i class='fa-regular fa-clock mr-1'></i> $fechaLarga <strong>hasta</strong> $fechaLarga2</span>
	                <p class=''>$mensaje</p>
	                <ul class='list-group list-group-unbordered' >";
        $totalHoras = 0;
	                foreach ($cantHorasTemp as $key => $value) {
	                	$totalHoras += $value['horasDia'];
	                	$dia = $dias[$value['dia']-1];
	                	$template .= "
		                          <li class='list-group-item'>
		                            <span><i class='fa-solid fa-calendar-day'></i> $dia</span> <a class='float-right'>".$value['horasDia']." horas</a>
		                          </li>";
	                }
	                $template .=" 
	                			<li class='list-group-item'>
		                            <span><i class='fa-regular fa-hourglass-half'></i> Total de horas semanales</span> <a class='float-right'>".$totalHoras." horas</a>
		                          </li>
		                        </ul>
		                    </li>";
		return $template;
	}
	
 ?>