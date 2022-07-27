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
		$respuesta = array("paterno" => $persona['apellidoPaterno'], "materno" => $persona['apellidoMaterno'], "nombres" => $persona['nombres']);
		return $respuesta;
	}
 ?>