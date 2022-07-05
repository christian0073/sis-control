<?php 
	Class ControladorCarrera{
		/* metodo par registrar una nueva carrera*/
		static public function ctrRegistrarCarrera($nombreCarrera, $idPlan){
			if (isset($nombreCarrera) && isset($idPlan)) {
				if (preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $nombreCarrera)) {
					$modeloCarrera = new ModeloCarrera();
					$respuesta  = $modeloCarrera->mdlRegistrarCarrera($idPlan, $nombreCarrera);
					if ($respuesta > 0) {
						return 'ok';
					}
					return $respuesta;
				}else{
					return 'no';
				}
			}
		}
		/* metodo para mostrar todas las carreras registradas */
		static public function ctrMostrarCarreras(){
			$modeloCarrera = new ModeloCarrera();
			$respuesta = $modeloCarrera->mdlMostrarCarreras();
			return $respuesta;
		}
		/* metodo para mostrar una sola carrera mediante el ID */
		static public function ctrMostrarCarrera($idCarrera){
			$modeloCarrera = new ModeloCarrera();
			$respuesta = $modeloCarrera->mdlMostrarCarrera('idCarrera', $idCarrera);
			return $respuesta;	
		}
		/* metodo para editar carrera */
		static public function ctrEditarCarrera($nombreCarrera, $idCarrera){
			if (isset($nombreCarrera) && isset($idCarrera)) {
				if (preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $nombreCarrera)) {		
					$modeloCarrera = new ModeloCarrera();
					$respuesta  = $modeloCarrera->mdlEditarCarrera($nombreCarrera, $idCarrera);
					if($respuesta > 0){
						return 'ok';
					}
					return $respuesta;
				}else{
					return 'no';
				}
			}	
		}
		/* metodo para registrar una carrera dentro de un local */
		static public function ctrRegistrarCarreraLocal(){
			if (isset($_POST['idLocalCarrera']) && !empty($_POST['idLocalCarrera']) && isset($_POST['cmbCarreras']) && !empty($_POST['cmbCarreras'])) {
				$idLocal = intval($_POST['idLocalCarrera']);
				$idCarrera = intval($_POST['cmbCarreras']);
				$modeloCarrera = new ModeloCarrera();
				$existe = $modeloCarrera->mdlMostrarCarreraLocal($idLocal, $idCarrera);
				if (!empty($existe)) {
					return 'existe';
				}else{
					$respuesta  = $modeloCarrera->mdlRegistrarCarreraLocal($idLocal, $idCarrera);
					if ($respuesta > 0) {
						return 'ok';
					}
					return $respuesta;
				}
			}
		}
		/* metodo que muestre las carreras de un local */
		static public function ctrMostrarCarrerasLocal($idLocal){
			$modeloCarrera = new ModeloCarrera();
			$respuesta = $modeloCarrera->mdlMostrarCarrerasLocal($idLocal);
			return $respuesta;
		}
		/* metodo para editar una carrera dentro de un local */
		static public function ctrEditarEstadoLocalCarrera($idLocalCarrera,  $estado){
			$modeloCarrera = new ModeloCarrera();
			$respuesta  = $modeloCarrera->mdlEditarLocalCarrera($idLocalCarrera, 'estado', $estado);
			if ($respuesta) {
				return 'ok';
			}
			return $respuesta;
		}
		static public function ctrMostrarCarrerasLocalActivo($idLocal){
						$modeloCarrera = new ModeloCarrera();
			$respuesta = $modeloCarrera->mdlMostrarCarrerasLocalActivo($idLocal);
			return $respuesta;
		}
	}