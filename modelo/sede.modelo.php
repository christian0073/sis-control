<?php 
	require_once "consultas.php";
 	Class ModeloSede{
 		private $nombreSede;
 		private $idSede;
 		/* constructor que hereda los metodos de la clase consulta */
		public function __construct(){
			$this->consulta = new Consultas();
		}
		/* metodo para registrar nueva sede */
		public function mdlRegistrarSede($nombreSede){
			$this->nombreSede = $nombreSede;
			$sql = "INSERT INTO sedes(nombreSede) VALUES (?)";
			$arrData = array($nombreSede); 
			$respuesta = $this->consulta->insert($sql, $arrData);	
			return $respuesta;
		}
		/* metodo que devuelva todas las sedes registradas */
		public function mdlMostrarSedes(){
			$sql = "SELECT * FROM sedes ORDER BY nombreSede ASC";
		   	$respuesta = $this->consulta->selectAll($sql);
		   	return $respuesta;				
		}

 	}