<?php 
	class ControladorPersona {
		/* metodo para mostrar todos loe cursos de un aula */
		static public function ctrMostrarPersonaDni($dni){
			$item = 'dniPersona';
			$modeloPersona = new ModeloPersona();
			$persona = $modeloPersona->mdlMostrarPersonaCampo($item, $dni);
			if (!empty($persona)) {
				$persona = array("paterno" => $persona['apellidoPaternoPersona'], "materno" => $persona['apellidoMaternoPersona'], "nombres" => $persona['nombresPersona']);
			}
			return $persona;
		}
	}