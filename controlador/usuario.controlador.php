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
	}