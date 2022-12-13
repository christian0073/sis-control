<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="<?php echo $rutaSistema;?>vistas/css/estilos-pdf.css">
	<title>Horario Sección</title>
</head>
<body>
	<div class="contenedor">
		<table class="tabla-titulo">
			<tbody>
				<tr>
					<td style="width: 5rem;">
						<div class="imagen">
							<img style="width: 100%; text-transform: uppercase;" src="<?php echo $rutaSistema;?>vistas/img/escudo-logo.png">
						</div>
					</td>
					<td>
						<div class="titulo"><h2 class="textcenter">HORARIO <?php echo mb_strtoupper($titulo); ?></h2></div>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="pagina-pdf">
		<table border="1">
			<thead>
				<tr>
					<th colspan="2">HORAS</th>
					<th>LUNES</th>
					<th>MARTES</th>
					<th>MIERCOLES</th>
					<th>JUEVES</th>
					<th>VIERNES</th>
					<th>SABADO</th>					
				</tr>
			</thead>
			<tbody>
					 <?php foreach ($arrHoras as $key => $value): 
					 	$contNumero++;
					 	?>
					 	<tr>
					 		<td class="horas"><?php echo $value['rangoHora']; ?></td>
							<td class="numero"><?php echo $contNumero; ?></td>
				 		<?php 
			 				for ($i=1; $i < 7; $i++) { 
			 					if (isset($value['dia'.$i])) {
					 				echo $value['dia'.$i];
			 					}
			 				}
				 		 ?>
					 	</tr>
					 <?php endforeach ?>
				for
			</tbody>
		</table>
	</div>
</body>
</html>