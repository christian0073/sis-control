<?php 
	require_once "controlador/ruta.controlador.php";
	require_once "controlador/plantilla.controlador.php";

	require_once "controlador/carrera.controlador.php";
	require_once "modelo/carrera.modelo.php";

	require_once "controlador/plan.controlador.php";
	require_once "modelo/plan.modelo.php";

	require_once "controlador/periodo.controlador.php";
	require_once "modelo/periodo.modelo.php";

	require_once "controlador/sede.controlador.php";
	require_once "modelo/sede.modelo.php";

	require_once "controlador/cargo.controlador.php";
	require_once "modelo/cargo.modelo.php";
	
	$plantilla = new ControladorPlantilla();
	$plantilla->ctrPlantilla();
 ?>