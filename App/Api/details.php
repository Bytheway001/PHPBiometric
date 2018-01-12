<?php 
ob_start();
$employee=Employee::find($id);
$checkins=Checkin::all(['conditions'=>['employee_id = ? AND MONTH(fecha) = ? and YEAR(fecha) = ?',$id,$_GET['month'],$_GET['year']]]);
?>

<table class='table exportable' >
	<tr><th colspan='3'>DETALLE DE ASISTENCIA</th></tr>
	<tr>
		<th style='text-transform: uppercase'>Nombre: <?= $employee->nombres.' '.$employee->apellidos ?></th>
		<th>Periodo:</th>
		<th><?=\Libs\Timemanager::$meses['ES'][$_GET['month']].'/'.$_GET['year'] ?></th>
	</tr>
	<tr><th>FECHA</th><th>Entrada</th><th>Salida</th></tr>
	<?php foreach($checkins as $checkin): ?>
		<tr>
			<td><?= $checkin->fecha->format('d/m/Y') ?></td>
			<td><?= $checkin->entrada ?></td>
			<td><?= $checkin->salida ?></td>
		</tr>
	<?php endforeach; ?>
</table>
<?php 
$html=ob_get_clean();
echo $html;
 ?>
