<?php 
	Class ModeloPersonal{
		private $idPersona;
		private $idPersonal;
		private $idCargoPersonal;
		private $profesion;
		private $correoPersonal;
		private $celularPersonal;
		private $direccionPersonal;
		private $fechaIngresoPersonal;
		private $fechaSalidaPersonal;
		private $bancoPersonal;
		private $cuentaPersonal;
		private $tipoPago;
		private $montoPago;
		private $fechaNac;
		/* constructor para realizar las consultas */
		public function __construct(){
			$this->consulta = new Consultas();
		}

		public function mdlMostrarPersonalCampo($item, $valor){
			$sql = "SELECT personal.*, nombresPersona, apellidoPaternoPersona, apellidoMaternoPersona, dniPersona, nombreCargo FROM personal 
				INNER JOIN personas ON idPersonaPersonal = idPersona
				INNER JOIN cargos ON cargos.idCargo = personal.idCargo WHERE $item = '$valor' AND estadoPersonal = TRUE LIMIT 1;";
			$respuesta = $this->consulta->select($sql);
			return $respuesta;			
		}
		/* metodo para registar un nuevo personal */
		public function mdlRegistrarPersonal($idPersona, $idCargoPersonal, $profesion, $correoPersonal, $celularPersonal, $direccionPersonal, $fechaNac, $fechaIngresoPersonal){
			$this->idPersona = $idPersona;
			$this->idCargoPersonal = $idCargoPersonal;
			$this->profesion = $profesion;
			$this->correoPersonal = $correoPersonal;
			$this->celularPersonal = $celularPersonal;
			$this->direccionPersonal = $direccionPersonal;
			$this->fechaIngresoPersonal = $fechaIngresoPersonal;
			$this->fechaNac = $fechaNac;
			$sql = "SELECT idPersonal FROM personal
				INNER JOIN personas ON idPersonaPersonal = idPersona 
				WHERE idPersona = $this->idPersona AND estadoPersonal = TRUE LIMIT 1;";
			$respuesta = $this->consulta->select($sql);
			if (empty($respuesta)) {
				$sql = "INSERT INTO personal (idPersonaPersonal, idCargo, profesionPersonal, correoPersonal, celularPersonal, direccionPersonal, fechaNac, fechaIngresoPersonal) VALUES(?,?,?,?,?,?,?,?)";
				$arrData = array($this->idPersona, $this->idCargoPersonal, $this->profesion, $this->correoPersonal, $this->celularPersonal, $this->direccionPersonal, $this->fechaNac, $this->fechaIngresoPersonal); 
				$respuesta = $this->consulta->insert($sql, $arrData);
				return $respuesta;
			}else{
				$respuesta = "existe";
			}
			return $respuesta;
		}
		public function mdlMostrarPersonales($idCargo){
			$consulta = '';
			if (!empty($idCargo)) {
				$consulta = "WHERE personal.idCargo = $idCargo";
			}
			$sql = "SELECT personal.*, dniPersona, nombresPersona, apellidoMaternoPersona, apellidoPaternoPersona, nombreCargo FROM personal
				INNER JOIN personas ON idPersonaPersonal= idPersona
				INNER JOIN cargos ON personal.idCargo = cargos.idCargo $consulta ORDER BY estadoPersonal DESC, apellidoPaternoPersona ASC;";
			$respuesta = $this->consulta->selectAll($sql);
			return $respuesta;
		}
		/* metodo para editar los datos de un personal */
		public function mdlEditarPersonal($idPersonal, $idCargoPersonal, $profesion, $correoPersonal, $celularPersonal, $direccionPersonal, $fechaIngresoPersonal){
			$this->idPersonal = $idPersonal;
			$this->idCargoPersonal = $idCargoPersonal;
			$this->profesion = $profesion;
			$this->correoPersonal = $correoPersonal;
			$this->celularPersonal = $celularPersonal;
			$this->direccionPersonal = $direccionPersonal;
			$this->fechaIngresoPersonal = $fechaIngresoPersonal;
			$sql = "UPDATE personal  SET  idCargo = ?, profesionPersonal = ?, correoPersonal = ?, celularPersonal = ?, direccionPersonal = ?, fechaIngresoPersonal = ?
					WHERE idPersonal = $this->idPersonal";
			$arrData = array($this->idCargoPersonal, $this->profesion, $this->correoPersonal, $this->celularPersonal, $this->direccionPersonal, $this->fechaIngresoPersonal); 
			$respuesta = $this->consulta->update($sql, $arrData);
			return $respuesta;
		}
		/* consulta para editar los datos de pago de una persona */
		public function mdlEditarDetallesPersonal($idPersonal, $bancoPersonal, $numCuenta, $tipoPago, $monto){
			$this->idPersonal = $idPersonal;
			$this->bancoPersonal = $bancoPersonal;
			$this->cuentaPersonal = $numCuenta;
			$this->tipoPago = $tipoPago;
			$this->montoPago = $monto;
			$sql = "UPDATE personal  SET  bancoPersonal = ?, numCuentaPersonal = ?, tipoPago = ?, montoPago = ?
					WHERE idPersonal = $this->idPersonal";
			$arrData = array($this->bancoPersonal, $this->cuentaPersonal, $this->tipoPago, $this->montoPago); 
			$respuesta = $this->consulta->update($sql, $arrData);
			return $respuesta;
		}
		public function mdlEditarEstadoPersonal($idPersonal, $fechasalida, $estado){
			$this->idPersonal = $idPersonal;
			$sql = "UPDATE personal  SET  fechaSalidaPersonal = ?, estadoPersonal = ?
					WHERE idPersonal = $this->idPersonal";
			$arrData = array($fechasalida, $estado); 
			$respuesta = $this->consulta->update($sql, $arrData);
			return $respuesta;
		}
	}