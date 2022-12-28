<?php 
	require_once "consultas.php";
	Class ModeloUsuario{
		private $nombreUsuario;
		private $contraUsuario;
		private $idPersona;
		private $celularUsuario;
		private $idTipoUsuario;
		private $idSedeUsuario;
		private $idRolUsuario;
		private $idUsuario;
		// constructor para usar las consultas SQL
		public function __construct(){
			$this->consulta = new Consultas();
		}
		//mostrar usuario mediante un atributo
		public function mdlMostrarUsuario($atributo, $valor){
			$sql = "SELECT * FROM usuarios WHERE $atributo = '$valor' AND estadoDel = TRUE AND estadoUsuario = TRUE LIMIT 1";
			$respuesta = $this->consulta->select($sql);
			return $respuesta;
		}
		public function mdlMostrarRoles(){
			$sql = "SELECT * FROM roles;";
			$respuesta = $this->consulta->selectAll($sql);
			return $respuesta;
		}
		public function mdlMostrarUsuarioCampo($item, $valor){
			$sql = "SELECT * FROM usuarios
				INNER JOIN personas ON idPersonaUsuario = idPersona WHERE $item= '$valor' AND estadoUsuario = TRUE LIMIT 1;";
			$respuesta = $this->consulta->select($sql);
			return $respuesta;	
		}
		public function mdlRegistrarUsuario($idPersona, $idRolUsuario, $usuarioNombre, $usuarioContra){
			$this->idPersona = $idPersona;
			$this->idRolUsuario = $idRolUsuario;
			$this->nombreUsuario = $usuarioNombre;
			$this->contraUsuario = $usuarioContra;
			$sql = "SELECT * FROM usuarios
				WHERE nombreUsuario = '$this->nombreUsuario' AND estadoUsuario = TRUE LIMIT 1;";
			$respuesta = $this->consulta->select($sql);
			if (empty($respuesta)) {
				$sql = "INSERT INTO usuarios(idPersonaUsuario, idRol, nombreUsuario, contraUsuario) VALUES(?,?,?,?)";
				$arrData = array($this->idPersona, $this->idRolUsuario, $this->nombreUsuario, $this->contraUsuario); 
				$respuesta = $this->consulta->insert($sql, $arrData);
			}else{
				$respuesta = "existe";
			}
			return $respuesta;
		}
		public function mdlMostrarUsarios(){
			$sql = "SELECT usuarios.*, nombresPersona, apellidoPaternoPersona, apellidoMaternoPersona, dniPersona, nombreRol FROM usuarios 
				INNER JOIN personas ON idPersonaUsuario = idPersona
				INNER JOIN roles ON usuarios.idRol = roles.idRol ORDER BY estadoUsuario, apellidoPaternoPersona ASC;";
			$respuesta = $this->consulta->selectAll($sql);
			return $respuesta;
		}
		public function mdEditarUsuarioCampo($item, $valor, $idUsuario){
			$this->idUsuario = $idUsuario;
			$sql = "UPDATE usuarios  SET  estadoUsuario = ?
					WHERE idUsuario = $this->idUsuario";
			$arrData = array($item); 
			$respuesta = $this->consulta->update($sql, $arrData);
			return $respuesta;
		}
		public function mdlMostrarUsariosRol($idRolUsuario){
			$this->idRolUsuario = $idRolUsuario;
			$sql = "SELECT idUsuario, CONCAT(apellidoPaternoPersona, ' ',apellidoMaternoPersona, ' ', nombresPersona) AS datos FROM usuarios 
				INNER JOIN personas ON idPersonaUsuario = idPersona
				INNER JOIN roles ON usuarios.idRol = roles.idRol 
				WHERE usuarios.idRol = $this->idRolUsuario AND estadoUsuario = TRUE;";
			$respuesta = $this->consulta->selectAll($sql);
			return $respuesta;
		}
	}