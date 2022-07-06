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
				if (preg_match("/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/", $apellidoPaterno) && preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $apellidoMaterno) &&
					preg_match("/^[a-zA-ZñÑáéíóúÁÉÍÓÚÜ' ]+$/", $nombresPersona) && preg_match('/^[0-9]+$/', $dniUsuario) &&
					(preg_match('/^[\/\=\\;\\_\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\.\\$\\|\\-\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $_POST['txtDireccionPersonal']) || empty($_POST['txtDireccionPersonal'])) &&
					(preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)[.][a-zA-Z]{2,4}$/', $_POST['txtCorreoPersonal']) || empty($_POST['txtCorreoPersonal'])) &&
					validarFecha($fechaIngresoPersonal)
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
						$respuesta = $modeloUsuario->mdlRegistrarPersonal($idPersona, $idCargoPersonal, $_POST['txtCorreoPersonal'], json_encode($arrCel), $_POST['txtDireccionPersonal'], $fechaIngresoPersonal);
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

		static public function ctrMostrarPersonal(){
			$ModeloPersonal = new ModeloPersonal();
			$personal = '';
			if (isset($_POST['idCargo']) && !empty($_POST['idCargo'])) {
				$personal = $ModeloPersonal->mdlMostrarPersonal($_POST['idCargo']);
			}else{
				$personal = $ModeloPersonal->mdlMostrarPersonal('');
			}
			if (count($personal) == 0) {
				$datosJson = '{"data":[]}';
				echo $datosJson;
				return;
			}else{
				$datosJson = '{
				"data":[';
				foreach ($personal as $key => $value) {
					$datoUsuario = $value['apellidoPaternoPersona'].' '.$value['apellidoMaternoPersona'].', '.$value['nombresPersona'];
					$acciones = "<div class='btn-group'>";
					if ($value['estadoPersonal'] == 1) {
						$acciones .= "<button class='btn btn-warning btn-sm btnEditarPersonal' title='Editar ".$datoUsuario."' idPersonal='".$value['idPersonal']."' data-toggle='modal' data-target='#modalEditarPersonal'><i class='fa-solid fa-user-pen'></i></button></div>"; 
					}else{
						$acciones .= "<h5><span class='badge badge-dark'>Sin acciones</span></h5>"; 
					}
					$turno = '';
					$celularUsuario = '';
					$celulares = '';
					if ($value['celularUsuario'] != '[]' ) {
						$celularUsuario = json_decode($value['celularUsuario'], true);
						for ($i=0; $i < count($celularUsuario) ; $i++) { 
							$celulares .= $celularUsuario[$i].', ';
						}
						$celulares = substr($celulares, 0, -2);		
					}
					$datosJson .='[
							"'.($key+1).'",
							"'.$value['nombreSede'].'",
							"'.$datoUsuario.'",
							"'.$value['dniPersona'].'",
							"'.$value['nombreUsuario'].'",
							"'.$value['nombreRol'].'",
							"'.$celulares.'",
							"'.$estado.'",
							"'.$acciones.'"
					],';
				}
				$datosJson = substr($datosJson, 0, -1);
				$datosJson .= ']}';
				return $datosJson;
		}
	}