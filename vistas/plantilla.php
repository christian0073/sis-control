<?php
	session_start();
	$rutaSistema= ControladorRuta::ctrRuta();	
	if (isset($_GET['pagina']) && $_GET['pagina']=='excel') {
		include "paginas/excel.php";
		return;
	}
	if (isset($_GET['pagina']) && $_GET['pagina']=='reporte-pdf') {
		include "paginas/reporte-pdf.php";
		return;
	}
	if (isset($_GET['pagina']) && $_GET['pagina']=='reporte-docente') {
		include "paginas/reporte-docente.php";
		return;
	}
?>
<!DOCTYPE html>
<html lang="es">
	<?php  
		if (!isset($_SESSION['usuarioInciar'])) {
			include "paginas/login.php";
		}else{
			$usuarioActivo = ControladorUsuario::ctrMostrarUsuarioId($_SESSION['idUsuarioSis']);
			$idUsuarioRol = $_SESSION['idUsuarioRol'];
			if (isset($_GET['pagina'])) {
				$pagina = 'error';
				if ($_GET['pagina'] == 'inicio' || $_GET['pagina'] == 'sedes' || $_GET['pagina'] == 'carreras' || $_GET['pagina'] == 'periodos' || $_GET['pagina'] == 'secciones' || $_GET['pagina'] == 'usuarios' ||
					$_GET['pagina'] == 'salir' || $_GET['pagina'] == 'registrar' || $_GET['pagina'] == 'persona' || $_GET['pagina'] == 'supervisar' || $_GET['pagina'] == 'cambios' || $_GET['pagina'] == 'reprogramar'
					|| $_GET['pagina'] == 'seccion' || $_GET['pagina'] == 'usuarios' || $_GET['pagina'] == 'pagos' || $_GET['pagina'] == 'subsanaciones' || $_GET['pagina'] == 'importar-asistencia' || 
					$_GET['pagina'] == 'procesado'|| $_GET['pagina'] == 'examenes' || $_GET['pagina'] == 'lista-examenes' || $_GET['pagina'] == 'error' || $_GET['pagina'] == 'corregir'
				){
					$pagina = $_GET['pagina'];
				}else{
					header('Location: '.$rutaSistema.'error');
				}
				include "paginas/modulos/header.php";
				include "paginas/modulos/menu.php";
				include "paginas/".$pagina.".php";					
				include "paginas/modulos/footer.php";
				echo '<script type="text/javascript" src="vistas/js/'.$pagina.'.js"></script>';
			}else{
				include "paginas/modulos/header.php";
				include "paginas/modulos/menu.php";
				include "paginas/inicio.php";
				include "paginas/modulos/footer.php";
				echo '<script type="text/javascript" src="vistas/js/inicio.js"></script>';
			}
		 	?>
			</body>
	 	<?php 
		}
	 	 ?>
</html>
