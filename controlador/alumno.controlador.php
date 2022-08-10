<?php 
	Class ControladorAlumno{

		static public function ctrMostrarAlumnoDni($dni){
			$item = 'dniPersona';
			$modeloUsuario = new ModeloAlumno();
			$respuesta = $modeloUsuario->mdlMostrarAlumnoCampo($item, $dni);
			if (!empty($persona)) {
				$persona = array("paterno" => $persona['apellidoPaternoPersona'], "materno" => $persona['apellidoMaternoPersona'], "nombres" => $persona['nombresPersona']);
			}
			return $respuesta;
		}
		static public function ctrRegistrarAlumno(){
			if (isset($_POST['txtDniUsuario']) && !empty($_POST['txtDniUsuario']) &&
				isset($_POST['txtApellidoPaterno']) && !empty($_POST['txtApellidoPaterno']) &&
				isset($_POST['txtApellidoMaterno']) && !empty($_POST['txtApellidoMaterno']) &&
				isset($_POST['txtNombres']) && !empty($_POST['txtNombres']) &&
				isset($_POST['cmbSedeCurso']) && !empty($_POST['cmbSedeCurso']) &&
				isset($_POST['txtCodigoPago']) && !empty($_POST['txtCodigoPago']) &&
				isset($_POST['txtMontoPago']) && !empty($_POST['txtMontoPago'])
			) {
				$dniUsuario = trim($_POST['txtDniUsuario']);
				$apellidoPaterno = trim($_POST['txtApellidoPaterno']);
				$apellidoMaterno = trim($_POST['txtApellidoMaterno']);
				$nombresPersona = trim($_POST['txtNombres']);
				$sede = intval($_POST['cmbSedeCurso']);
				$codigoPago = $_POST['txtCodigoPago'];
				$montoPago = intval($_POST['txtMontoPago']);
				$seccion = intval($_POST['cmbSeccionCurso']);
				$idUsuario = $_SESSION['idUsuarioSis'];
				if (preg_match("/^[a-zA-ZñÑáéíóúÁÉÍÓÚÜ' ]+$/", $apellidoPaterno) && preg_match("/^[a-zA-ZñÑáéíóúÁÉÍÓÚÜ' ]+$/", $apellidoMaterno) &&
					preg_match("/^[a-zA-ZñÑáéíóúÁÉÍÓÚÜ' ]+$/", $nombresPersona) && preg_match('/^[0-9]+$/', $dniUsuario)
				) {				
					$modeloPersona = new ModeloPersona();
					$idPersona = $modeloPersona->mdlRegistrarPersona($dniUsuario, $nombresPersona, $apellidoPaterno, $apellidoMaterno);
					if ($idPersona > 0) {
						$modeloAlumno = new ModeloAlumno();
						if ($sede == 5) {
							$codigo = 'H'.$dniUsuario;
						}else if ($sede == 6) {
							$codigo = 'U'.$dniUsuario;
						}else if($sede == 7){
							$codigo = 'T'.$dniUsuario;
						}
						$idAlumno = $modeloAlumno->mdlRegistrarAlumno($idPersona, $codigo);
						$estado = 1;
						$arrData = [];
						if ($idAlumno > 0) {
							for ($i=1; $i <=8 ; $i++) { 
								if (isset($_POST['checkbox'.$i])) {
									$idCursoSeccion = intval($_POST['checkbox'.$i]);
									$fila = array($idAlumno, $seccion, $idCursoSeccion, $idUsuario, $estado, $codigoPago, $montoPago);
									array_push($arrData, $fila);
								}
							}								
							$respuesta = $modeloAlumno->mdlRegistrarCursos($arrData);
							if ($respuesta) {
								return 'ok';
							}
						}
						return 'error';
					}
					return 'error';
				}else{
					return 'no';
				}
			}
		}
		static public function ctrMostrarAlumnos(){
			$modeloAlumno = new ModeloAlumno();
			$alumnos = '';
			if (isset($_POST['idSede']) && !empty($_POST['idSede'])) {
				$alumnos = $modeloAlumno->mdlMostrarAlumnos($_POST['idSede']);
			}else{
				$alumnos = $modeloAlumno->mdlMostrarAlumnos('');
			}
			if (count($alumnos) == 0) {
				$datosJson = '{"data":[]}';
				echo $datosJson;
				return;
			}else{
				$datosJson = '{
				"data":[';
				foreach ($alumnos as $key => $value) {
					$acciones = "";
					if ($value['estadoSubsanacion'] == 1) {
						if ($_SESSION['idUsuarioRol'] != 2) {
							$acciones .= "<div class='btn-group'><button class='btn btn-dark btn-sm btnEliminar' title='ELIMINAR ".$value['nombreCurso']."' idSubsanacion='".$value['idSubsanacion']."'><i class='fa-solid fa-delete-left'></i></button></div>"; 	
						}else{
							$acciones .= "<div class='btn-group'><button class='btn btn-success btn-sm btnAprobar' title='APROBAR A ".$value['datos']."' idSubsanacion='".$value['idSubsanacion']."'><i class='fa-solid fa-user-check'></i></button><button class='btn btn-danger btn-sm btnDesaprobar' title='DESAPROBAR A ".$value['datos']."' idSubsanacion='".$value['idSubsanacion']."'><i class='fa-solid fa-user-xmark'></i></button><button class='btn btn-dark btn-sm btnEliminar' title='ELIMINAR ".$value['nombreCurso']."' idSubsanacion='".$value['idSubsanacion']."'><i class='fa-solid fa-delete-left'></i></button></div>"; 
						}
					}else if ($value['estadoSubsanacion'] == 2) {
						$acciones .= "<div><h3 class='badge badge-success'>Aprobado</h3></div>"; 
					}else if ($value['estadoSubsanacion']==3) {
						$acciones .= "<div><h3 class='badge badge-danger'>Desaprobado</h3></div>"; 	
					}
					$datosJson .='[
							"'.($key+1).'",
							"'.mb_strtoupper($value['nombreSede']).'",
							"'.$value['nombreCarrera'].'",
							"'.$value['nombreCurso'].'",
							"'.$value['nombreSeccion'].'",
							"'.$value['datos'].'",
							"'.$value['dniPersona'].'",
							"'.$value['codigo'].'",
							"'.$value['codigoPago'].'",
							" S/. '.$value['monto'].'",
							"'.$acciones.'"
					],';
				}
				$datosJson = substr($datosJson, 0, -1);
				$datosJson .= ']}';
				return $datosJson;
			}	
		}
		static public function ctrEditarEstadoSubsanar(){
			if (isset($_POST['idSubsanacion']) && !empty($_POST['idSubsanacion']) && isset($_POST['estado'])) {
				$modeloAlumno = new ModeloAlumno();
				$respuesta  = $modeloAlumno->mdlEditarSubsanar('estadoSubsanacion', $_POST['estado'], $_POST['idSubsanacion']);
				if ($respuesta) {
					return 'ok';
				}else{
					return 'error';
				}				
			}
		}
	}