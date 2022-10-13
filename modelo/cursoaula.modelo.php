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
		public function mdlEditarCampoCursoSeccion($idCursoSeccion, $item, $valor){
			$sql = "UPDATE horario_curso  SET  idPersonalHor = ?
					WHERE idHorarioCurso = $idCursoSeccion";
			$arrData = array($valor); 
			$respuesta = $this->consulta->update($sql, $arrData);
			return $respuesta;
		}
		public function mdlMostrarCurosDocente($idPeriodoLectivo, $idPersonal){
			$consulta = '';
			if (!empty($idPeriodoLectivo)) {
				//$consulta = "WHERE personal.idCargo = $idCargo";
			}
			$sql = "SELECT horario_curso.*, cursos.nombreCurso, cursos.codigo, cursos.creditosCurso, carreras.nombreCarrera, seccion.nombreSeccion, seccion.turno, seccion.cicloSeccion FROM horario_curso 
				INNER JOIN cursos ON horario_curso.idCursoHor = cursos.idCurso
				INNER JOIN carreras ON cursos.idCarreraCurso = carreras.idCarrera
				INNER JOIN seccion ON idSeccionHor = idSeccion
				INNER JOIN periodos ON seccion.idPeriodoSeccion = periodos.idPeriodo
				WHERE horario_curso.idPersonalHor= $idPersonal AND periodos.estadoPeriodo= TRUE ORDER BY nombreSeccion ASC;";
			$respuesta = $this->consulta->selectAll($sql);
			return $respuesta;
		}
		/* metodo que devuelve el horario de un determinado curso */
		public function mdlMostrarDetalleCurso($idCursoHorario){
			$sql = "SELECT * FROM detallehorario
				WHERE idHorarioCurso = $idCursoHorario ORDER BY dia, horaEntrada ASC;";
			$respuesta = $this->consulta->selectAll($sql);
			return $respuesta;		
		}
		public function mdlMostrarCurosSeccion($idSeccion){
			$sql = "SELECT horario_curso.*, nombreCurso, codigo, periodo, nombreCarrera, concat(nombresPersona, ' ', apellidoPaternoPersona, ' ', apellidoMaternoPersona) AS datos FROM horario_curso 
				INNER JOIN cursos ON idCursoHor = idCurso
				INNER JOIN carreras ON idCarreraCurso = idCarrera
				LEFT JOIN personal ON idPersonalHor = idPersonal
				LEFT JOIN personas ON idPersonaPersonal = idPersona
				WHERE idSeccionHor = $idSeccion ORDER BY nombreCurso ASC;";
			$respuesta = $this->consulta->selectAll($sql);
			return $respuesta;				
		}
		public function mdlEliminarCursoDocente($query){
		   	$respuesta = $this->consulta->delete($query);
		   	return $respuesta;
		}
		public function mdlMostrarCurosDoc($idPersonal){
			$sql = "SELECT * FROM horario_curso 
				WHERE idPersonalHor= $idPersonal;";
			$respuesta = $this->consulta->selectAll($sql);
			return $respuesta;
		}
		public function mdlEditarCursoVarios($idPersonal, $valor){
			$sql = "UPDATE horario_curso  SET  idPersonalHor = ?
					WHERE idPersonalHor = $idPersonal;";
			$arrData = array($valor); 
			$respuesta = $this->consulta->update($sql, $arrData);
			return $respuesta;			
		}
		public function mdlRegistrarExamenesDocenetes($arrExamenes){
			$filTit = array(':idHorarioExamen', ':idDocenteExamen', ':idParcial', ':estadoExamen', ':fechaExamen');
			$sql = "INSERT INTO examen_docente (idHorarioExamen, idDocenteExamen, idParcial, estadoExamen, fechaExamen) VALUES (:idHorarioExamen, :idDocenteExamen, :idParcial, :estadoExamen, :fechaExamen)";
			$respuesta = $this->consulta->insertAll($sql, $arrExamenes, $filTit);
			return $respuesta;
		}
		public function mdlCantidadExamenesRegistrados($idPersonal){
			$sql = "SELECT idExamen, idHorarioExamen, COUNT(idExamen) AS cantidad, idParcial, SUM(estadoExamen) AS entregado FROM examen_docente where idDocenteExamen = $idPersonal GROUP BY idParcial;";
			$respuesta = $this->consulta->selectAll($sql);
			return $respuesta;
		}
		public function mdlMostrarExamenesDocente($idPersonal, $idParcial){
			$sql = "SELECT examen_docente.*, nombreSeccion, nombreCurso, nombreCarrera FROM examen_docente
				INNER JOIN horario_curso ON idHorarioExamen = horario_curso.idHorarioCurso
				INNER JOIN seccion ON idSeccionHor = seccion.idSeccion
				INNER JOIN cursos ON idCursoHor = cursos.idCurso
				INNER JOIN carreras ON idCarreraCurso = carreras.idCarrera
				WHERE idDocenteExamen = $idPersonal AND idParcial = $idParcial";
			$respuesta = $this->consulta->selectAll($sql);
			return $respuesta;
		}
		public function mdlEditarExamenesDocenetes($arrExamenes){
			$filTit = array(':idExamen', ':estadoExamen', ':fechaExamen');
			$sql = "UPDATE examen_docente SET estadoExamen = :estadoExamen, fechaExamen = :fechaExamen WHERE idExamen = :idExamen";
			$respuesta = $this->consulta->insertAll($sql, $arrExamenes, $filTit);
			return $respuesta;			
		}
	}