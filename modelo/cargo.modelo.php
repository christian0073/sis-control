<?php 
	Class ModeloCargo{
		private $nombreCargo;

 		/* constructor que hereda los metodos de la clase consulta */
		public function __construct(){
			$this->consulta = new Consultas();
		}

		public function mdlMostrarCargos(){
			$sql = "SELECT * FROM cargos
					ORDER BY nombreCargo ASC";
		   	$respuesta = $this->consulta->selectAll($sql);
		   	return $respuesta;	
		}
	}