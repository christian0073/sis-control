<?php 
	class ControladorCursoAula {
		/* metodo para mostrar todos loe cursos de un aula */
		static public function ctrMostrarCursosAula($idAula){
			$modeloCursoAula = new ModeloCursoAula();
			$respuesta = $modeloCursoAula->mdlMostrarCursosAula($idAula);
			return $respuesta;
		}
	}
	