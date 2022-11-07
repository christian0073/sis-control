<?php 
	Class ControladorCursoAula {
		/* metodo para mostrar todos loe cursos de un aula */
		static public function ctrMostrarCursosAula($idAula){
			$modeloCursoAula = new ModeloCursoAula();
			$respuesta = $modeloCursoAula->mdlMostrarCursosAula($idAula);
			return $respuesta;
		}
		/* metodo para registrar docentes por primera vez */
		static public function ctrAgregarDocente(){
			if (isset($_POST['idPersonal']) && !empty($_POST['idPersonal'])) {
				$cont = 0;
				$cont2 = 0;
				$idPersonal = $_POST['idPersonal'];
				$modeloCursoAula = new ModeloCursoAula();
				for ($i=1; $i <=8 ; $i++) { 
					if (isset($_POST['checkbox'.$i])) {
						$idCursoSeccion = intval($_POST['checkbox'.$i]);
						$cont++;
						$respuesta = $modeloCursoAula->mdlEditarCampoCursoSeccion($idCursoSeccion, 'idPersonalHor', $idPersonal);
						if ($respuesta) {
							$cont2++;
						}
					}
				}
				if ($cont == $cont2) {
					return 'ok';
				}
				return 'error';
			}
		}
		static public function ctrMostrarCursosDocente(){
			$modeloCurso = new ModeloCursoAula();
			$cursos = '';
			if (isset($_POST['idPeriodoLectivo']) && !empty($_POST['idPeriodoLectivo'])) {
				$cursos = $modeloCurso->mdlMostrarCurosDocente($_POST['idPeriodoLectivo'],'');
			}else{
				$cursos = $modeloCurso->mdlMostrarCurosDocente('',$_POST['idPersonal']);
			}
			if (count($cursos) == 0) {
				$datosJson = '{"data":[]}';
				echo $datosJson;
				return;
			}else{
				$datosJson = '{
				"data":[';
				foreach ($cursos as $key => $value) {
					$cursoLink = "<button class='btn btn-danger btnAgregarLink btn-sm' idHorarioCurso='".$value['idHorarioCurso']."' title='Agregar link'><i class='fa-solid fa-link'></i></button>";
					if (!empty($value['linkCurso'])) {
						$cursoLink = "<a href='".$value['linkCurso']."' target='_blank' class='btn btn-danger btn-sm' title='Ir al enlace'><i class='fa-solid fa-caret-right'></i></a>";
					}
					$acciones = "<div class='btn-group'>";
					if ($value['estadoCursoSeccion'] == 1) {
						$acciones .= "<button class='btn btn-primary btn-sm agregarHorario' data-toggle='modal' data-target='#agregarHorario' idHorarioCurso='".$value['idHorarioCurso']."' nombreCurso='".$value['nombreCurso']."' idSeccion='".$value['idSeccionHor']."' title='Agregar horario'><i class='fa-solid fa-calendar-plus'></i></button><button class='btn btn-info btn-sm btnVerDetalles' title='ve detalles' idSeccion='".$value['idSeccionHor']."' data-toggle='modal' data-target='#modalDetalleCurso'><i class='fa-solid fa-eye'></i></button>".$cursoLink."<button class='btn btn-dark btn-sm btnEliminarCurso' title='Eliminar curso' idHorarioCurso='".$value['idHorarioCurso']."' idPersonal='".$value['idPersonalHor']."'><i class='fa-solid fa-delete-left'></i></button></div>"; 
					}else{
						$acciones .= "<h5><span class='badge badge-dark'>Sin acciones</span></h5></div>"; 
					}
					$ciclo = "<h5><span class='badge badge-warning'>".$value['cicloSeccion']."° CICLO</span></h5></div>"; 
					$turno = '';
					if ($value['turno'] == 'M') {
						$turno = 'MAÑANA';
					}else if ($value['turno'] == 'T') {
						$turno = 'TARDE';
					}else if($value['turno'] == 'N'){
						$turno = 'NOCHE';
					}
					$datosJson .='[
							"'.($key+1).'",
							"'.$value['nombreCarrera'].'",
							"'.$ciclo.'",
							"'.$value['nombreSeccion'].' ('.$turno.')",
							"'.$value['nombreCurso'].'",
							"'.$value['codigo'].'",
							"'.$acciones.'"
					],';
				}
				$datosJson = substr($datosJson, 0, -1);
				$datosJson .= ']}';
				return $datosJson;			
		}
	}
	static public function ctrMostrarCursosListaDocente(){
		$modeloCurso = new ModeloCursoAula();
		if ($_POST['editar'] == 0) {
			$cursos = $modeloCurso->mdlMostrarCurosDocente('',$_POST['idPersonal']);	
		}else{
			$cursos = $modeloCurso->mdlMostrarExamenesDocente($_POST['idPersonal'], $_POST['idParcial']);
		}
		
		return $cursos;
	}
	static public function ctrMostrarDetalleCurso($idCursoDetalle){
		$modeloCurso = new ModeloCursoAula();
		$respuesta = $modeloCurso->mdlMostrarDetalleCurso($idCursoDetalle);
		return $respuesta;
	}
	static public function ctrMostrarCursosSeccion(){
		$modeloCursos = new ModeloCursoAula();
		$cursos = '';
		if (isset($_POST['idSeccion']) && !empty($_POST['idSeccion'])) {
			$cursos = $modeloCursos->mdlMostrarCurosSeccion($_POST['idSeccion']);
		}
		if (count($cursos) == 0) {
			$datosJson = '{"data":[]}';
			echo $datosJson;
			return;
		}else{
			$datosJson = '{
				"data":[';
				foreach ($cursos as $key => $value) {
					$docente= '';
					$horario = '';
					if (empty($value['datos'])) {
						$docente = "<div class=''><button class='btn btn-primary btn-sm btnAgregarDocente' data-toggle='modal' data-target='#modalAgregarDocente' idHorarioCurso='".$value['idHorarioCurso']."' nombreCurso='".$value['nombreCurso']."' title='Agregar docente'><i class='fa-solid fa-user-plus'></i>Registrar docente</button></div>";
					}else{
						$horario = "<button class='btn btn-primary btn-sm agregarHorario' data-toggle='modal' data-target='#agregarHorario' idHorarioCurso='".$value['idHorarioCurso']."' nombreCurso='".$value['nombreCurso']."' idSeccion='".$value['idSeccionHor']."' title='Agregar horario'><i class='fa-solid fa-calendar-plus'></i></button>";
						$docente = $value['datos'];
					}
					$cursoLink = "<button class='btn btn-danger btnAgregarLink btn-sm' idHorarioCurso='".$value['idHorarioCurso']."' title='Agregar link'><i class='fa-solid fa-link'></i></button>";
					if (!empty($value['linkCurso'])) {
						$cursoLink = "<a href='".$value['linkCurso']."' target='_blank' class='btn btn-danger btn-sm' title='Ir al enlace'><i class='fa-solid fa-caret-right'></i></a>";
					}
					$acciones = "<div class='btn-group'>";
					if ($value['estadoCursoSeccion'] == 1) {
						$acciones .= $horario."<button class='btn btn-info btn-sm btnVerDetalles' title='ve detalles' idSeccion='".$value['idSeccionHor']."' data-toggle='modal' data-target='#modalDetalleCurso'><i class='fa-solid fa-eye'></i></button>".$cursoLink."</div>"; 
					}else{
						$acciones .= "<h5><span class='badge badge-dark'>Sin acciones</span></h5></div>"; 
					}
					$ciclo = "<h5><span class='badge badge-warning'>".$value['periodo']."° CICLO</span></h5></div>"; 

					$datosJson .='[
							"'.($key+1).'",
							"'.$value['nombreCarrera'].'",
							"'.$value['nombreCurso'].'",
							"'.$value['codigo'].'",
							"'.$ciclo.'",
							"'.$docente.'",
							"'.$acciones.'"
					],';
				}
				$datosJson = substr($datosJson, 0, -1);
				$datosJson .= ']}';
				return $datosJson;
		}
	}
	static public function ctrRegistrarDocenteCurso(){
		if (isset($_POST['idPersonalDocente']) && !empty($_POST['idPersonalDocente']) && isset($_POST['idCursoHorario']) && !empty($_POST['idCursoHorario'])) {
			$modeloCursoAula = new ModeloCursoAula;
			$respuesta = $modeloCursoAula->mdlEditarCampoCursoSeccion($_POST['idCursoHorario'], 'idPersonalHor', $_POST['idPersonalDocente']);
			if ($respuesta) {
				return 'ok';
			}
			return 'error';
		}else{
			return 'no';
		}
	}

	static public function ctrEliminarCursoDocente(){
		if (isset($_POST['idHorarioCurso']) && !empty($_POST['idHorarioCurso'])) {
			$modeloCursoAula = new ModeloCursoAula;
			$idHorarioCurso = $_POST['idHorarioCurso'];
			$editar = $modeloCursoAula->mdlEditarCampoCursoSeccion($idHorarioCurso, 'idPersonalHor', NULL);
			if ($editar) {
				$query = "DELETE FROM detallehorario WHERE idHorarioCurso = $idHorarioCurso;";
				$respuesta = $modeloCursoAula->mdlEliminarCursoDocente($query);
				if ($respuesta) {
					return 'ok';
				}
				return 'error';
			}
			return 'error';
		}else{
			return 'no';
		}
	}

	static public function ctrRegistrarExamenesDocente(){
		if (isset($_POST['idParcial']) && !empty($_POST['idParcial']) && isset($_POST['idPersonal']) && !empty($_POST['idPersonal']) &&
			isset($_POST['totalCheck']) && !empty($_POST['totalCheck'])
		) {
			$totalChek = intval($_POST['totalCheck']);
			if ($totalChek == 0) {
				return 'no';
			}
			$modeloCursoAula = new ModeloCursoAula;
			$arrExamenes = [];
			if ($_POST['editar'] == 1) {
				$cursos = $modeloCursoAula->mdlMostrarExamenesDocente($_POST['idPersonal'], $_POST['idParcial']);		
				foreach ($cursos as $key => $value) {
					if (isset($_POST['checkbox'.($key+1)])) {
						$fila = array($value['idExamen'], 1, $_POST['txtFechaRegistro']);
					}else{
						$fila = array($value['idExamen'], 0, $_POST['txtFechaRegistro']);
					}
					array_push($arrExamenes, $fila);
				}
				$examenes = $modeloCursoAula->mdlEditarExamenesDocenetes($arrExamenes);
				if ($examenes) {
					return 'ok';
				}				
			}else{
				$cursos = $modeloCursoAula->mdlMostrarCurosDocente('',$_POST['idPersonal']);
				foreach ($cursos as $key => $value) {
					if (isset($_POST['checkbox'.($key+1)])) {
						$fila = array($value['idHorarioCurso'], $_POST['idPersonal'], $_POST['idParcial'], 1, $_POST['txtFechaRegistro']);
					}else{
						$fila = array($value['idHorarioCurso'], $_POST['idPersonal'], $_POST['idParcial'], 0, $_POST['txtFechaRegistro']);
					}
					array_push($arrExamenes, $fila);
				}
				$examenes = $modeloCursoAula->mdlRegistrarExamenesDocenetes($arrExamenes);
				if ($examenes) {
					return 'ok';
				}
			}
			return 'noval';
		}else{
			return 'error';
		}
	}
	static public function ctrCantidadExamenes(){
		$examenes = new ModeloCursoAula();
		$parciales = $examenes->mdlCantidadExamenes();
		$arrParciales = [];
		$arrParciales[0] = 0;
		foreach ($parciales as $key => $value) {
			$arrParciales[($key+1)] = $value['cantidad'];
			$arrParciales[0] = $arrParciales[0] + $value['cantidad'];
		}
		return $arrParciales;
	}

	static public function ctrMostrarListaExamenes($idParcial){
		$modeloExamenes = new ModeloCursoAula();
		$docentes = '';
		$docentes = $modeloExamenes->mdlMostrarListaExamenes($idParcial, '');
		if (count($docentes) == 0 || empty($idParcial)) {
			$datosJson = '{"data":[]}';
			echo $datosJson;
			return;
		}else{
			$datosJson = '{
			"data":[';
			foreach ($docentes as $key => $value) {
				$fecha = '';
				if ($value['estado'] == 'ENTREGADO') {
					$estado = "<div><h5><span class='badge badge-info'>".$value['estado']."</span></h5></div>";	
					$fecha = $value['fechaExamen'];
				}else{
					$estado = "<div><h5><span class='badge badge-danger'>".$value['estado']."</span></h5></div>";
				}
				$celularPersonal = '';
				$celulares = '';
				if ($value['celularPersonal'] != '[]' ) {
					$celularPersonal = json_decode($value['celularPersonal'], true);
					for ($i=0; $i < count($celularPersonal) ; $i++) { 
						$celulares .= $celularPersonal[$i].', ';
					}
					$celulares = substr($celulares, 0, -2);		
				}
					$datosJson .='[
						"'.($key+1).'",
						"'.$value['sede'].'",
						"'.$value['docente'].'",
						"'.$value['dniPersona'].'",
						"'.$celulares.'",
						"'.$value['nombreCurso'].'",
						"'.$value['nombreSeccion'].'",
						"'.$estado.'",
						"'.$fecha.'"
					],';
				}
				$datosJson = substr($datosJson, 0, -1);
				$datosJson .= ']}';
				return $datosJson;
		}
	}
}