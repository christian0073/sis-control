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
						$acciones .= "<button class='btn btn-primary btn-sm agregarHorario' data-toggle='modal' data-target='#agregarHorario' idHorarioCurso='".$value['idHorarioCurso']."' nombreCurso='".$value['nombreCurso']."' idSeccion='".$value['idSeccionHor']."' title='Agregar horario'><i class='fa-solid fa-calendar-plus'></i></button><button class='btn btn-info btn-sm btnVerDetalles' title='ve detalles' idSeccion='".$value['idSeccionHor']."' data-toggle='modal' data-target='#modalDetalleCurso'><i class='fa-solid fa-eye'></i></button>".$cursoLink."</div>"; 
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
							"'.$value['codigo'].'",
							"'.$value['nombreCurso'].'",
							"'.$value['nombreSeccion'].' ('.$turno.')",
							"'.$ciclo.'",
							"'.$acciones.'"
					],';
				}
				$datosJson = substr($datosJson, 0, -1);
				$datosJson .= ']}';
				return $datosJson;			
		}
	}
	static public function ctrMostrarDetalleCurso($idCursoDetalle){
		$modeloCurso = new ModeloCursoAula();
		$respuesta = $modeloCurso->mdlMostrarDetalleCurso($idCursoDetalle);
		return $respuesta;
	}
}