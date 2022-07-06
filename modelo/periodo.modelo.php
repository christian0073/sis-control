<?php 
	require_once "consultas.php";
	Class ModeloPeriodo{
		private $idPeriodo;
		private $nombrePeriodo;
		private $yearPeriodo;
		private $etapaPeriodo;
		private $fechaInicio;
		private $fechaFin;

 		/* constructor que hereda los metodos de la clase consulta */
		public function __construct(){
			$this->consulta = new Consultas();
		}
		/* metodo para registrar nuevo periodo */
		public function mdlRegistrarPeriodo($yearPeriodo, $etapaPeriodo, $nombrePeriodo, $fechaInicio, $fechaFin){
			$this->yearPeriodo = $yearPeriodo;
			$this->etapaPeriodo = $etapaPeriodo;
			$this->nombrePeriodo = $nombrePeriodo;
			$this->fechaInicio = $fechaInicio;
			$this->fechaFin = $fechaFin;
			$sql = "SELECT idPeriodo FROM periodos  WHERE nombrePeriodo = '$this->nombrePeriodo' OR estadoPeriodo = TRUE LIMIT 1";
			$respuesta = $this->consulta->select($sql);
			if (empty($respuesta)) {
				$sql = "INSERT INTO periodos(etapaPeriodo, yearPeriodo, nombrePeriodo, fechaInicio, fechaFin) VALUES(?,?,?,?,?)";
				$arrData = array($this->etapaPeriodo, $this->yearPeriodo, $this->nombrePeriodo, $this->fechaInicio, $this->fechaFin); 
				$respuesta = $this->consulta->insert($sql, $arrData);
			}else{
				$respuesta = "existe";
			}
			return $respuesta;
		}
		/* metodo que muestra los periodos existentes */
		public function mdlMostrarPeriodos(){
			$sql = "SELECT periodos.*, DATE_FORMAT(fechaInicio, '%m-%d-%y') AS fechaIn, DATE_FORMAT(fechaFin, '%m-%d-%y') AS fechaFi FROM periodos ORDER BY yearPeriodo, etapaPeriodo DESC";
		   	$respuesta = $this->consulta->selectAll($sql);
		   	return $respuesta;				
		}
		/* metodo para mostrar los datos de un periodo */
		public function mdlMostrarPeriodo($idPeriodo){
			$this->idPeriodo = $idPeriodo;
			$sql = "SELECT * FROM periodos WHERE idPeriodo = $this->idPeriodo LIMIT 1";
		   	$respuesta = $this->consulta->select($sql);
		   	return $respuesta;				
		}
		/* metodo para editar un periodo */
		public function mdlEditarPeriodo($yearPeriodo, $etapaPeriodo, $nombrePeriodo, $fechaInicio, $fechaFin, $idPeriodo){
			$this->yearPeriodo = $yearPeriodo;
			$this->etapaPeriodo = $etapaPeriodo;
			$this->nombrePeriodo = $nombrePeriodo;
			$this->fechaInicio = $fechaInicio;
			$this->fechaFin = $fechaFin;
			$this->idPeriodo = $idPeriodo;
			$sql = "SELECT idPeriodo FROM periodos where nombrePeriodo = '$this->nombrePeriodo' AND idPeriodo != $this->idPeriodo LIMIT 1";
			$respuesta = $this->consulta->select($sql);
			if (!empty($respuesta)) {
				$respuesta = 'existe';
			}else{
				$sql1 = "UPDATE periodos SET  etapaPeriodo = ?, yearPeriodo=?, nombrePeriodo = ?, fechaInicio = ?, fechaFin = ?
						WHERE idPeriodo = $this->idPeriodo";
				$arrData = array($this->etapaPeriodo, $this->yearPeriodo, $this->nombrePeriodo, $this->fechaInicio, $this->fechaFin); 
				$respuesta = $this->consulta->update($sql1, $arrData);

			}
			return $respuesta;
		}
		/* metodo para mostrar los datos de un periodo por un campo y valor */
		public function mdlMostrarPeriodoCampo($item, $valor){
			$sql = "SELECT * FROM periodos WHERE $item = '$valor' LIMIT 1";
		   	$respuesta = $this->consulta->select($sql);
		   	return $respuesta;				
		}
		/* metodo para editar un solo campo  */
		public function mdlEditarPeriodoCampo($idPeriodo, $item, $valor){
			$this->idPeriodo = $idPeriodo;
			$sql = "UPDATE periodos  SET  $item = ?
					WHERE idPeriodo = $this->idPeriodo";
			$arrData = array($valor); 
			$respuesta = $this->consulta->update($sql, $arrData);
			return $respuesta;		
		}
	}