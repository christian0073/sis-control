<?php 
	$url= $_SERVER["REQUEST_URI"];
	$components = parse_url($url);
	if (!isset($components['query'])) {
		echo "<h1>Valores no validos</h1>";
		return;		
	}
	parse_str($components['query'], $archivo); 
	$nombreArchivo = 'archivo';
	if (isset($archivo['idSede'])) {
		$modeloAlumno = new ModeloAlumno();
		$alumnos = $modeloAlumno->mdlMostrarAlumnos($archivo['idSede']);
		$nombreArchivo = 'archivo-subsanacion';
	}else if (isset($archivo['idParcial']) && !empty($archivo['idParcial'])) {
		$modeloListaExamenes = new ModeloCursoAula();
		$fecha = '';
		if (isset($archivo['fecha']) && !empty($archivo['fecha'])) {
			if (!validarFecha($archivo['fecha'])) {
				echo "<h1>Valores no validos</h1>";
				return;		
			}
			$fecha = $archivo['fecha'];
		}
		$nombreArchivo = 'archivo-examenes';
		$lista = $modeloListaExamenes->mdlMostrarListaExamenes($archivo['idParcial'], $fecha);
	}else{
		echo "<h1>Valores no validos</h1>";
		return;
	}

	header("Content-Type: application/vnd.ms-excel; charset=iso-8859-1");
	header("Content-Disposition: attachment; filename=".$nombreArchivo.".xls");
 ?>
 <?php if (isset($archivo['idSede'])): ?>
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
 <?php endif ?>
<?php if (isset($archivo['idParcial'])): ?>
	<table>
	    <tr>
	      <th>N°</th>
	      <th>Sede</th>
	      <th>Apellidos y Nombres</th>
	      <th>DNI</th>
	      <th>Celulares</th>
	      <th>Curso</th>
	      <th><?php echo utf8_decode("Sección"); ?></th>
	      <th>Estado</th>
	      <th>Fecha</th>
    </tr>
    <?php foreach ($lista as $key => $value): 
		$fecha = '';
    	if ($value['estado'] == 'ENTREGADO') {
			$fecha = $value['fechaExamen'];	
    	}
		$celularPersonal = '';
		$celulares = '';
		if ($value['celularPersonal'] != '[]' ) {
			$celularPersonal = json_decode($value['celularPersonal'], true);
			for ($i=0; $i < count($celularPersonal) ; $i++) { 
				$celulares .= $celularPersonal[$i].', ';
			}
			$celulares = substr($celulares, 0, -2);		
		}
	?>
    	<tr>
    		<td><?php echo ($key+1); ?></td>
    		<td><?php echo utf8_decode($value['sede']); ?></td>
    		<td><?php echo utf8_decode($value['docente']); ?></td>
    		<td style="mso-number-format:'@';"><?php echo $value['dniPersona']; ?></td>
    		<td style="mso-number-format:'@';"><?php echo $celulares; ?></td>
    		<td><?php echo utf8_decode($value['nombreCurso']); ?></td>
    		<td><?php echo utf8_decode($value['nombreSeccion']); ?></td>
    		<td><?php echo utf8_decode($value['estado']); ?></td>
    		<td><?php echo $fecha; ?></td>
    	</tr>
    <?php endforeach ?>
	</table>
<?php endif ?>