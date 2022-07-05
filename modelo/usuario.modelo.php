<?php 
	require_once "consultas.php";
	Class ModeloUsuario{
		private $nombreUsuario;
		private $contraUsuario;
		private $idPersona;
		private $celularUsuario;
		private $idTipoUsuario;
		private $idSedeUsuario;
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
	}