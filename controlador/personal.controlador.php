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
			if (isset($_POST['txtDniUsuario']) && !empty($_POST['txtDniUsuario']) &&
				isset($_POST['txtApellidoPaterno']) && !empty($_POST['txtApellidoPaterno']) &&
				isset($_POST['txtApellidoMaterno']) && !empty($_POST['txtApellidoMaterno']) &&
				isset($_POST['txtNombres']) && !empty($_POST['txtNombres']) &&
				isset($_POST['cmbCargoPersonal']) && !empty($_POST['cmbCargoPersonal']) &&
				isset($_POST['txtFechaIngreso']) && !empty($_POST['txtFechaIngreso'])
			) {
				$dniUsuario = trim($_POST['txtDniUsuario']);
				$apellidoPaterno = trim($_POST['txtApellidoPaterno']);
				$apellidoMaterno = trim($_POST['txtApellidoMaterno']);
				$nombresPersona = trim($_POST['txtNombres']);
				$idCargoPersonal = intval($_POST['cmbCargoPersonal']);
				$fechaIngresoPersonal = $_POST['txtFechaIngreso'];
				$profesion = trim($_POST['txtProfesion']);
				if (preg_match("/^[a-zA-ZñÑáéíóúÁÉÍÓÚÜ' ]+$/", $apellidoPaterno) && preg_match("/^[a-zA-ZñÑáéíóúÁÉÍÓÚÜ' ]+$/", $apellidoMaterno) &&
					preg_match("/^[a-zA-ZñÑáéíóúÁÉÍÓÚÜ' ]+$/", $nombresPersona) && preg_match('/^[0-9]+$/', $dniUsuario) &&
					(preg_match('/^[\'\/\=\\;\\_\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\.\\$\\|\\-\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $_POST['txtDireccionPersonal']) || empty($_POST['txtDireccionPersonal'])) &&
					(preg_match("/^([a-zA-Z0-9\.]+@+[a-zA-Z]+(\.)+[a-zA-Z]{2,3})$/", $_POST['txtCorreoPersonal']) || empty($_POST['txtCorreoPersonal'])) &&
					validarFecha($fechaIngresoPersonal) && (preg_match("/^[\/\.\\,\\-\\a-zA-ZñÑáéíóúÁÉÍÓÚ' ]+$/", $profesion) || empty($profesion))
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
						$respuesta = $modeloUsuario->mdlRegistrarPersonal($idPersona, $idCargoPersonal, $profesion, $_POST['txtCorreoPersonal'], json_encode($arrCel), $_POST['txtDireccionPersonal'], $fechaIngresoPersonal);
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
						$acciones .= "<button class='btn btn-warning btn-sm btnEditarPersonal' title='Editar ".$datoPersonal."' idPersonal='".$value['idPersonal']."' data-toggle='modal' data-target='#modalEditarPersonal'><i class='fa-solid fa-user-pen'></i></button><a href='persona?idPersonal=".$value['idPersonal']."' class='btn btn-info btn-sm btnVerPersonal' title='Ver datos de  ".$datoPersonal."' idPersonal='".$value['idPersonal']."'><i class='fa-solid fa-eye'></i></a></div>"; 
					}else{
						$acciones .= "<h5><span class='badge badge-dark'>Sin acciones</span></h5></div>"; 
					}
					$turno = '';
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
			isset($_POST['txtBancoPersonal']) && !empty($_POST['txtBancoPersonal']) &&
			isset($_POST['txtNumCuenta']) && !empty($_POST['txtNumCuenta']) &&
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
}