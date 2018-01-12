<?php 
ob_start();
extract($_GET);
use \Libs\Timemanager as Time;
$employee=\Employee::find($id);
$domingos=0;
$feriados=0;
$laborables=0;
$laborados=0;
$permisos=0;
$inasistencias=0;
$retraso=round($employee->tiempo_retraso_mes($year,$month)/3600,1);
$extra=round($employee->horas_extra_mes($year,$month)/3600,1);
$days=cal_days_in_month(0,$_GET['month'],$_GET['year']);
for($d=1;$d<=$days;$d++){
	// caso 1 Es feriado
	if(Time::is_holiday($year,$month,$d)){
		$feriados++;
	}
	// caso 2 Es domingo
	elseif(!Time::is_laborable($year,$month,$d)){
		$domingos++;
	}
	// caso 3 Es laborable
	else{
		$laborables++;
	}
	// Asistio ?	
	if(Time::is_laborable($year,$month,$d) && !Time::is_holiday($year,$month,$d)){
		if(!$employee->asistio($year,$month,$d)){
			if(Baja::count(['conditions'=>['employee_id = ? and start < ? and end > ?',$employee->id,$year.'-'.$month.'-'.$d,$year.'-'.$month.'-'.$d]])>0){
				$permisos++;
			}
			else{
				$inasistencias++;
			}
		}
		else{
			$laborados++;
		}
		// si asistio
	}
}
$diaria=round($employee->sueldo_base/$days,2);
$horaria=$diaria/($employee->hora_salida-$employee->hora_entrada);

$checkins=Checkin::all(['conditions'=>['employee_id = ? AND MONTH(fecha) = ? and YEAR(fecha) = ?',$id,$_GET['month'],$_GET['year']]]);
?>
<style type="text/css">
	.table-rows{
		font-family: arial;
		font-size:0.8em;
		background:none;
		color:black;
		width:100%;
		border-collapse:collapse;
	}
	.table-rows tr th,.table-rows tr td{
		padding:3px !important;
		border:black 1px solid;


	}
	.modal-content{
		background-color:white 
	}
	.modal-title{
		color:black;
	}
	h5,h3,h4,h5{
		color:black;
	}
	p{
		color:black;
	}
	.text-left{
		text-align:left;
	}
	.text-right{
		text-align:right;
	}
	.thead{
		background-color:grey;
	}
</style>
<h2 style='text-align:center'><?= TEXT['payment_receipt'] ?></h2>
<p style="text-align:right"><?= COMPANY_NAME ?></p>
<p style="text-align:right"><?= COMPANY_ID ?></p>
<h3><?= TEXT['employee'] ?></h3>

<table class="table table-rows">
	<tr><th class='text-left'><?= TEXT['names'] ?>:</th><td class='text-left'><?= $employee->nombres.' '.$employee->apellidos ?></td></tr>
	<tr><th class='text-left'><?= TEXT['period'] ?></th><td class='text-left'><?=\Libs\Timemanager::$meses['ES'][$_GET['month']].'/'.$_GET['year'] ?></td></tr>
	<tr><th class='text-left'><?= TEXT['salary'] ?></th><td class='text-left'>Bs. <?= $employee->sueldo_base ?></td></tr>
	<tr><th class='text-left'><?= TEXT['working_days'] ?></th><td class='text-left'><?= $laborables ?></td></tr>
	<tr><th class='text-left'><?= TEXT['daily_payment'] ?></th><td><?= $diaria ?></td></tr>
</table>
<h3><?= TEXT['payment_details'] ?></h3>
<table class="table table-rows">
	<tr class='thead'><th><?= TEXT['item'] ?></th><th><?= TEXT['amount'] ?></th><th><?= TEXT['value'] ?></th><th><?= TEXT['debit'] ?></th><th><?= TEXT['credit'] ?></th></tr>
	<tr>
		<th class='text-left'><?= TEXT['working_days'] ?></th>
		<td ><?= $laborables ?></td>
		<td><?= $diaria ?></td>
		<td><?= $laborables*$diaria ?>
		</td><td>0</td>
	</tr>
	<tr>
		<th class='text-left'><?= TEXT['sundays'] ?></th>
		<td><?= $domingos ?></td>
		<td><?= $diaria ?></td>
		<td><?= $domingos*$diaria ?></td>
		<td>0</td>
	</tr>
	<tr>
		<th class='text-left'><?= TEXT['holidays'] ?></th>
		<td><?= $feriados ?></td>
		<td><?= $diaria ?></td>
		<td><?= $feriados*$diaria ?></td>
		<td>0</td>
	</tr>
	<tr>
		<th class='text-left'><?= TEXT['extra_hours'] ?></th>
		<td><?= $extra ?></td>
		<td><?= round($horaria*2,2) ?></td>
		<td><?= round($extra*$horaria,2)*2 ?></td>
		<td>0</td>
	</tr>
	<tr>
		<th class='text-left'><?= TEXT['absences'] ?></th>
		<td><?= $inasistencias ?></td>
		<td><?= $diaria ?></td>
		<td>0</td>
		<td><?= $inasistencias*$diaria ?></td>
	</tr>
	<tr>
		<th class='text-left'><?= TEXT['delays'] ?></th>
		<td><?= $retraso ?></td>
		<td><?= round($horaria,2) ?></td>
		<td>0</td>
		<td><?= round($retraso*$horaria,2) ?></td>
		
	</tr>
	<tr>
		<th colspan='3'><?= TEXT['total_credits'] ?></th>
		<td><?= $abonos=($laborables+$domingos+$feriados)*$diaria+(round($extra*$horaria,2)*2) ?></td>
		<td>0</td>
	</tr>
	<tr>
		<th colspan='3'><?= TEXT['total_debits'] ?></th>
		<td>0</td>	
		<td><?= $cargos=($inasistencias)*$diaria+round($retraso*$horaria,2) ?></td>
	</tr>
</table>
<div style='display:inline'>
	<h4 class='text-right'><?= TEXT['total'] ?>: <?= $abonos-$cargos ?></h4>
	<p style='float:left'><?= TEXT['admin_signature'] ?>: _____________________</p>
	<p style='float:right'><?= TEXT['employee_signature'] ?>: _____________________</p>
	<br>
	<br>
	<p style='text-align:center'><?= TEXT['date_of_emission'] ?>: <?= date('d/m/Y - H:i:s') ?></p>
</div>

<?php 
$html=ob_get_clean();
echo $html;
?>
