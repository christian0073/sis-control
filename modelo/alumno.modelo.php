<?php 
	Class ModeloAlumno{
		/* constructor para realizar las consultas */
		public function __construct(){
			$this->consulta = new Consultas();
		}

		public function mdlMostrarAlumnoCampo($item, $valor){
			$sql = "SELECT personal.*, nombresPersona, apellidoPaternoPersona, apellidoMaternoPersona, dniPersona, nombreCargo FROM personal 
				INNER JOIN personas ON idPersonaPersonal = idPersona
				INNER JOIN cargos ON cargos.idCargo = personal.idCargo WHERE $item = '$valor' AND estadoPersonal = TRUE LIMIT 1;";
			$respuesta = $this->consulta->select($sql);
			return $respuesta;			
		}
		public function mdlRegistrarAlumno($idPersona, $codigo){
			$sql = "SELECT idAlumno FROM alumnos
				WHERE idPersonaAlumno = $idPersona LIMIT 1;";
			$respuesta = $this->consulta->select($sql);
			if (empty($respuesta)) {
				$sql = "INSERT INTO alumnos (idPersonaAlumno, codigo) VALUES(?,?)";
				$arrData = array($idPersona, $codigo); 
				$respuesta = $this->consulta->insert($sql, $arrData);
				return $respuesta;
			}else{
				$respuesta = $respuesta['idAlumno'];
			}
			return $respuesta;
		}
		public function mdlRegistrarCursos($arrCursos){
			$filTit = array(':idAlumnoSubsanacion', ':idSeccionSubsanacion', ':idCursoSubsanacion', ':idUsuarioSubsanacion', ':estadoSubsanacion', ':codigoPago', ':monto');
			$sql = "INSERT INTO subsanaciones (idAlumnoSubsanacion, idSeccionSubsanacion, idCursoSubsanacion, idUsuarioSubsanacion, estadoSubsanacion, codigoPago, monto) VALUES (:idAlumnoSubsanacion, :idSeccionSubsanacion, :idCursoSubsanacion, :idUsuarioSubsanacion, :estadoSubsanacion, :codigoPago, :monto)";	
			$respuesta = $this->consulta->insertAll($sql, $arrCursos, $filTit);
			return $respuesta;
		}
		public function mdlMostrarAlumnos($idSede){
			$consulta = 'WHERE estadoSubsanacion > 0';
			if (!empty($idSede)) {
				$consulta = "WHERE sedes.idSede = $idSede AND estadoSubsanacion > 0";
			}
			$sql = "SELECT subsanaciones.*, alumnos.codigo, dniPersona, CONCAT(apellidoPaternoPersona, ' ', apellidoMaternoPersona, ', ', nombresPersona)AS datos, nombreSeccion, nombreCurso, nombreCarrera, cicloSeccion, nombreSede FROM subsanaciones
				INNER JOIN alumnos ON idAlumnoSubsanacion = idAlumno
				INNER JOIN personas ON idPersonaAlumno = idPersona
				INNER JOIN seccion ON idSeccionSubsanacion = idSeccion
				INNER JOIN local_carrera ON idSeccionLocal = idLocalCarrera
				INNER JOIN locales ON local_carrera.idLocal= locales.idLocal
				INNER JOIN cursos ON idCursoSubsanacion = idCurso
				INNER JOIN carreras ON idCarreraCurso = carreras.idCarrera
				INNER JOIN sedes ON idSedeLocal = sedes.idSede $consulta ORDER BY idSubsanacion ASC;";
			$respuesta = $this->consulta->selectAll($sql);
			return $respuesta;
		}
		public function mdlEditarSubsanar($item, $valor, $idSubsanacion){
			$sql = "UPDATE subsanaciones  SET  $item = ?
					WHERE idSubsanacion = $idSubsanacion";
			$arrData = array($valor); 
			$respuesta = $this->consulta->update($sql, $arrData);
			return $respuesta;
		}
	}