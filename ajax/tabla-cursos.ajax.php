<?php 
	require_once '../controlador/curso.controlador.php';
	require_once '../modelo/curso.modelo.php';

	Class TablaCursos{
		public function mostrarTabla(){
			$cursos = '';
			if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'mostrarCursos') {
				$cursos = ControladorCurso::ctrMostrarCursos($_POST['idCarrera'], '','');	
			}else{
				$cursos = ControladorCurso::ctrMostrarCursos($_POST['idCarrera'], 'periodo', $_POST['periodo']);	
			}
			if (count($cursos) == 0) {
				$datosJson = '{"data":[]}';
				echo $datosJson;
				return;
			}else{
				$datosJson = '{
				"data":[';
				foreach ($cursos as $key => $value) {
					$acciones = "<div class='btn-group'><button class='btn btn-warning btn-sm editarCurso' title='Editar el curso ".$value['nombreCurso']."' idCurso='".$value['idCurso']."' data-toggle='modal' data-target='#modalRegistrarCurso'><i class='fa-solid fa-pen-to-square'></i></button><button class='btn btn-dark btn-sm desactivarCurso' nombre=".$value['nombreCurso']." idCarrera=".$value['idCarreraCurso']." idCurso='".$value['idCurso']."' title='Desactivar el curso ".$value['nombreCurso']."'><i class='fa-solid fa-delete-left'></i></button></div>"; 
					if ($value['estado'] == 0) {
						$acciones = "<h5><span class='badge badge-dark'>No disponible</span></h5>";
					}
					$tipoCurso = '';
					if ($value['tipo'] == 'C') {
						$tipoCurso = "<h5><span class='badge badge-info'>Carrera</span></h5>";
					}else if ($value['tipo'] == 'T') {
						$tipoCurso = "<h5><span class='badge badge-info'>Transversal</span></h5>";
					}
					$credito = "<div class='text-center'>".$value['creditosCurso']."</div>";
					$datosJson .='[
							"'.($key+1).'",
							"'.$value['periodo'].' ° Ciclo",
							"'.$value['nombreCurso'].'",
							"'.$value['codigo'].'",
							"'.$value['correlativo'].'",
							"'.$credito.'",
							"'.$tipoCurso.'",
							"'.$acciones.'"
					],';
				}
				$datosJson = substr($datosJson, 0, -1);
				$datosJson .= ']}';
				echo $datosJson;
			}
		}
	}

	$planes = new TablaCursos();
	$planes->mostrarTabla();