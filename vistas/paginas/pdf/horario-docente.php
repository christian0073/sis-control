<!DOCTYPE html>
<html lang="en">
<head>
	<link rel="stylesheet" type="text/css" href="<?php echo $rutaSistema;?>vistas/css/estilos-pdf.css">
	<title>Horario docente</title>
</head>
<body>
	<div class="contenedor">
		<table class="tabla-titulo">
			<tbody>
				<tr>
					<td style="width: 5rem;">
						<div class="imagen">
							<img style="width: 100%;" src="<?php echo $rutaSistema;?>vistas/img/escudo-logo.png">
						</div>
					</td>
					<td>
						<div class="titulo"><h2 class="textcenter">HORARIO <?php echo $personal['apellidoPaternoPersona'].' '.$personal['apellidoMaternoPersona'].' '.$personal['nombresPersona']; ?></h2></div>
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
			<tfoot>
				<tr>
					<td colspan="7">TOTAL DE HORAS</td>
					<td><?php echo $horasSemana; ?> HORAS</td>
				</tr>
			</tfoot>
		</table>
	</div>
</body>
</html>