<?php 
	Class ControladorDatos{
		
		static public function ctrContarDocentes($idPeriodo){
			$modeloDatos = new ModeloDatos();
			$respuesta = $modeloDatos->mdlContarDocentes($idPeriodo);
			return $respuesta;
		}
		static public function ctrContarAlumnos(){
			$modeloDatos = new ModeloDatos();
			$respuesta = $modeloDatos->mdlContarAlumnos();
			return $respuesta;
		}
		static public function ctrAsistenciasDocentesMeses($idPersonal){
			$periodo = new ModeloPeriodo();
			$periodoDatos = $periodo->mdlMostrarPeriodoCampo('estadoPeriodo', TRUE);
			$modeloDatos = new ModeloDatos();
			$asistencia = $modeloDatos->mdlAsistenciasDocentesMeses($periodoDatos['fechaInicio'], $periodoDatos['fechaFin'], $idPersonal);
			$meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Setiembre', 'Octubre', 'Noviembre', 'Diciembre'];
			$cantidad = [];
			$mesesNuevo = [];
			$cantMeses = 0;
			foreach ($asistencia as $key => $value) {
				$cantidad[$key] = $value['cantidad'];
				$mesesNuevo[$key] = $meses[$value['mes']];
				$cantMeses++;
			}
			$respuesta = array("datos"=>$cantidad, "label"=>$mesesNuevo, "cantidadMeses"=>$cantMeses);
			return json_encode($respuesta);
		}
	}