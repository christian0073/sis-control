<?php 
	require_once "consultas.php";
 	Class ModeloCurso{
 		private $idCurso;
 		private $idCarreraCurso;
 		private $nombreCurso;
 		private $periodo;
 		private $codigoCurso;
 		private $correlativoCurso;
 		private $creditosCurso;
 		private $tipoCurso;
 		/* constructor que hereda los metodos de la clase consulta */
		public function __construct(){
			$this->consulta = new Consultas();
		}
		/* metodo para registrar nuevo curso */
		public function mdlRegistrarCurso($idCarrera, $nombreCurso, $periodo, $codigoCurso, $correlativoCurso, $creditosCurso, $tipoCurso){
			$this->idCarrera = $idCarrera;
			$this->nombreCurso = $nombreCurso;
			$this->periodo = $periodo;
			$this->codigoCurso = $codigoCurso;
			$this->correlativoCurso = $correlativoCurso;
			$this->creditosCurso = $creditosCurso;
			$this->tipoCurso = $tipoCurso;
			$sql = "SELECT idCurso FROM cursos WHERE codigo = '$this->codigoCurso' LIMIT 1";
			$respuesta = $this->consulta->select($sql);
			if (empty($respuesta)) {
				$sql = "INSERT INTO cursos (idCarreraCurso, nombreCurso, periodo, codigo, correlativo, creditosCurso, tipo) VALUES(?,?,?,?,?,?,?)";
				$arrData = array($this->idCarrera, $this->nombreCurso, $this->periodo, $this->codigoCurso, $this->correlativoCurso, $this->creditosCurso, $this->tipoCurso); 
				$respuesta = $this->consulta->insert($sql, $arrData);
			}else{
				$respuesta = "existe";
			}
			return $respuesta;
		}
		/* metodo que muestra todas los cursos registrados en una carrera */
		public function mdlMostrarCursos($idCarrera, $item, $valor){
			$this->idCarreraCurso = $idCarrera;
			if ($item == '' && $valor == '') {
				$sql = "SELECT * FROM cursos WHERE idCarreraCurso = $this->idCarreraCurso ORDER BY periodo, nombreCurso ASC;";
			}else{
				$sql = "SELECT * FROM cursos WHERE idCarreraCurso = $this->idCarreraCurso AND $item = '$valor' ORDER BY nombreCurso ASC;";
			}
		   	$respuesta = $this->consulta->selectAll($sql);
		   	return $respuesta;	
		}
		/* metodo que muestra un solo curso */
		public function mdlMostrarCurso($item, $valor){
			$sql = "SELECT cursos.*, nombreCarrera FROM cursos 
				INNER JOIN carreras ON idCarreraCurso = idCarrera
				WHERE $item = '$valor' LIMIT 1;";
			$respuesta = $this->consulta->select($sql);
		   	return $respuesta;		
		}
		/* metodo para editar datos de un curso */
		public function mdlEditarCurso($nombreCurso, $periodo, $codigoCurso, $correlativoCurso, $creditosCurso, $tipoCurso, $idCurso){
			$this->nombreCurso = $nombreCurso;
			$this->periodo = $periodo;
			$this->codigoCurso = $codigoCurso;
			$this->correlativoCurso = $correlativoCurso;
			$this->creditosCurso = $creditosCurso;
			$this->idCurso = $idCurso;
			$this->tipoCurso = $tipoCurso;
			$sql = "SELECT idCurso FROM cursos where codigo = '$this->codigoCurso' AND idCurso != $this->idCurso AND estado = TRUE LIMIT 1";
			$respuesta = $this->consulta->select($sql);
			if (!empty($respuesta)) {
				$respuesta = 'existe';
			}else{
				$sql1 = "UPDATE cursos  SET  nombreCurso = ?, periodo=?, codigo = ?, correlativo = ?, creditosCurso = ?, tipo = ?
						WHERE idCurso = $this->idCurso";
				$arrData = array($this->nombreCurso, $this->periodo, $this->codigoCurso, $this->correlativoCurso, $this->creditosCurso, $this->tipoCurso); 
				$respuesta = $this->consulta->update($sql1, $arrData);

			}
			return $respuesta;
		}
		/* metodo para editar un solo campo del curso */
		public function mdlEditarCampoCurso($item, $valor, $idCurso){
			$this->idCurso = $idCurso;
			$sql = "UPDATE cursos  SET  $item = ?
					WHERE idCurso = $this->idCurso";
			$arrData = array($valor); 
			$respuesta = $this->consulta->update($sql, $arrData);
			return $respuesta;
		}
		/* metodo que muestra los cursos de una carrera */
		public function mdlMostrarCursosCarrera($idCarrera, $item, $valor){
			$sql = "SELECT cursos.*, nombreCarrera FROM cursos 
				INNER JOIN carreras ON idCarreraCurso = idCarrera
				WHERE idCarreraCurso = $idCarrera AND $item = '$valor' AND estado = TRUE;";
			$respuesta = $this->consulta->selectAll($sql);
		   	return $respuesta;		
		}
		
	}