<?php 
	require_once "consultas.php";
 	Class ModeloLocal{
 		private $idSede;
 		private $codigoModular;
 		private $codigoLocal;
 		private $departamento;
 		private $provincia;
 		private $distrito;
 		private $idLocal;
 		private $direccion;

 		/* constructor que hereda los metodos de la clase consulta */
		public function __construct(){
			$this->consulta = new Consultas();
		}
		/* metodo para registrar nuevo local */
		public function mdlRegistrarLocal($idSede, $codigoModular, $codigoLocal, $departamento, $provincia, $distrito, $direccion){
			$this->idSede = $idSede;
			$this->codigoModular = $codigoModular;
			$this->codigoLocal = $codigoLocal;
			$this->departamento = $departamento;
			$this->provincia = $provincia;
			$this->distrito = $distrito;
			$this->direccion = $direccion;
			$sql = "INSERT INTO locales(idSedeLocal, codigoModular, codigoLocal, departamento, provincia, distrito, direccion) VALUES (?,?,?,?,?,?,?)";
			$arrData = array($this->idSede, $this->codigoModular, $this->codigoLocal, $this->departamento, $this->provincia, $this->distrito, $this->direccion); 
			$respuesta = $this->consulta->insert($sql, $arrData);	
			return $respuesta;
		}
		/* metodo que devuelva todos los locales */
		public function mdlMostrarLocales($idSede){
			$sql = "SELECT locales.*, nombreSede FROM locales
				INNER JOIN sedes ON idSedeLocal = idSede
				WHERE idSedeLocal = $idSede AND estadoLocal = TRUE";
		   	$respuesta = $this->consulta->selectAll($sql);
		   	return $respuesta;				
		}
		/* metodo que devuelve los datos de un local */
		public function mdlMostrarLocal($idLocal){
			$sql = "SELECT locales.*, nombreSede FROM locales
				INNER JOIN sedes ON idSedeLocal = idSede WHERE idLocal = $idLocal AND estadoLocal = TRUE LIMIT 1;";
			$respuesta = $this->consulta->select($sql);
			return $respuesta;
		}
		/* metodo para editar datos de un local */
		public function mdlEditarLocal($idLocal, $codigoModular, $codigoLocal, $arrDepartamento, $arrProvincia, $arrDistrito, $direccion){
			$this->idLocal = $idLocal;
			$this->codigoModular = $codigoModular;
			$this->codigoLocal = $codigoLocal;
			$this->departamento = $arrDepartamento;
			$this->provincia = $arrProvincia;
			$this->distrito = $arrDistrito;
			$this->direccion = $direccion;
			$sql = "UPDATE locales  SET  codigoModular = ?, codigoLocal=?, departamento = ?, provincia = ?, distrito = ?, direccion = ?
					WHERE idLocal = $this->idLocal";
			$arrData = array($this->codigoModular, $this->codigoLocal, $this->departamento, $this->provincia, $this->distrito, $this->direccion); 
			$respuesta = $this->consulta->update($sql, $arrData);
			return $respuesta;
		}
		/* metodo para editar un solo campo */
		public function mdlEditarLocalCampo($item, $valor, $idLocal){
			$this->idLocal = $idLocal;
			$sql = "UPDATE locales  SET  $item = ?
					WHERE idLocal = $this->idLocal";
			$arrData = array($valor); 
			$respuesta = $this->consulta->update($sql, $arrData);
			return $respuesta;
		}
		
	}