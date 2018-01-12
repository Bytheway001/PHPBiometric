<?php use Libs\Timemanager; ?>
<script src='https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/1.3.3/FileSaver.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/TableExport/4.0.11/js/tableexport.min.js'></script>
<script type="text/javascript" src='/assets/js/resume.js'></script>
<div class="container-fluid">
	<div class="row">
		<div class="col-xs-3 sidebar">
			<div class="image">
				<img src="/assets/webmasters.png">
			</div>
			
			<table class='table panel-table'>
				<tr><td>ID:</td><td><?= $employee->id; ?></td></tr>
				<tr><td><?= TEXT['names'] ?>:</td><td><?= $employee->nombres; ?></td></tr>
				<tr><td><?= TEXT['last_names'] ?>:</td><td><?= $employee->apellidos; ?></td></tr>
				<tr><td><?= TEXT['nationality'] ?>:</td><td><?= $employee->nacionalidad; ?></td></tr>
				<tr><td><?= TEXT['id_number'] ?>:</td><td><?= $employee->cedula; ?></td></tr>
				<tr><td><?= TEXT['admission'] ?>:</td><td><?= $employee->fecha_ingreso->format('d-m-Y'); ?></td></tr>
				<tr><td><?= TEXT['office'] ?>:</td><td><?= $employee->sede; ?></td></tr>
				<tr><td><?= TEXT['working_hours'] ?>:</td><td><?= $employee->hora_entrada.' - '.$employee->hora_salida; ?></td></tr>
					
			</table>
			<h5><?= TEXT['period'] ?>:</h5>
			<form action="/employees/resume/<?= $employee->id ?>" method='get'>
				<div class="form-group">
					<div class="input-group">
						<span class="input-group-addon input-sm"><?= TEXT['month'] ?></span>
						<select class='form-control input-sm' name='month'>
							<option <?= ($mes=='01'?'selected':'') ?> value="01">01</option>
							<option <?= ($mes=='02'?'selected':'') ?> value="02">02</option>
							<option <?= ($mes=='03'?'selected':'') ?> value="03">03</option>
							<option <?= ($mes=='04'?'selected':'') ?> value="04">04</option>
							<option <?= ($mes=='05'?'selected':'') ?> value="05">05</option>
							<option <?= ($mes=='06'?'selected':'') ?> value="06">06</option>
							<option <?= ($mes=='07'?'selected':'') ?> value="07">07</option>
							<option <?= ($mes=='08'?'selected':'') ?> value="08">08</option>
							<option <?= ($mes=='09'?'selected':'') ?> value="09">09</option>
							<option <?= ($mes=='10'?'selected':'') ?> value="10">10</option>
							<option <?= ($mes=='11'?'selected':'') ?> value="11">11</option>
							<option <?= ($mes=='12'?'selected':'') ?> value="12">12</option>
						</select>
						<spam class="input-group-addon input-sm"><?= TEXT['year'] ?></spam>
						<select class='form-control input-sm' name='year'>
							<?php for($i=$year-5;$i<=$year+5;$i++): ?>
								<option <?= ($i==$year?'selected':'') ?> value="<?= $i ?>"><?= $i ?></option>
							<?php endfor; ?>
						</select>
						<span class="input-group-btn">
							<button type='submit' class='btn btn-ok btn-sm'><?= TEXT['search'] ?></button>
						</span>
					</div>
				</div>
			</form>
		</div>
		<div class="col-sm-9 content">
			<div class="row">
				<h2 class='text-center'><?= TEXT['attendance_report'] ?></h2>
				<div class="col-sm-12">
					<table class='table table-data'>
						<tr>
							<td><?= TEXT['hours_hired'] ?>: <span class="pull-right" style='color:white'><?= Timemanager::seconds_to_hours($employee->horas_contratadas_mes($year,$mes)) ?></span></td>
							<td><?= TEXT['hours_worked'] ?>: <span class="pull-right" style='color:green'><?= Timemanager::seconds_to_hours($employee->horas_trabajadas_mes($year,$mes)) ?></span></td>
							<td><?= TEXT['absences'] ?>: <span class="pull-right" style='color:red'><?=$employee->inasistencias_mes($year,$mes) ?></span></td>
							<td><?= TEXT['delays'] ?>: <span class="pull-right" style='color:yellow'><?=$employee->retrasos_mes($year,$mes) ?></span></td>
							<td><?= TEXT['delay_hours'] ?>: <span class="pull-right" style='color:yellow'><?= Timemanager::seconds_to_hours($employee->tiempo_retraso_mes($year,$mes)) ?></span></td>
							<td><?= TEXT['extra_hours'] ?>: <span class="pull-right" style='color:green'><?= Timemanager::seconds_to_hours($employee->horas_extra_mes($year,$mes)) ?></span></td>
						</tr>
					</table>
				</div>
				<div class="col-sm-12">
					<div id="calendar">

					</div>
				</div>
				<div class="col-sm-12" style='margin-top:40px'>
					<div class="buttons">
						<button type="button" onclick='details(<?=$employee->id.',"'.$mes,'",'.$year ?>)' class='btn btn-ok'><?= TEXT['details'] ?></button>
						<a href='/api/invoice/pdf/<?=$employee->id ?>' target='_blank' class='btn btn-ok'><?= TEXT['payment_receipt'] ?></a>
						<a href='/users/dashboard' class='btn btn-ok'><?= TEXT['back'] ?></a>
					</div>
				</div>

			</div>
		</div>
	</div>


</div>

<div id='details' class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-body">
				...
			</div>
		</div>
	</div>
</div>