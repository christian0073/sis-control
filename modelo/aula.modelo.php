<?php 
	require_once "consultas.php";
	Class ModeloAula{
		private $idAula;
		private $idLocalidadAula;
		private $idPeriodoAula;
		private $nombreAula;
		private $turnoAula;
		private $cicloAula;
		private $aforoAula;
 		/* constructor que hereda los metodos de la clase consulta */
		public function __construct(){
			$this->consulta = new Consultas();
		}
		/* metodo para registrar nuevo periodo */
		public function mdlRegistrarAula($idLocalidadAula, $idPeriodoAula, $nombreAula, $turnoAula, $cicloAula){
			$this->idLocalidadAula = $idLocalidadAula;
			$this->idPeriodoAula = $idPeriodoAula;
			$this->nombreAula = $nombreAula;
			$this->turnoAula = $turnoAula;
			$this->cicloAula = $cicloAula;
			$sql = "SELECT idSeccion FROM seccion  WHERE nombreSeccion = '$this->nombreAula' AND turno = '$this->turnoAula' AND cicloSeccion = '$this->cicloAula' AND estado = TRUE AND idSeccionLocal = $this->idLocalidadAula AND idPeriodoSeccion = $this->idPeriodoAula LIMIT 1";
			$respuesta = $this->consulta->select($sql);
			if (empty($respuesta)) {
				$sql = "INSERT INTO seccion(idSeccionLocal, idPeriodoSeccion, nombreSeccion, turno, cicloSeccion) VALUES(?,?,?,?,?)";
				$arrData = array($this->idLocalidadAula, $this->idPeriodoAula, $this->nombreAula, $this->turnoAula, $this->cicloAula); 
				$respuesta = $this->consulta->insert($sql, $arrData);
			}else{
				$respuesta = "existe";
			}
			return $respuesta;
		}
		/* mostrar tabla de aulas */
		public function mdlMostrarAulas($idPeriodo, $idSede, $idCarrera){
			$consulta = '';
			if (!empty($idCarrera)) {
				$consulta = "idLocalCarrera = $idCarrera AND estadoPeriodo = TRUE";
				if (!empty($idPeriodo)) {
					$consulta = "idLocalCarrera = $idCarrera AND idPeriodoSeccion = $idPeriodo";
				}
			}else if (!empty($idPeriodo) && !empty($idSede)) {
				$consulta = "idPeriodoSeccion = $idPeriodo AND idSedeLocal = $idSede";
			}else if (!empty($idSede)) {
				$consulta = "estadoPeriodo = TRUE AND idSedeLocal = $idSede";
			}else if (!empty($idPeriodo)) {
				$consulta = "idPeriodoSeccion = $idPeriodo";
			}else{
				$consulta = "estadoPeriodo = TRUE";
			}
			$sql = "SELECT seccion.*, nombrePeriodo, estadoPeriodo, idLocalCarrera, nombreCarrera, direccion FROM seccion 
				INNER JOIN periodos ON idPeriodoSeccion = idPeriodo
				INNER JOIN local_carrera ON idSeccionLocal = idLocalCarrera
				INNER JOIN carreras ON local_carrera.idCarrera = carreras.idCarrera
				INNER JOIN locales ON local_carrera.idLocal = locales.idLocal 
				WHERE $consulta ORDER BY nombreCarrera, cicloSeccion, turno ASC;";
		   	$respuesta = $this->consulta->selectAll($sql);
		   	return $respuesta;	
		}
		/* metodo que muestro todos los datos de un solo aula por ID */
		public function mdlMostrarAulaId($idAula){
			$this->idAula = $idAula;
			$sql = "SELECT seccion.*, nombrePeriodo, direccion, nombreCarrera FROM seccion 
				INNER JOIN periodos ON idPeriodoSeccion = idPeriodo
				INNER JOIN local_carrera ON idSeccionLocal = idLocalCarrera 
				INNER JOIN locales ON local_carrera.idLocal = locales.idLocal
				INNER JOIN carreras ON local_carrera.idCarrera = carreras.idCarrera
				WHERE idSeccion = $this->idAula AND seccion.estado = TRUE LIMIT 1";
			$respuesta = $this->consulta->select($sql);
			return $respuesta;
		}
		public function mdlEditarAula($nombreAula, $turnoAula, $cicloAula, $idAula, $idPeriodo, $idLocalidadAula){
			$this->nombreAula = $nombreAula;
			$this->turnoAula = $turnoAula;
			$this->cicloAula = $cicloAula;
			$this->idAula = $idAula;
			$sql = "SELECT idSeccion FROM seccion 
				WHERE nombreSeccion = '$this->nombreAula' AND turno = '$this->turnoAula' AND cicloSeccion = $this->cicloAula AND idPeriodoSeccion = $idPeriodo AND idSeccionLocal = $idLocalidadAula AND idSeccion != $this->idAula AND estado = TRUE LIMIT 1;";
			$respuesta = $this->consulta->select($sql);
			$respuesta1= '';
			if (!empty($respuesta)) {
				$respuesta1 = 'existe';
			}else{
				$sql1 = "UPDATE seccion  SET  nombreSeccion = ?, turno = ?, cicloSeccion = ?
						WHERE idSeccion = $this->idAula";
				$arrData = array($this->nombreAula, $this->turnoAula, $this->cicloAula); 
				$respuesta1 = $this->consulta->update($sql1, $arrData);
			}
			return $respuesta1;
		}
		/* metodo para editar un campo de un aula */
		public function mdlEditarAulaCampo($item, $valor, $idAula){
			$this->idAula = $idAula;
			$sql = "UPDATE seccion  SET  $item = ?
					WHERE idSeccion = $this->idAula";
			$arrData = array($valor); 
			$respuesta = $this->consulta->update($sql, $arrData);
			return $respuesta;
		}
	}