<?php 
	$url= $_SERVER["REQUEST_URI"];
	$components = parse_url($url);
	$modeloAlumno = new ModeloAlumno();
	parse_str($components['query'], $archivo); 
	if (isset($archivo['idSede'])) {
		$alumnos = $modeloAlumno->mdlMostrarAlumnos($archivo['idSede']);
	}
	header("Content-Type: application/vnd.ms-excel; charset=iso-8859-1");
	header("Content-Disposition: attachment; filename=datos-subsanacion.xls");
 ?>
 <table border="1">
 	<tr>
 		<th>Nro</th>
 		<th>Sede</th>
 		<th>Carrera</th>
 		<th>Curso</th>
 		<th>Seccion</th>
 		<th>apellidos y nombres</th>
 		<th>DNI</th>
 		<th>Codigo</th>
 		<th>Boleta</th>
 		<th>Monto</th>
 		<th>Estado</th>
 		<th>fecha</th>
 	</tr>
 	<?php foreach ($alumnos as $key => $value): 
 		$estado = '';
 	?>
	 	<tr>
	 		<td><?php echo ($key+1); ?></td>
	 		<td><?php echo utf8_decode($value['nombreSede']); ?></td>
	 		<td><?php echo utf8_decode($value['nombreCarrera']); ?></td>
	 		<td><?php echo utf8_decode($value['nombreCurso']); ?></td>
	 		<td><?php echo utf8_decode($value['nombreSeccion']); ?></td>
	 		<td><?php echo utf8_decode($value['datos']); ?></td>
	 		<td style="mso-number-format:'@';"><?php echo $value['dniPersona']; ?></td>
	 		<td><?php echo $value['codigo']; ?></td>
	 		<td style="mso-number-format:'@';"><?php echo $value['codigoPago']; ?></td>
	 		<td><?php echo 'S/. '.$value['monto']; ?></td>
	 		<?php 
	 			if ($value['estadoSubsanacion'] == 1) {
	 				$estado = 'PENDIENTE';
	 			}else if($value['estadoSubsanacion'] == 2){
	 				$estado = 'APROBADO';
	 			}else if($value['estadoSubsanacion'] == 3){
	 				$estado = 'DESAPROBADO';
	 			}
	 		 ?>
	 		 <td><?php echo $estado; ?></td>
	 		 <td><?php echo $value['fechaSubsanacion']; ?></td>
	 	</tr>
 	<?php endforeach ?>
 </table>