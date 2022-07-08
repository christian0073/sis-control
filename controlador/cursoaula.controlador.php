<?php 
	class ControladorCursoAula {
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
					$acciones = "<div class='btn-group'>";
					if ($value['estadoCursoSeccion'] == 1) {
						$acciones .= "<button class='btn btn-info btn-sm btnVerDetalles' title='ve detalles' idHorarioCurso='".$value['idHorarioCurso']."' data-toggle='modal' data-target='#verDetallesCurso'><i class='fa-solid fa-eye'></i></button></div>"; 
					}else{
						$acciones .= "<h5><span class='badge badge-dark'>Sin acciones</span></h5></div>"; 
					}
					$turno = '';
					if ($value['turno'] == 'M') {
						$turno = 'MAÑANA';
					}else{
						$turno = 'TARDE';
					}
					$datosJson .='[
							"'.($key+1).'",
							"'.$value['nombreCarrera'].'",
							"'.$value['codigo'].'",
							"'.$value['nombreCurso'].'",
							"'.$value['creditosCurso'].'",
							"'.$value['nombreSeccion'].' ('.$turno.')",
							"'.$value['cicloSeccion'].'° CICLO",
							"'.$acciones.'"
					],';
				}
				$datosJson = substr($datosJson, 0, -1);
				$datosJson .= ']}';
				return $datosJson;			
		}
	}
}