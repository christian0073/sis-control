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
		public function mdlDocenteHorario($idPersonal, $idPeriodo){
			$sql = "SELECT detallehorario.*, horario_curso.linkCurso, cursos.nombreCurso, periodo, cursos.periodo, seccion.nombreSeccion, carreras.nombreCarrera, sedes.nombreSede FROM detallehorario 
				INNER JOIN horario_curso ON detallehorario.idHorarioCurso = horario_curso.idHorarioCurso 
                INNER JOIN cursos ON horario_curso.idCursoHor = cursos.idCurso
                INNER JOIN carreras ON cursos.idCarreraCurso = carreras.idCarrera
			    INNER JOIN seccion ON idSeccionHor = idSeccion
				INNER JOIN local_carrera ON seccion.idSeccionLocal = local_carrera.idLocalCarrera
                INNER JOIN locales ON local_carrera.idLocal = locales.idLocal
                INNER JOIN sedes ON locales.idSedeLocal = sedes.idSede
			    WHERE idPersonalHor = $idPersonal AND idPeriodoSeccion = $idPeriodo ORDER BY  horaEntrada ASC;";
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
		public function mdlMostrarHorasDocente($idPersonal, $idPeriodo){
			$sql = "SELECT SUM(horas) AS horas FROM detallehorario 
				INNER JOIN horario_curso ON detallehorario.idHorarioCurso = horario_curso.idHorarioCurso 
			    INNER JOIN seccion ON idSeccionHor = idSeccion
				WHERE idPersonalHor = $idPersonal AND idPeriodoSeccion = $idPeriodo;";
		   	$respuesta = $this->consulta->select($sql);
		   	return $respuesta;				
		}
		/* metodo para buscar las horas mensuales de un docente */
		public function mdlHorasDocenetMes($idPersonal, $fecha){
			$sql = "SELECT * FROM horas_mes
					WHERE idPersonalHoras = $idPersonal AND DATE_FORMAT(fechaHoras, '%Y-%m') = '$fecha';";
		   	$respuesta = $this->consulta->selectAll($sql);
		   	return $respuesta;
		}
		public function mdlCantidadHorasDia($idPersonal, $idPeriodo){
			$sql = "SELECT dia, SUM(horas) AS horasDia FROM detallehorario
				INNER JOIN horario_curso ON detallehorario.idHorarioCurso = horario_curso.idHorarioCurso
                INNER JOIN seccion ON idSeccionHor = idSeccion
				WHERE idPersonalHor = $idPersonal AND idPeriodoSeccion =$idPeriodo GROUP BY dia;";
		   	$respuesta = $this->consulta->selectAll($sql);
		   	return $respuesta;				
		}		
		/* metodo para registrar las horas mes */
		public function mdlRegistrarHistorialHoras($idPersonal, $fecha, $horasDias){
			$sql = "INSERT INTO horas_mes (idPersonalHoras, fechaHoras, diasHoras) VALUES(?,?,?)";
			$arrData = array($idPersonal, $fecha, $horasDias); 
			$respuesta = $this->consulta->insert($sql, $arrData);
			return $respuesta;
		}
		public function mdlSeccionHorario($idSeccion, $idPeriodo){
			$sql = "SELECT detallehorario.*, horario_curso.linkCurso, cursos.nombreCurso, periodo, cursos.periodo, seccion.nombreSeccion, carreras.nombreCarrera, sedes.nombreSede FROM detallehorario 
				INNER JOIN horario_curso ON detallehorario.idHorarioCurso = horario_curso.idHorarioCurso 
                INNER JOIN cursos ON horario_curso.idCursoHor = cursos.idCurso
                INNER JOIN carreras ON cursos.idCarreraCurso = carreras.idCarrera
			    INNER JOIN seccion ON idSeccionHor = idSeccion
				INNER JOIN local_carrera ON seccion.idSeccionLocal = local_carrera.idLocalCarrera
                INNER JOIN locales ON local_carrera.idLocal = locales.idLocal
                INNER JOIN sedes ON locales.idSedeLocal = sedes.idSede
			    WHERE idSeccionHor = $idSeccion AND idPeriodoSeccion = $idPeriodo ORDER BY  horaEntrada ASC;";
		   	$respuesta = $this->consulta->selectAll($sql);
		   	return $respuesta;
		}	
	}