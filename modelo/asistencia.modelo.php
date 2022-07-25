<?php
	require_once "consultas.php";
	Class ModeloAsistencia{

 		/* constructor que hereda los metodos de la clase consulta */
		public function __construct(){
			$this->consulta = new Consultas();
		}

		public function mdlMostrarSupervision($idSede, $dia, $idPeriodo){
			$sql = "SELECT detallehorario.*, idPersonal, nombreSede, cicloSeccion, nombreSeccion, nombreCurso, turno, concat(apellidoPaternoPersona,' ', apellidoMaternoPersona,' ', nombresPersona) AS datos, nombreCarrera, nombrecurso FROM detallehorario
				INNER JOIN horario_curso on detallehorario.idHorarioCurso = horario_curso.idHorarioCurso
				INNER JOIN seccion on horario_curso.idSeccionHor = seccion.idSeccion
				inner join cursos on horario_curso.idCursoHor = cursos.idCurso
			    INNER JOIN local_carrera on seccion.idSeccionLocal = local_carrera.idLocalCarrera
			    INNER JOIN locales on local_carrera.idlocal = locales.idLocal
			    INNER JOIN carreras on local_carrera.idCarrera = carreras.idCarrera
			    INNER JOIN sedes on locales.idSedeLocal = sedes.idSede
			    INNER JOIN personal on horario_curso.idPersonalHor = personal.idPersonal
			    INNER JOIN personas on personal.idPersonaPersonal = personas.idPersona
			    WHERE idCargo = 1 AND dia = '$dia' AND idSede = $idSede AND idPeriodoSeccion = $idPeriodo order by horaEntrada;";
		   	$respuesta = $this->consulta->selectAll($sql);
		   	return $respuesta;	
		}
		public function mdlMostrarAsistencia($fecha, $idPersonal, $idHorarioCurso){
			$sql = "SELECT * FROM asistencia_docente 
				WHERE idPersonaAsistencia = $idPersonal AND idAsistenciaHor = $idHorarioCurso AND fechaAsistencia = '$fecha' LIMIT 1;";
		   	$respuesta = $this->consulta->select($sql);
		   	return $respuesta;				
		}
		public function mdlRegistrarAsistencia($tipoClase, $idPersonal, $idHorarioCurso, $idUsuario, $fecha, $horaEntrada, $horaSalida, $observacion, $estado){
			$sql = "INSERT INTO asistencia_docente (idPersonaAsistencia, idAsistenciaHor, idUsuarioAsistencia, fechaAsis, horaEntrada, horaSalida, tipo, observacion, estado) VALUES(?,?,?,?,?,?,?,?,?)";
			$arrData = array($idPersonal, $idHorarioCurso, $idUsuario, $fecha, $horaEntrada, $horaSalida, $tipoClase, $observacion, $estado); 
			$respuesta = $this->consulta->insert($sql, $arrData);
			return $respuesta;
		}
	}