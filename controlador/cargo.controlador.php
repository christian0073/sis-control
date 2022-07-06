<?php 
	class ControladorCargo {
		/* metodo para mostrar todos los cargos activos*/
		static public function ctrMostrarCargos(){
			$modeloCargo = new ModeloCargo();
			$respuesta = $modeloCargo->mdlMostrarCargos();
			return $respuesta;
		}
	}
