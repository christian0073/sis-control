<?php 
	require_once "consultas.php";
 	Class ModeloCarrera{
 		private $nombreCarrera;
 		private $idCarrera;
 		/* constructor que hereda los metodos de la clase consulta */
		public function __construct(){
			$this->consulta = new Consultas();
		}
		/* metodo para registrar nueva Carrera */
		public function mdlRegistrarCarrera($idPlan, $nombreCarrera){
			$this->nombreCarrera = $nombreCarrera;
			$sql = "SELECT idCarrera FROM carreras WHERE nombreCarrera = '$this->nombreCarrera' AND idPlanCarrera = '$idPlan' LIMIT 1";
			$respuesta = $this->consulta->select($sql);
			if (empty($respuesta)) {
				$sql = "INSERT INTO carreras (idPlanCarrera, nombreCarrera) VALUES(?,?)";
				$arrData = array($idPlan, $this->nombreCarrera); 
				$respuesta = $this->consulta->insert($sql, $arrData);
			}else{
				$respuesta = "existe";
			}
			return $respuesta;
		}
		/* metodo que muestra todas las carreras registradas */
		public function mdlMostrarCarreras(){
			$sql = "SELECT * FROM carreras ORDER BY nombreCarrera ASC";
		   	$respuesta = $this->consulta->selectAll($sql);
		   	return $respuesta;	
		}
		/* metodo que muestra una sola carrera por ID */
		public function mdlMostrarCarrera($item, $valor){
			$sql = "SELECT * FROM carreras  WHERE $item = '$valor' LIMIT 1";
		   	$respuesta = $this->consulta->select($sql);
		   	return $respuesta;
		}
		/* metodo para editar una carrera */
		public function mdlEditarCarrera($nombreCarrera, $idCarrera){
			$this->idCarrera = $idCarrera;
			$this->nombreCarrera = $nombreCarrera;
			$sql = "SELECT idCarrera FROM carreras where nombreCarrera = '$this->nombreCarrera' AND idCarrera != $this->idCarrera AND estadoCarrera =  TRUE LIMIT 1";
			$respuesta = $this->consulta->select($sql);
			$respuesta1= '';
			if (!empty($respuesta)) {
				$respuesta1 = 'existe';
			}else{
				$sql1 = "UPDATE carreras  SET  nombreCarrera = ?
						WHERE idCarrera = $this->idCarrera";
				$arrData = array($this->nombreCarrera); 
				$respuesta1 = $this->consulta->update($sql1, $arrData);
			}
			return $respuesta1;
		}
		public function mdlMostrarCarreraLocal($idLocal, $idCarrera){
			$sql = "SELECT local_carrera.*, nombreCarrera FROM local_carrera
				INNER JOIN carreras ON local_carrera.idCarrera = carreras.idCarrera
				WHERE local_carrera.idCarrera = $idCarrera AND idLocal = $idLocal LIMIT 1;";
		   	$respuesta = $this->consulta->select($sql);
		   	return $respuesta;	
		}
		/* metodo para registrar una carrera dentro de un local */
		public function mdlRegistrarCarreraLocal($idLocal, $idCarrera){
			$sql = "INSERT INTO local_carrera (idLocal, idCarrera) VALUES(?,?)";
			$arrData = array($idLocal, $idCarrera); 
			$respuesta = $this->consulta->insert($sql, $arrData);
			return $respuesta;
		}
		/* metodo que muestre las carreras de un local */
		public function mdlMostrarCarrerasLocal($idLocal){
			$sql = "SELECT local_carrera.*, nombreCarrera FROM local_carrera
				INNER JOIN carreras ON local_carrera.idCarrera = carreras.idCarrera
				WHERE local_carrera.idLocal = $idLocal";
			$respuesta = $this->consulta->selectAll($sql);
			return $respuesta;
		}
		/* metodo para editar el campo de una carrera dentro de un local */
		public function mdlEditarLocalCarrera($idLocalCarrera, $item, $valor){
			$sql = "UPDATE local_carrera  SET  $item = ?
					WHERE idLocalCarrera = $idLocalCarrera";
			$arrData = array($valor); 
			$respuesta = $this->consulta->update($sql, $arrData);
			return $respuesta;
		}
		public function mdlMostrarCarrerasLocalActivo($idLocal){
			$sql = "SELECT local_carrera.*, nombreCarrera FROM local_carrera
				INNER JOIN carreras ON local_carrera.idCarrera = carreras.idCarrera
				WHERE local_carrera.idLocal = $idLocal AND estado  = TRUE";
			$respuesta = $this->consulta->selectAll($sql);
			return $respuesta;
		}
		/* mostrar los datos de una carrera que esten dentro de un local*/
		public function mdlMostrarCarreraLocalActivo($idLocalCarrera){
			$sql = "SELECT local_carrera.*, nombreCarrera FROM local_carrera
				INNER JOIN carreras ON local_carrera.idCarrera = carreras.idCarrera
				WHERE idLocalCarrera = $idLocalCarrera AND estado  = TRUE LIMIT 1";
			$respuesta = $this->consulta->select($sql);
			return $respuesta;
		}
		
	} 