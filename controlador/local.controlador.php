<?php 
	Class ControladorLocal{
		/* metodo par registrar una nueva sede*/
		static public function ctrRegistrarLocal(){
			if (isset($_POST['txtDepartamento']) && !empty($_POST['txtDepartamento']) &&
				isset($_POST['txtProvincia']) && !empty($_POST['txtProvincia']) &&
				isset($_POST['txtDistrito']) && !empty($_POST['txtDistrito']) &&
				isset($_POST['txtCodigo']) && !empty($_POST['txtCodigo']) &&
				isset($_POST['txtCodigoLocal']) && !empty($_POST['txtCodigoLocal']) &&
				isset($_POST['idSede']) && !empty($_POST['idSede'])
			) {
				$departamento = $_POST['txtDepartamento'];
				$provincia = $_POST['txtProvincia'];
				$distrito = $_POST['txtDistrito'];
				$codigoModular = $_POST['txtCodigo'];
				$codigoLocal = $_POST['txtCodigoLocal'];
				$idSede = intval($_POST['idSede']);
				if (preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $departamento) &&
					preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $provincia) &&
					preg_match('/^[\/\=\\_\\.\\-\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $distrito) && 
					preg_match('/^[0-9]+$/', $codigoModular) &&
					preg_match('/^[0-9]+$/', $codigoLocal) &&
					(preg_match('/^[\/\=\\;\\_\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\.\\$\\|\\-\\°\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $_POST['txtDireccion']) || empty($_POST['txtDireccion'])) 
				){
					$arrDepartamento = json_encode(array("ubigeo" => $_POST['cmbDepartamento'], "nombre" => $departamento));
					$arrProvincia = json_encode(array("ubigeo" => $_POST['cmbProvincia'], "nombre" => $provincia));
					$arrDistrito = json_encode(array("ubigeo" => $_POST['cmbDistrito'], "nombre" => $distrito));
					$modeloLocal = new ModeloLocal();
					$respuesta = $modeloLocal->mdlRegistrarLocal($idSede, $codigoModular, $codigoLocal, $arrDepartamento, $arrProvincia, $arrDistrito, $_POST['txtDireccion']);
					if ($respuesta > 0) {
						return 'ok';
					}
					return 'error';
				}else{
					return 'no';
				}
			}
		}
		/* funcion que retorna todas las sedes registradas */
		static public function ctrMostrarLocales($idSede){
			$modeloLocal = new ModeloLocal();
			$respuesta = $modeloLocal->mdlMostrarLocales($idSede);
			return $respuesta;
		}
		/* función que retorna todos lo datos de un local */
		static public function ctrMostrarLocal($idLocal){
			$modeloLocal = new ModeloLocal();
			$respuesta = $modeloLocal->mdlMostrarLocal($idLocal);
			return $respuesta;	
		}
		/* función para editar los datos de un local */
		static public function ctrEditarLocal(){
			if (isset($_POST['txtDepartamento']) && !empty($_POST['txtDepartamento']) &&
				isset($_POST['txtProvincia']) && !empty($_POST['txtProvincia']) &&
				isset($_POST['txtDistrito']) && !empty($_POST['txtDistrito']) &&
				isset($_POST['txtCodigo']) && !empty($_POST['txtCodigo']) &&
				isset($_POST['txtCodigoLocal']) && !empty($_POST['txtCodigoLocal']) &&
				isset($_POST['idLocal']) && !empty($_POST['idLocal'])
			) {
				$departamento = $_POST['txtDepartamento'];
				$provincia = $_POST['txtProvincia'];
				$distrito = $_POST['txtDistrito'];
				$codigoModular = $_POST['txtCodigo'];
				$codigoLocal = $_POST['txtCodigoLocal'];
				$idLocal = intval($_POST['idLocal']);
				if (preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $departamento) &&
					preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $provincia) &&
					preg_match('/^[\/\=\\_\\.\\-\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $distrito) && 
					preg_match('/^[0-9]+$/', $codigoModular) &&
					preg_match('/^[0-9]+$/', $codigoLocal) &&
					(preg_match('/^[\/\=\\;\\_\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\.\\$\\|\\-\\°\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $_POST['txtDireccion']) || empty($_POST['txtDireccion'])) 
				){
					$arrDepartamento = json_encode(array("ubigeo" => $_POST['cmbDepartamento'], "nombre" => $departamento));
					$arrProvincia = json_encode(array("ubigeo" => $_POST['cmbProvincia'], "nombre" => $provincia));
					$arrDistrito = json_encode(array("ubigeo" => $_POST['cmbDistrito'], "nombre" => $distrito));
					$modeloLocal = new ModeloLocal();
					$respuesta = $modeloLocal->mdlEditarLocal($idLocal, $codigoModular, $codigoLocal, $arrDepartamento, $arrProvincia, $arrDistrito, $_POST['txtDireccion']);
					if ($respuesta) {
						return 'ok';
					}
					return 'error';
				}else{
					return 'no';
				}
			}
		}
		static public function ctrEditarLocalCampo($item, $valor, $idLocal){
			$modeloLocal = new ModeloLocal();
			$respuesta = $modeloLocal->mdlEditarLocalCampo($item, $valor, $idLocal);
			if ($respuesta) {
				return 'ok';
			}else{
				return 'error';
			}
		}
		static public function ctrMostrarLocalSede($idLocalSeccion){
			$modeloLocal = new ModeloLocal();
			$respuesta = $modeloLocal->mdlMostrarLocalSede($idLocalSeccion);
			return $respuesta;	
		}
	}