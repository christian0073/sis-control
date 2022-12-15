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
						<div class="titulo"><h2 class="textcenter">REPORTE DE ASISTENCIA DEL DOCENTE <?php echo $respuesta[0]['datos']; ?></h2></div>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="pagina-pdf">
		<table class="tabla-reporte" border="1">
			<thead>
				<tr>
					<th>N°</th>
					<th style="width: 180px;">SUPERVISORA</th>
					<th>DIA ASIS.</th>
					<th style="width: 180px;">CURSO</th>
					<th>AULA</th>
					<th style="width: 180px;">OBSERVACIÓN</th>
					<th>ESTADO</th>
					<th>TIEMPO</th>
					<th>X HORA</th>
					<th>PAGO</th>
				</tr>
			</thead>
			<tbody>
				<?php $cont = 1;
				$total = count($respuesta)-1;
				foreach ($respuesta as $key => $value): 
					?>
					<tr>
                        <td><?php echo $cont;?></td>
                        <td><?php echo $value['datosUsuario']; ?></td>
                        <td><?php echo $value['fechaAsiste']; ?></td>
                        <td><?php echo $value['nombreCurso']; ?></td>
                        <td><?php echo $value['nombreSeccion']; ?></td>
                        <td><?php echo $value['observacion']; ?></td>
                        <td><?php echo $value[0]['estadoLet']; ?></td>
                        <td><?php echo $value[0]['minutos'].' - '.$value[0]['horasTrab']; ?></td>
                        <td>S/. <?php echo $value[0]['pago']; ?></td>
                        <td>S/. <?php echo $value[0]['pagoHora']; ?></td>
                    </tr>				
                    <?php 
						if ($cont == $total) {
							break;
						}
                    	$cont++;
                     ?>
				<?php endforeach ?>
			</tbody>
			<tfoot>
				<tr class='font-weight-bold'>
                    <td colspan='7'>TOTAL</td>
                    <td><?php echo $respuesta['total'][0].' - '.$respuesta['total'][0]; ?></td>
                    <td colspan='2'>S/. <?php echo $respuesta['total'][0]; ?></td>
                </tr>				
			</tfoot>
		</table>
	</div>
</body>
</html>