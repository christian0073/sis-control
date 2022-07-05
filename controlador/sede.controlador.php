<?php 
	Class ControladorSede{
		/* metodo par registrar una nueva sede*/
		static public function ctrRegistrarSede($nombreSede){
			if (isset($nombreSede)) {
				if (preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $nombreSede)) {
					$modeloSede = new ModeloSede();
					$idSede  = $modeloSede->mdlRegistrarSede($nombreSede);
					if ($idSede > 0) {
						return 'ok';
					}
					return 'error';
				}else{
					return 'no';
				}
			}
		}
		/* funcion que retorna todas las sedes registradas */
		static public function ctrMostrarSedes(){
			$modeloSede = new ModeloSede();
			$respuesta = $modeloSede->mdlMostrarSedes();
			return $respuesta;
		}
	}