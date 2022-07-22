<?php
	session_start();
	$rutaSistema= ControladorRuta::ctrRuta();
?>
<!DOCTYPE html>
<html lang="es">
	<?php  
		if (!isset($_SESSION['usuarioInciar'])) {
			include "paginas/login.php";
		}else{
			if (isset($_GET['pagina'])) {
				include "paginas/modulos/header.php";
				include "paginas/modulos/menu.php";
				if ($_GET['pagina'] == 'inicio' || $_GET['pagina'] == 'sedes' || $_GET['pagina'] == 'carreras' || $_GET['pagina'] == 'periodos' || $_GET['pagina'] == 'secciones' || 
					$_GET['pagina'] == 'usuarios' || $_GET['pagina'] == 'salir' || $_GET['pagina'] == 'registrar' || $_GET['pagina'] == 'persona' || $_GET['pagina'] == 'supervisar' || $_GET['pagina'] == 'cambios') {
					include "paginas/".$_GET['pagina'].".php";
					include "paginas/modulos/footer.php";
					echo '<script type="text/javascript" src="vistas/js/'.$_GET['pagina'].'.js"></script>';
				}else{
					include "paginas/modulos/menu.php";
					include "paginas/error.php";
					include "paginas/modulos/footer.php";
				}
			}else{
				include "paginas/modulos/header.php";
				include "paginas/modulos/menu.php";
				include "paginas/inicio.php";
				include "paginas/modulos/footer.php";
			}
		 	?>
			</body>
	 	<?php 
		}
	 	 ?>
</html>
