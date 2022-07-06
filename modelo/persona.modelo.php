<?php 
	require_once "consultas.php";
 	Class ModeloPersona{
 		private $idPersona;
 		private $nombresPersona;
 		private $apellidoPaterno;
 		private $apellidoMaterno;
 		private $dniPersona;
 		/* constructor que hereda los metodos de la clase consulta */
		public function __construct(){
			$this->consulta = new Consultas();
		}
		/* metodo que devuelva todos los datos de una persona */
		public function mdlMostrarPersonaCampo($item, $valor){
			$sql = "SELECT * FROM personas WHERE $item = '$valor' LIMIT 1";
		   	$respuesta = $this->consulta->select($sql);
		   	return $respuesta;				
		}
		public function mdlRegistrarPersona($dniPersona, $nombresPersona, $apellidoPaterno, $apellidoMaterno){
			$this->dniPersona = $dniPersona;
			$this->nombresPersona = $nombresPersona;
			$this->apellidoPaterno = $apellidoPaterno;
			$this->apellidoMaterno = $apellidoMaterno;
			$sql = "SELECT idPersona FROM personas  WHERE dniPersona = $this->dniPersona LIMIT 1";
			$respuesta = $this->consulta->select($sql);
			if (empty($respuesta)) {
				$sql = "INSERT INTO personas(dniPersona, nombresPersona, apellidoPaternoPersona, apellidoMaternoPersona) VALUES(?,?,?,?)";
				$arrData = array($this->dniPersona, $this->nombresPersona, $this->apellidoPaterno, $this->apellidoMaterno); 
				$respuesta = $this->consulta->insert($sql, $arrData);
			}else{
				$respuesta = $respuesta['idPersona'];
			}
			return $respuesta;
		}
	}