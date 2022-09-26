<?php
	require_once "consultas.php";
	Class ModeloAsistencia{

 		/* constructor que hereda los metodos de la clase consulta */
		public function __construct(){
			$this->consulta = new Consultas();
		}

		public function mdlMostrarSupervision($idSede, $dia, $idPeriodo){
			$sql = "SELECT detallehorario.*, idPersonal, nombreSede, cicloSeccion, nombreSeccion, nombreCurso, turno, concat(apellidoPaternoPersona,' ', apellidoMaternoPersona,' ', nombresPersona) AS datos, nombreCarrera, nombrecurso, linkCurso FROM detallehorario
				INNER JOIN horario_curso on detallehorario.idHorarioCurso = horario_curso.idHorarioCurso
				INNER JOIN seccion on horario_curso.idSeccionHor = seccion.idSeccion
				inner join cursos on horario_curso.idCursoHor = cursos.idCurso
			    INNER JOIN local_carrera on seccion.idSeccionLocal = local_carrera.idLocalCarrera
			    INNER JOIN locales on local_carrera.idlocal = locales.idLocal
			    INNER JOIN carreras on local_carrera.idCarrera = carreras.idCarrera
			    INNER JOIN sedes on locales.idSedeLocal = sedes.idSede
			    INNER JOIN personal on horario_curso.idPersonalHor = personal.idPersonal
			    INNER JOIN personas on personal.idPersonaPersonal = personas.idPersona
			    WHERE idCargo = 1 AND dia = '$dia' AND idSede = $idSede AND idPeriodoSeccion = $idPeriodo AND estadoPersonal = TRUE order by horaEntrada;";
		   	$respuesta = $this->consulta->selectAll($sql);
		   	return $respuesta;	
		}
		public function mdlMostrarAsistencia($fecha, $idPersonal, $idHorarioCurso){
			$sql = "SELECT * FROM asistencia_docente 
				WHERE idPersonaAsistencia = $idPersonal AND idAsistenciaHor = $idHorarioCurso AND fechaAsis = '$fecha' LIMIT 1;";
		   	$respuesta = $this->consulta->select($sql);
		   	return $respuesta;				
		}
		public function mdlRegistrarAsistencia($tipoClase, $idPersonal, $idHorarioCurso, $idUsuario, $fecha, $horaEntrada, $horaSalida, $observacion, $estado){
			$sql = "INSERT INTO asistencia_docente (idPersonaAsistencia, idAsistenciaHor, idUsuarioAsistencia, fechaAsis, horaEntrada, horaSalida, tipo, observacion, estado) VALUES(?,?,?,?,?,?,?,?,?)";
			$arrData = array($idPersonal, $idHorarioCurso, $idUsuario, $fecha, $horaEntrada, $horaSalida, $tipoClase, $observacion, $estado); 
			$respuesta = $this->consulta->insert($sql, $arrData);
			return $respuesta;
		}
		public function mdlEditarAsistencia($tipoClase, $idUsuario, $horaEntrada, $horaSalida, $observacion, $estado, $idAsistenciaDocente){
			$sql = "UPDATE asistencia_docente  SET  idUsuarioAsistencia = ?, horaEntrada=?, horaSalida = ?, tipo = ?, observacion = ?, estado = ?
						WHERE idAsistenciaDocente = $idAsistenciaDocente";
				$arrData = array($idUsuario, $horaEntrada, $horaSalida, $tipoClase, $observacion, $estado); 
				$respuesta = $this->consulta->update($sql, $arrData);
			return $respuesta;
		}
		public function mdlReprogramarAsistencia($idHorarioCurso, $fecha, $fechaRep, $horaEntrada, $horaSalida, $idReprogramar){
			if (empty($idReprogramar)) {
				$sql = "INSERT INTO reprogramacion (idHorCurso, fecha, fechaReprogramacion, horaIngreso, horaSalida) VALUES(?,?,?,?,?)";
				$arrData = array($idHorarioCurso, $fecha, $fechaRep, $horaEntrada, $horaSalida,); 
				$respuesta = $this->consulta->insert($sql, $arrData);
			}else{
				$sql = "UPDATE reprogramacion  SET  fechaReprogramacion = ?, horaIngreso=?, horaSalida = ?
						WHERE idReprogramacion = $idReprogramar";
				$arrData = array($fechaRep, $horaEntrada, $horaSalida); 
				$respuesta = $this->consulta->update($sql, $arrData);
			}
			return $respuesta;	
		}
		public function mdlMostrarReprogramacion($fecha, $idHorarioCurso){
			$sql = "SELECT * FROM reprogramacion 
				WHERE idHorCurso = $idHorarioCurso AND fecha = '$fecha' LIMIT 1;";
		   	$respuesta = $this->consulta->select($sql);
		   	return $respuesta;
		}
		public function mdlMostrarReprogramaciones($fecha){
			$sql = "SELECT reprogramacion.*, personal.idPersonal, nombreCurso, nombreCarrera, nombreSeccion, turno, cicloSeccion, concat(nombresPersona, ' ', apellidoPaternoPersona,' ', apellidoMaternoPersona) AS datos FROM reprogramacion
				INNER JOIN horario_curso ON reprogramacion.idHorCurso = horario_curso.idHorarioCurso
				INNER JOIN personal ON horario_curso.idPersonalHor = personal.idPersonal
				INNER JOIN personas ON personal.idPersonaPersonal = personas.idPersona
				INNER JOIN cursos ON horario_curso.idCursoHor = cursos.idCurso
				INNER JOIN carreras ON cursos.idCarreraCurso = carreras.idCarrera
				INNER JOIN seccion ON horario_curso.idSeccionHor = seccion.idSeccion
				WHERE fechaReprogramacion = '$fecha' AND reprogramacion.estado = 1 ORDER BY horaIngreso;";
		   	$respuesta = $this->consulta->selectAll($sql);
		   	return $respuesta;	
		}
		public function mdlEliminarReprogramacion($idReprogramar){
			$sql = "DELETE FROM reprogramacion WHERE idReprogramacion = $idReprogramar;";
		   	$respuesta = $this->consulta->delete($sql);
		   	return $respuesta;
		}
		public function mdlEliminarAsistencia($idAsistenciaDocente){
			$sql = "DELETE FROM asistencia_docente WHERE idAsistenciaDocente = $idAsistenciaDocente;";
		   	$respuesta = $this->consulta->delete($sql);
		   	return $respuesta;
		}
		public function mdlMostrarAsistencias($idPersonal, $rangoFecha){
			$sql = "SELECT DATE_FORMAT(fechaAsis, '%d/%m/%Y')AS fechaAsiste, asistencia_docente.*, CONCAT(personas.apellidoPaternoPersona, ' ', personas.apellidoMaternoPersona, ' ', personas.nombresPersona)AS datos , nombreSeccion, turno, cicloSeccion, nombreCurso, personas.dniPersona, CONCAT(perUs.apellidoPaternoPersona, ' ', perUs.apellidoMaternoPersona, ' ', perUs.nombresPersona) AS datosUsuario FROM asistencia_docente 
				INNER JOIN personal ON idPersonaAsistencia = idpersonal
				INNER JOIN personas ON personal.idPersonaPersonal = personas.idPersona
				INNER JOIN horario_curso ON idAsistenciaHor = idHorarioCurso
				INNER JOIN seccion ON idSeccionHor = idSeccion
				INNER JOIN cursos ON horario_curso.idCursoHor = idCurso
				INNER JOIN usuarios ON idUsuarioAsistencia = idUsuario 
				INNER JOIN personas AS perUs ON usuarios.idPersonaUsuario = perUs.idPersona
				WHERE DATE_FORMAT(fechaAsis, '%Y-%m') = '$rangoFecha' and idPersonaAsistencia = $idPersonal ORDER BY fechaAsis, horaEntrada;";
		   	$respuesta = $this->consulta->selectAll($sql);
		   	return $respuesta;			
		}
		public function mdlMostrarAvance($fecha, $idUsuario){
			$sql = "SELECT asistencia_docente.*, CONCAT(apellidoPaternoPersona, ' ',apellidoMaternoPersona, ' ',nombresPersona) AS datos, nombreCurso, nombreSeccion, turno, cicloSeccion, nombreCarrera FROM asistencia_docente
				INNER JOIN personal ON idPersonaAsistencia = idPersonal
				INNER JOIN personas ON idPersonaPersonal= idPersona
				INNER JOIN horario_curso ON idAsistenciaHor = idHorarioCurso
				INNER JOIN cursos ON idCursoHor = idCurso
				INNER JOIN seccion ON idSeccionHor = idSeccion
				INNER JOIN carreras ON idCarreraCurso = idCarrera
				WHERE fechaAsis = '$fecha' AND idUsuarioAsistencia = $idUsuario ORDER BY datos ASC;";
		   	$respuesta = $this->consulta->selectAll($sql);
		   	return $respuesta;			
		}
		public function mdlEditarLink($link, $idHorarioCurso){
			$sql = "UPDATE horario_curso  SET  linkCurso = ?
						WHERE idHorarioCurso = $idHorarioCurso";
				$arrData = array($link); 
				$respuesta = $this->consulta->update($sql, $arrData);
			return $respuesta;
		}
	}