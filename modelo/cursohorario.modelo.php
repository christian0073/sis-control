<?php 
	require_once "consultas.php";
	Class ModeloCursoHorario{
		
		public function __construct(){ 
			$this->consulta = new Consultas();
		}

		public function mdlMostrarCursoHorario($idCursoHorario, $dia){
			$sql = "SELECT * FROM detallehorario WHERE idHorarioCurso = $idCursoHorario AND dia = $dia";
		   	$respuesta = $this->consulta->selectAll($sql);
		   	return $respuesta;		
		}
		/* ver si hay un horario repetido */
		public function mdlMostrarHorarioPersona($idPersonal, $dia, $idHorarioCurso){
			$sql = "SELECT * FROM detallehorario 
				INNER JOIN horario_curso ON detallehorario.idHorarioCurso = horario_curso.idHorarioCurso 
				WHERE idPersonalHor = $idPersonal AND dia = $dia AND detallehorario.idHorarioCurso != $idHorarioCurso;";
		   	$respuesta = $this->consulta->selectAll($sql);
		   	return $respuesta;		
		}
		/* registrar datos horario */
		public function mdlRegistrarHorario($arrCursoHorario){
			$filTit = array(':idHorarioCurso', ':dia', ':horaEntrada', ':horaSalida', ':horas', ':tipo');
			$sql = "INSERT INTO detallehorario (idHorarioCurso, dia, horaEntrada, horaSalida, horas, tipo) VALUES (:idHorarioCurso, :dia, :horaEntrada, :horaSalida, :horas, :tipo)";
			$respuesta = $this->consulta->insertAll($sql, $arrCursoHorario, $filTit);
			return $respuesta;			
		}
		/* metodo para borrar el registro de un horario */
		public function mdlEliminarRegistro($consulta){
			$respuesta = $this->consulta->delete($consulta);
			return $respuesta;	
		}
		public function mdlDocenteHorario($idPersonal){
			$sql = "SELECT detallehorario.*, horario_curso.linkCurso, cursos.nombreCurso, periodo, cursos.periodo, seccion.nombreSeccion, carreras.nombreCarrera, sedes.nombreSede FROM detallehorario 
				INNER JOIN horario_curso ON detallehorario.idHorarioCurso = horario_curso.idHorarioCurso 
                INNER JOIN cursos ON horario_curso.idCursoHor = cursos.idCurso
                INNER JOIN carreras ON cursos.idCarreraCurso = carreras.idCarrera
			    INNER JOIN seccion ON idSeccionHor = idSeccion
				INNER JOIN local_carrera ON seccion.idSeccionLocal = local_carrera.idLocalCarrera
                INNER JOIN locales ON local_carrera.idLocal = locales.idLocal
                INNER JOIN sedes ON locales.idSedeLocal = sedes.idSede
			    WHERE idPersonalHor = $idPersonal ORDER BY  horaEntrada ASC;";
		   	$respuesta = $this->consulta->selectAll($sql);
		   	return $respuesta;
		}
		public function mdlMostrarAsistenciaCurso($idHorarioCurso){
			$sql = "SELECT horario_curso.* , personas.*, nombreCurso, nombreCarrera FROM horario_curso
				INNER JOIN personal ON idPersonalHor = idPersonal
				INNER JOIN personas ON personal.idPersonaPersonal = idPersona
				INNER JOIN cursos ON idCursoHor = idCurso
				INNER JOIN carreras ON cursos.idCarreraCurso = carreras.idCarrera
				WHERE idHorarioCurso = $idHorarioCurso LIMIT 1;";
		   	$respuesta = $this->consulta->select($sql);
		   	return $respuesta;	
		}
	}