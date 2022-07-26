<?php 
	require_once '../controlador/aula.controlador.php';
	require_once '../modelo/aula.modelo.php';

	Class TablaAulas{
		public function mostrarTabla(){
			$aulas = '';
			if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'mostrarAulasPeriodo') {
				$aulas = ControladorAula::ctrMostrarAulas($_POST['idPeriodo'], '', '');	
			}else if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'mostrarAulasSede') {
				$aulas = ControladorAula::ctrMostrarAulas($_POST['idPeriodo'], $_POST['idSede'], '');	
			}else if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'mostrarAulasTodo') {
				$aulas = ControladorAula::ctrMostrarAulas($_POST['idPeriodo'], '', $_POST['idCarrera']);	
			}else{
				$aulas = ControladorAula::ctrMostrarAulas('', '', '');	
			}
			if (count($aulas) == 0) {
				$datosJson = '{"data":[]}';
				echo $datosJson;
				return;
			}else{
				$datosJson = '{
				"data":[';
				foreach ($aulas as $key => $value) {
					$acciones = '';
					if ($value['estado'] == 1) {
						$acciones = "<div class='btn-group'><button class='btn btn-warning btn-sm editarAula' title='Editar el aula ".$value['nombreSeccion']."' idAula='".$value['idSeccion']."' data-toggle='modal' data-target='#modalEditarAula'><i class='fa-solid fa-pen-to-square'></i></button><button class='btn btn-sm btn-info btnVerCursos' title='Ver cursos' idAula='".$value['idSeccion']."' data-toggle='modal' data-target='#modalVerCursos'><i class='fa-solid fa-eye'></i></button><a href='seccion?idSeccion=".$value['idSeccion']."' class='btn btn-danger btn-sm btnVerSeccion' title='Cambiar datos de la sección'><i class='fa-solid fa-sort'></i></a><button class='btn btn-dark btn-sm desactivarCurso' nombre=".$value['nombreSeccion']." idAula=".$value['idSeccion']." title='Desactivar el aula ".$value['nombreSeccion']."'><i class='fa-solid fa-delete-left'></i></button></div>"; 
					}else{
						$acciones = "<h5><span class='badge badge-dark'>No disponible</span></h5>";
					}
					$turno = '';
					if ($value['turno'] == 'M') {
						$turno = "<h5><span class='badge badge-info'>Mañana</span></h5";
					}else if ($value['turno'] == 'N') {
						$turno = "<h5><span class='badge badge-warning'>Noche</span></h5";
					}else{
						$turno = "<h5><span class='badge badge-danger'>Tarde</span></h5";
					}
					$datosJson .='[
							"'.($key+1).'",
							"'.$value['nombrePeriodo'].'",
							"'.$value['direccion'].'",
							"'.$value['nombreCarrera'].'",
							"'.$value['cicloSeccion'].'",
							"'.$value['nombreSeccion'].'",
							"'.$turno.'",
							"'.$acciones.'"
					],';
				}
				$datosJson = substr($datosJson, 0, -1);
				$datosJson .= ']}';
				echo $datosJson;
			}
		}
	}

	$planes = new TablaAulas();
	$planes->mostrarTabla();