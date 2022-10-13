<?php 
	Class ControladorPersonal{

		static public function ctrMostrarPersonalDni($dni){
			$item = 'dniPersona';
			$modeloUsuario = new ModeloPersonal();
			$respuesta = $modeloUsuario->mdlMostrarPersonalCampo($item, $dni);
			return $respuesta;
		}
		/* metodo para registrar a un nuevo personal */
		static public function ctrRegistrarPersonal(){
			//echo '<pre>'; print_r($_POST); echo '</pre>';
			if (isset($_POST['txtDniUsuario']) && !empty($_POST['txtDniUsuario']) &&
				isset($_POST['txtApellidoPaterno']) && !empty($_POST['txtApellidoPaterno']) &&
				isset($_POST['txtApellidoMaterno']) && !empty($_POST['txtApellidoMaterno']) &&
				isset($_POST['txtNombres']) && !empty($_POST['txtNombres']) &&
				isset($_POST['cmbCargoPersonal']) && !empty($_POST['cmbCargoPersonal']) 
				//&&
				//isset($_POST['txtFechaIngreso']) && !empty($_POST['txtFechaIngreso']) &&
				//isset($_POST['txtFechaNac']) && !empty($_POST['txtFechaNac'])
			) {
				$dniUsuario = trim($_POST['txtDniUsuario']);
				$apellidoPaterno = trim($_POST['txtApellidoPaterno']);
				$apellidoMaterno = trim($_POST['txtApellidoMaterno']);
				$nombresPersona = trim($_POST['txtNombres']);
				$idCargoPersonal = intval($_POST['cmbCargoPersonal']);
				$fechaIngresoPersonal = $_POST['txtFechaIngreso'];
				$fechaNac = $_POST['txtFechaNac'];
				$profesion = trim($_POST['txtProfesion']);
				if (preg_match("/^[a-zA-ZñÑáéíóúÁÉÍÓÚÜ' ]+$/", $apellidoPaterno) && preg_match("/^[a-zA-ZñÑáéíóúÁÉÍÓÚÜ' ]+$/", $apellidoMaterno) &&
					preg_match("/^[a-zA-ZñÑáéíóúÁÉÍÓÚÜ' ]+$/", $nombresPersona) && preg_match('/^[0-9]+$/', $dniUsuario) &&
					(preg_match('/^[\'\/\=\\;\\_\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\.\\$\\|\\-\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $_POST['txtDireccionPersonal']) || empty($_POST['txtDireccionPersonal'])) &&
					(preg_match("/^([a-zA-Z0-9\.]+@+[a-zA-Z]+(\.)+[a-zA-Z]{2,3})$/", $_POST['txtCorreoPersonal']) || empty($_POST['txtCorreoPersonal'])) &&
					(preg_match("/^[\/\.\\,\\-\\a-zA-ZñÑáéíóúÁÉÍÓÚ' ]+$/", $profesion) || empty($profesion))
				) {
					$arrCel = [];
					for ($i=1; $i <5 ; $i++) { 
						if (isset($_POST['txtCelular'.$i]) && !empty($_POST['txtCelular'.$i])) {
							array_push($arrCel, $_POST['txtCelular'.$i]);
						}
					}
					$modeloPersona = new ModeloPersona();
					$idPersona = $modeloPersona->mdlRegistrarPersona($dniUsuario, $nombresPersona, $apellidoPaterno, $apellidoMaterno);
					if ($idPersona > 0) {
						$modeloUsuario = new ModeloPersonal();
						$respuesta = $modeloUsuario->mdlRegistrarPersonal($idPersona, $idCargoPersonal, $profesion, $_POST['txtCorreoPersonal'], json_encode($arrCel), $_POST['txtDireccionPersonal'], $fechaNac, $fechaIngresoPersonal);
						if ($respuesta > 0) {
							return 'ok';
						}
						return $respuesta;
					}
					return 'error';
				}else{
					return 'no';
				}
			}
		}

		static public function ctrMostrarPersonales(){
			$ModeloPersonal = new ModeloPersonal();
			$personal = '';
			if (isset($_POST['idCargo']) && !empty($_POST['idCargo'])) {
				$personal = $ModeloPersonal->mdlMostrarPersonales($_POST['idCargo']);
			}else{
				$personal = $ModeloPersonal->mdlMostrarPersonales('');
			}
			if (count($personal) == 0) {
				$datosJson = '{"data":[]}';
				echo $datosJson;
				return;
			}else{
				$datosJson = '{
				"data":[';
				foreach ($personal as $key => $value) {
					$datoPersonal = $value['apellidoPaternoPersona'].' '.$value['apellidoMaternoPersona'].', '.$value['nombresPersona'];
					$acciones = "<div class='btn-group'>";
					if ($value['estadoPersonal'] == 1) {
						if ($_SESSION['idUsuarioRol'] == 4) {
							$acciones .= "<a href='persona?idPersonal=".$value['idPersonal']."' class='btn btn-info btn-sm btnVerPersonal' title='Ver datos de  ".$datoPersonal."' idPersonal='".$value['idPersonal']."'><i class='fa-solid fa-eye'></i></a></div>"; 	
						}else{
							$acciones .= "<button class='btn btn-warning btn-sm btnEditarPersonal' title='Editar ".$datoPersonal."' idPersonal='".$value['idPersonal']."' data-toggle='modal' data-target='#modalEditarPersonal'><i class='fa-solid fa-user-pen'></i></button><a href='persona?idPersonal=".$value['idPersonal']."' class='btn btn-info btn-sm btnVerPersonal' title='Ver datos de  ".$datoPersonal."' idPersonal='".$value['idPersonal']."'><i class='fa-solid fa-eye'></i></a><button class='btn btn-dark btn-sm btnEliminarPersonal' title='Eliminar ".$datoPersonal."' idPersonal='".$value['idPersonal']."' data-toggle='modal' data-target='#modalEliminarPersonal'><i class='fa-solid fa-delete-left'></i></button></div>"; 
						}
					}else{
						$acciones .= "<h5><span class='badge badge-dark'>Sin acciones</span></h5></div>"; 
					}
					$celularPersonal = '';
					$celulares = '';
					$fechaCese = $value['fechaSalidaPersonal'];
					if ($value['celularPersonal'] != '[]' ) {
						$celularPersonal = json_decode($value['celularPersonal'], true);
						for ($i=0; $i < count($celularPersonal) ; $i++) { 
							$celulares .= $celularPersonal[$i].', ';
						}
						$celulares = substr($celulares, 0, -2);		
					}
					if (empty($fechaCese)) {
						$fechaCese = "<h5><span class='badge badge-info'>Vigente</span></h5>";
					}
					$datosJson .='[
							"'.($key+1).'",
							"'.$value['nombreCargo'].'",
							"'.$datoPersonal.'",
							"'.$value['dniPersona'].'",
							"'.$value['profesionPersonal'].'",
							"'.$value['correoPersonal'].'",
							"'.$celulares.'",
							"'.$value['direccionPersonal'].'",
							"'.$value['fechaIngresoPersonal'].'",
							"'.$fechaCese.'",
							"'.$acciones.'"
					],';
				}
				$datosJson = substr($datosJson, 0, -1);
				$datosJson .= ']}';
				return $datosJson;
		}
	}
	static public function ctrMostrarPersonalId($idPersonal){
		$item = 'idPersonal';
		$ModeloPersonal = new ModeloPersonal();
		$respuesta = $ModeloPersonal->mdlMostrarPersonalCampo($item, $idPersonal);
		$respuesta['celularPersonal'] = json_decode($respuesta['celularPersonal']);
		return $respuesta;
	}
	/* metodo para editar los datos de un personal */
	static public function ctrEditarPersonal(){
		if (isset($_POST['idPersonal']) && !empty($_POST['idPersonal']) &&
			isset($_POST['cmbCargoPersonalEditar']) && !empty($_POST['cmbCargoPersonalEditar']) &&
			isset($_POST['txtFechaIngresoEditar']) && !empty($_POST['txtFechaIngresoEditar'])
		) {
			$idPersonal = intval($_POST['idPersonal']);
			$idCargoPersonal = intval($_POST['cmbCargoPersonalEditar']);
			$fechaIngresoPersonal = $_POST['txtFechaIngresoEditar'];
			$profesion = trim($_POST['txtProfesionEditar']);
			if ((preg_match('/^[\'\/\=\\;\\_\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\.\\$\\|\\-\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $_POST['txtDireccionPersonalEditar']) || empty($_POST['txtDireccionPersonalEditar']))
				&& validarFecha($fechaIngresoPersonal) && (preg_match("/^[\/\.\\,\\-\\a-zA-ZñÑáéíóúÁÉÍÓÚ' ]+$/", $profesion) || empty($profesion)) &&
				(preg_match("/^([a-zA-Z0-9\.]+@+[a-zA-Z]+(\.)+[a-zA-Z]{2,3})$/", $_POST['txtCorreoPersonalEditar']) || empty($_POST['txtCorreoPersonalEditar']))
			) {
				$arrCel = [];
				for ($i=1; $i <5 ; $i++) { 
					if (isset($_POST['txtCelularEdit'.$i]) && !empty($_POST['txtCelularEdit'.$i])) {
						array_push($arrCel, $_POST['txtCelularEdit'.$i]);
					}
				}
				$modeloPersonal = new ModeloPersonal();
				$respuesta = $modeloPersonal->mdlEditarPersonal($idPersonal, $idCargoPersonal, $profesion, $_POST['txtCorreoPersonalEditar'], json_encode($arrCel), $_POST['txtDireccionPersonalEditar'], $fechaIngresoPersonal);
				if ($respuesta) {
					return 'ok';
				}
				return $respuesta;
			}else{
				return 'no';
			}
		}
	}
	/* metodo para editar los detalles de un personal */
	static public function ctrEditarDetallesPersonal(){
		if (isset($_POST['idPersonal']) && !empty($_POST['idPersonal']) &&
			//isset($_POST['txtBancoPersonal']) && !empty($_POST['txtBancoPersonal']) &&
			//isset($_POST['txtNumCuenta']) && !empty($_POST['txtNumCuenta']) &&
			isset($_POST['cmbTipoPago']) && !empty($_POST['cmbTipoPago']) &&
			isset($_POST['txtMontoPersonal']) && !empty($_POST['txtMontoPersonal'])
		) {
			$idPersonal = intval($_POST['idPersonal']);
			$bancoPersonal = trim($_POST['txtBancoPersonal']);
			$numCuenta = trim($_POST['txtNumCuenta']);
			$tipoPago = trim($_POST['cmbTipoPago']);
			$monto = trim($_POST['txtMontoPersonal']);
			$modeloPersonal = new ModeloPersonal();
			$respuesta = $modeloPersonal->mdlEditarDetallesPersonal($idPersonal, $bancoPersonal, $numCuenta, $tipoPago, $monto);
			if ($respuesta) {
				return 'ok';
			}
			return $respuesta;
		}else{
			return 'no';
		}
	}
	static public function ctrEditarEstadoPersonal(){
		if (isset($_POST['idPersonalEl']) && !empty($_POST['idPersonalEl']) &&
			isset($_POST['txtFechaSalida']) && !empty($_POST['txtFechaSalida'])
		) {
			if (!validarFecha($_POST['txtFechaSalida'])) {
				return 'no';
			}
			$fechasalida = $_POST['txtFechaSalida'];
			$idPersonal = intval($_POST['idPersonalEl']);
			$modeloPersonal = new ModeloPersonal();
			$editar = $modeloPersonal->mdlEditarEstadoPersonal($idPersonal, $fechasalida, FALSE);
			if ($editar) {
				$modeloCurso = new ModeloCursoAula();
				$cursos = $modeloCurso->mdlMostrarCurosDoc($idPersonal);
				if (!empty($cursos)) {
					$editarCursos= $modeloCurso->mdlEditarCursoVarios($idPersonal, NULL);
					$consulta = '';
					if ($editarCursos) {
						foreach ($cursos as $key => $value) {
							$idHorarioCurso = $value['idHorarioCurso'];
							$consulta .= "DELETE FROM detallehorario WHERE idHorarioCurso = $idHorarioCurso;";
						}
						$borrarRegistro = $modeloCurso->mdlEliminarCursoDocente($consulta);
						if ($borrarRegistro) {
							return 'ok';
						}						
					}else{
						return 'error';
					}
				}
				else{
					return 'ok';
				}
			}
		}else{
			return 'no';
		}
	}
	static public function ctrMostrarDocentes(){
		$modeloPersonal = new ModeloPersonal();
		$personal = $modeloPersonal->mdlMostrarPersonales(1);
		return $personal;
	}
	static public function ctrMostrarListaDocentes(){
		$ModeloPersonal = new ModeloPersonal();
		$personal = '';
		$personal = $ModeloPersonal->mdlMostrarPersonales(1);
		if (count($personal) == 0) {
			$datosJson = '{"data":[]}';
			echo $datosJson;
			return;
		}else{
			$datosJson = '{
			"data":[';
			foreach ($personal as $key => $value) {
				$datoPersonal = $value['apellidoPaternoPersona'].' '.$value['apellidoMaternoPersona'].', '.$value['nombresPersona'];
				$acciones = "";
				$modeloCursoAula = new ModeloCursoAula;
				$examenes = $modeloCursoAula->mdlCantidadExamenesRegistrados($value['idPersonal']);
				$estilo = ["","","",""];
				$editar = [0,0,0,0];
				foreach ($examenes as $key1 => $valor) {
					$porcentaje = round(($valor['entregado']*100)/$valor['cantidad'], 2);
					if ($valor['idParcial'] == 1) {
						$estilo[0] = "color: #FFF; background: linear-gradient(to top, #007bff $porcentaje%, rgba(0, 0, 0,0.1) 30%);";
						$editar[0] = 1;
					}else if ($valor['idParcial'] ==2) {
						$estilo[1] = "color: #FFF; background: linear-gradient(to top, #17a2b8 $porcentaje%, rgba(0, 0, 0,0.1) 30%);";
						$editar[1] = 1;
					}else if ($valor['idParcial'] ==3) {
						$estilo[2] = "color: #FFF; background: linear-gradient(to top, #6c757d $porcentaje%, rgba(0, 0, 0,0.1) 30%);";
						$editar[2] = 1;
					}else if ($valor['idParcial'] ==4) {
						$estilo[3] = "color: #FFF; background: linear-gradient(to top, #6c757d $porcentaje%, rgba(0, 0, 0,0.1) 30%);";
						$editar[3] = 1;
					}					
				}
				if ($value['estadoPersonal'] == 1) {
					$acciones .= "<div class='btn-group'><button class='btn btn-outline-primary btn-sm btnParcial1' style='".$estilo[0]."' editar='".$editar[0]."' idParcial='1' title='Registrar examenes del primer parcial' idPersonal='".$value['idPersonal']."' data-toggle='modal' data-target='#modalParcial'>P1</button><button class='btn btn-outline-info btn-sm btnParcial2' editar='".$editar[1]."' idParcial='2' title='Registrar examenes del segundo parcial' style='".$estilo[1]."' idPersonal='".$value['idPersonal']."' data-toggle='modal' data-target='#modalParcial'>P2</button><button class='btn btn-outline-secondary btn-sm btnParcial3' style='".$estilo[2]."' editar='".$editar[2]."' idParcial='3' title='Registrar examenes del tercer parcial' idPersonal='".$value['idPersonal']."' data-toggle='modal' data-target='#modalParcial'>P3</button><button class='btn btn-outline-dark btn-sm btnParcial4' style='".$estilo[3]."' editar='".$editar[3]."' idParcial='4' title='Registrar examenes del cuarto parcial' idPersonal='".$value['idPersonal']."' data-toggle='modal' data-target='#modalParcial'>P4</button></div>"; 
				}else{
					$acciones .= "<h5><span class='badge badge-dark'>Sin acciones</span></h5></div>"; 
				}
				$celularPersonal = '';
				$celulares = '';
				$fechaCese = $value['fechaSalidaPersonal'];
				if ($value['celularPersonal'] != '[]' ) {
					$celularPersonal = json_decode($value['celularPersonal'], true);
					for ($i=0; $i < count($celularPersonal) ; $i++) { 
						$celulares .= $celularPersonal[$i].', ';
					}
					$celulares = substr($celulares, 0, -2);		
				}
				if (empty($fechaCese)) {
					$fechaCese = "<h5><span class='badge badge-info'>Vigente</span></h5>";
				}
				$datosJson .='[
						"'.($key+1).'",
						"'.$datoPersonal.'",
						"'.$value['dniPersona'].'",
						"'.$value['profesionPersonal'].'",
						"'.$value['correoPersonal'].'",
						"'.$celulares.'",
						"'.$fechaCese.'",
						"'.$acciones.'"
				],';
			}
			$datosJson = substr($datosJson, 0, -1);
			$datosJson .= ']}';
			return $datosJson;
		}
	}
}