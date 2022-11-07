<?php 
	require_once "consultas.php";
 	Class ModeloDatos{

		public function __construct(){
			$this->consulta = new Consultas();
		}
		/* Contar docentes */
		public function mdlContarDocentes($idPeriodo){
			$sql = "SELECT COUNT(DISTINCT idPersonalHor) AS cantidad FROM horario_curso
				INNER JOIN seccion ON idSeccionHor = idSeccion
				WHERE idPeriodoSeccion = $idPeriodo;";
			$respuesta = $this->consulta->select($sql);
		   	return $respuesta;
		}

		/* Contar alumnos */
		public function mdlContarAlumnos(){
			$sql = "SELECT COUNT(idPersonaAlumno) AS cantidad FROM alumnos;";
			$respuesta = $this->consulta->select($sql);
		   	return $respuesta;
		}

		public function mdlAsistenciasDocentesMeses($fechaInicio, $fechaFin, $idPersonal){
			$consulta = "";
			if (!empty($idPersonal)) {
				$consulta = "idPersonaAsistencia = $idPersonal AND";
			}
			$sql = "SELECT COUNT(idAsistenciaDocente) cantidad, month(fechaAsis) AS mes FROM asistencia_docente
				WHERE $consulta fechaAsis BETWEEN '$fechaInicio' AND '$fechaFin'
				group by month(fechaAsis), year(fechaAsis);";
			$respuesta = $this->consulta->selectAll($sql);
			return $respuesta;
		}
 	}