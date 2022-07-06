<?php 
	require_once "consultas.php";
	Class ModeloCursoAula{
		private $idAula;
		private $idCurso;
 		/* constructor que hereda los metodos de la clase consulta */
		public function __construct(){
			$this->consulta = new Consultas();
		}
		/* metodo para registrar nuevo periodo */
		public function mdlRegistrarCursosAula($arrCusoAula){
			$filTit = array(':idSeccionHor', 'idCursoHor');
			$sql = "INSERT INTO horario_curso (idSeccionHor, idCursoHor) VALUES (:idSeccionHor, :idCursoHor)";
			$respuesta = $this->consulta->insertAll($sql, $arrCusoAula, $filTit);
			return $respuesta;
		}
		/* metodo para mostrar todos los cursos de una aula */
		public function mdlMostrarCursosAula($idAula){
			$this->idAula = $idAula;
			$sql = "SELECT horario_curso.*, nombreCurso, codigo, correlativo FROM horario_curso 
				INNER JOIN cursos ON idCursoHor = idCurso WHERE idSeccionHor = $this->idAula ORDER BY codigo ASC;";
		   	$respuesta = $this->consulta->selectAll($sql);
		   	return $respuesta;	
		}
	}