<?php 
	require_once "consultas.php";
 	Class ModeloPlan{
 		private $nombrePlan;
 		private $estadoPlan;
 		/* constructor que hereda los metodos de la clase consulta */
		public function __construct(){
			$this->consulta = new Consultas();
		}
		/*METODO QUE MUESTRA EL PLAN ACTIVO */
		public function mdlVerPlanActivo(){
			$sql = "SELECT * FROM plan_lectivo WHERE estadoPlan = TRUE LIMIT 1";
		   	$respuesta = $this->consulta->select($sql);
		   	return $respuesta;				
		}
 	}