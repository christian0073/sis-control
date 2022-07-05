<?php 
	Class ControladorPlan{
		/* funcion que retorna el plan actual */
		static public function ctrVerPlanACtivo(){
			$modeloSede = new ModeloPlan();
			$respuesta = $modeloSede->mdlVerPlanActivo();
			return $respuesta;
		}
	}