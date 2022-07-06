<?php 
	Class ModeloPersonal{
		private $idPersona;
		private $idCargoPersonal;
		private $correoPersonal;
		private $celularPersonal;
		private $direccionPersonal;
		private $fechaIngresoPersonal;
		private $fechaSalidaPersonal;
		/* constructor para realizar las consultas */
		public function __construct(){
			$this->consulta = new Consultas();
		}

		public function mdlMostrarPersonalCampo($item, $dni){
			$sql = "SELECT personal.*, nombresPersona, apellidoPaternoPersona, apellidoMaternoPersona FROM personal 
				INNER JOIN personas ON idPersonaPersonal = idPersona WHERE $item = '$dni' AND estadoPersonal = TRUE LIMIT 1;";
			$respuesta = $this->consulta->select($sql);
			return $respuesta;			
		}
		/* metodo para registar un nuevo personal */
		public function mdlRegistrarPersonal($idPersona, $idCargoPersonal, $correoPersonal, $celularPersonal, $direccionPersonal, $fechaIngresoPersonal){
			$this->idPersona = $idPersona;
			$this->idCargoPersonal = $idCargoPersonal;
			$this->correoPersonal = $correoPersonal;
			$this->celularPersonal = $celularPersonal;
			$this->direccionPersonal = $direccionPersonal;
			$this->fechaIngresoPersonal = $fechaIngresoPersonal;
			$sql = "INSERT INTO personal (idPersonaPersonal, idCargo, correoPersonal, celularPersonal, direccionPersonal, fechaIngresoPersonal) VALUES(?,?,?,?,?,?)";
			$arrData = array($this->idPersona, $this->idCargoPersonal, $this->correoPersonal, $this->celularPersonal, $this->direccionPersonal, $this->fechaIngresoPersonal); 
			$respuesta = $this->consulta->insert($sql, $arrData);
			return $respuesta;
		}
	}