<?php 
	$url= $_SERVER["REQUEST_URI"];
	$components = parse_url($url);
		require 'dompdf/vendor/autoload.php';
		use Dompdf\Dompdf;
		use Dompdf\Options;
	
	if (!isset($components['query'])) {
		header('location: inicio');
		return;		
	}
	parse_str($components['query'], $_POST); 
	if (isset($_POST['idPersonal']) && !empty($_POST['idPersonal']) && isset($_POST['txtFechaBuscar']) && !empty($_POST['txtFechaBuscar'])) {
		$respuesta = ControladorAsistencia::ctrMostrarAsistencias(1);
		if (empty($respuesta)) {
			return 'no';
		}
		ob_start();
		include('vistas/paginas/pdf/reporte-docente.php');
		$html = ob_get_clean();

		// instantiate and use the dompdf class
		$options = new Options();
		$options->set('isRemoteEnabled', TRUE);
		$dompdf = new Dompdf($options);

		$dompdf->loadHtml($html);
		// (Optional) Setup the paper size and orientation
		$dompdf->setPaper('A4', 'landscape');
		// Render the HTML as PDF
		$dompdf->render();
		// Output the generated PDF to Browser
		$dompdf->stream('ficha.pdf',array('Attachment'=>0));
	}else{
		header('location: inicio');
		return;
	}


 ?>
