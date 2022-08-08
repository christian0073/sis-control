<?php 
	Class ControladorUsuario{
		
		static public function ctrIngresoUsuario($usuario, $contra){
			if (isset($usuario)) {
				if (preg_match('/^[a-zA-Z0-9]+$/', $usuario) && preg_match('/^[a-zA-Z0-9]+$/', $contra)) {
					//$encriptarPassword = crypt($contra, '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
					$valor = $usuario;
					$atributo = 'nombreUsuario';
					$ingresar = new ModeloUsuario();
					$respuesta  = $ingresar->mdlMostrarUsuario($atributo, $valor);
					if (!$respuesta) {
						return 'novalido';	
					}else if ($respuesta['nombreUsuario'] == $usuario && $respuesta['contraUsuario'] == $contra) { 
						$_SESSION['usuarioInciar'] = 'ok';
						$_SESSION['idUsuarioSis'] = $respuesta['idUsuario'];
						$_SESSION['idUsuarioRol'] = $respuesta['idRol'];
						$periodoActivo = ControladorPeriodo::ctrMostrarPeriodoActivo();
						$_SESSION['idPeriodo'] = $periodoActivo['idPeriodo'];
						return "ok";
					}else{
						return "novalido";
					}
				}else{
					return 'no';
				}
			}
		}
		static public function ctrMostrarRoles(){
			$roles = new ModeloUsuario();
			$respuesta  = $roles->mdlMostrarRoles();
			return $respuesta;
		}

		static public function ctrMostrarUsuarioDni($dni){
			$item = 'dniPersona';
			$modeloUsuario = new ModeloUsuario();
			$respuesta = $modeloUsuario->mdlMostrarUsuarioCampo($item, $dni);
			return $respuesta;
		}

		static public function ctrRegistrarUsuario(){
			if (isset($_POST['txtDniUsuario']) && !empty($_POST['txtDniUsuario']) &&
				isset($_POST['txtApellidoPaterno']) && !empty($_POST['txtApellidoPaterno']) &&
				isset($_POST['txtApellidoMaterno']) && !empty($_POST['txtApellidoMaterno']) &&
				isset($_POST['txtNombres']) && !empty($_POST['txtNombres']) &&
				isset($_POST['cmbRolUsuario']) && !empty($_POST['cmbRolUsuario']) && 
				isset($_POST['txtUsuarioNombre']) && !empty($_POST['txtUsuarioNombre']) &&
				isset($_POST['txtUsuarioContra']) && !empty($_POST['txtUsuarioContra'])
			) {
				$dniUsuario = trim($_POST['txtDniUsuario']);
				$apellidoPaterno = trim($_POST['txtApellidoPaterno']);
				$apellidoMaterno = trim($_POST['txtApellidoMaterno']);
				$nombresPersona = trim($_POST['txtNombres']);
				$idRolUsuario = intval($_POST['cmbRolUsuario']);
				$usuarioNombre = trim($_POST['txtUsuarioNombre']);
				$usuarioContra = trim($_POST['txtUsuarioContra']);
				if (preg_match("/^[a-zA-ZñÑáéíóúÁÉÍÓÚÜ' ]+$/", $apellidoPaterno) && preg_match("/^[a-zA-ZñÑáéíóúÁÉÍÓÚÜ' ]+$/", $apellidoMaterno) &&
					preg_match("/^[a-zA-ZñÑáéíóúÁÉÍÓÚÜ' ]+$/", $nombresPersona) && preg_match('/^[0-9]+$/', $dniUsuario) && preg_match("/^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚÜ' ]+$/", $usuarioNombre) && preg_match("/^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚÜ' ]+$/", $usuarioContra)
				) {
					$modeloPersona = new ModeloPersona();
					$idPersona = $modeloPersona->mdlRegistrarPersona($dniUsuario, $nombresPersona, $apellidoPaterno, $apellidoMaterno);
					if ($idPersona > 0) {
						$modeloUsuario = new ModeloUsuario();
						$respuesta = $modeloUsuario->mdlRegistrarUsuario($idPersona, $idRolUsuario, $usuarioNombre, $usuarioContra);
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

		static public function ctrMostrarUsuarios(){
			$modeloUsuario = new ModeloUsuario();
			$usuarios = '';
			$usuarios = $modeloUsuario->mdlMostrarUsarios();
			if (count($usuarios) == 0) {
				$datosJson = '{"data":[]}';
				echo $datosJson;
				return;
			}else{
				$datosJson = '{
				"data":[';
				foreach ($usuarios as $key => $value) {
					$datosUsuario = $value['apellidoPaternoPersona'].' '.$value['apellidoMaternoPersona'].', '.$value['nombresPersona'];
					$acciones = "<div class=' text-center'>";
					if ($value['estadoUsuario'] == 1) {
						$acciones .= "<button class='btn btn-warning btn-sm btnEditarPersonal' title='Editar ".$datosUsuario."' idUsuario='".$value['idUsuario']."' data-toggle='modal' data-target='#modalEditarUsuario'><i class='fa-solid fa-user-pen'></i><button class='btn btn-dark btn-sm btnEliminarUsuario' title='Eliminar ".$datosUsuario."' idUsuario='".$value['idUsuario']."'><i class='fa-solid fa-delete-left'></i></button></div>"; 
					}else{
						$acciones .= "<h5><span class='badge badge-dark'>Sin acciones</span></h5></div>"; 
					}
					$datosJson .='[
							"'.($key+1).'",
							"'.$datosUsuario.'",
							"'.$value['nombreUsuario'].'",
							"'.$value['contraUsuario'].'",
							"'.$value['nombreRol'].'",
							"'.$acciones.'"
					],';
				}
			$datosJson = substr($datosJson, 0, -1);
			$datosJson .= ']}';
			return $datosJson;
		}
	}
	}