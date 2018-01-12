<style type="text/css">
.table-bordered th,td{
	padding:5px!important;
	line-height: 100%!important;
	vertical-align: middle!important;
}
</style>
<div class="container" style='margin-top: 50px'>
	<div class="row">
		<div class="panel panel-login" style='font-size:0.8em'>
			<div class="panel-heading">
				<div class="col-xs-6">
					<h3><?= TEXT['monthly_payment_report'] ?></h3>
				</div>
				<div class="col-xs-6">
					<form action="/users/nomina" method='get'>
						<div class="form-group">
							<label><?= TEXT['period'] ?></label>
							<div class="input-group">
								<span class="input-group-addon input-sm"><?= TEXT['month'] ?></span>
								<select class='form-control input-sm' name='month'>
									<option style="background-color:black" <?= ($month=='01'?'selected':'') ?> value="01">01</option>
									<option style="background-color:black" <?= ($month=='02'?'selected':'') ?> value="02">02</option>
									<option style="background-color:black" <?= ($month=='03'?'selected':'') ?> value="03">03</option>
									<option style="background-color:black" <?= ($month=='04'?'selected':'') ?> value="04">04</option>
									<option style="background-color:black" <?= ($month=='05'?'selected':'') ?> value="05">05</option>
									<option style="background-color:black" <?= ($month=='06'?'selected':'') ?> value="06">06</option>
									<option style="background-color:black" <?= ($month=='07'?'selected':'') ?> value="07">07</option>
									<option style="background-color:black" <?= ($month=='08'?'selected':'') ?> value="08">08</option>
									<option style="background-color:black" <?= ($month=='09'?'selected':'') ?> value="09">09</option>
									<option style="background-color:black" <?= ($month=='10'?'selected':'') ?> value="10">10</option>
									<option style="background-color:black" <?= ($month=='11'?'selected':'') ?> value="11">11</option>
									<option style="background-color:black" <?= ($month=='12'?'selected':'') ?> value="12">12</option>
								</select>
								<spam class="input-group-addon input-sm"><?= TEXT['year'] ?></spam>
								<select class='form-control input-sm' name='year'>
									<?php for($i=$year-5;$i<=$year+5;$i++): ?>
										<option style="background-color:black" <?= ($i==$year?'selected':'') ?> value="<?= $i ?>"><?= $i ?></option>
									<?php endfor; ?>
								</select>
								<span class="input-group-btn">
									<button type='submit' class='btn btn-ok btn-sm'><?= TEXT['search'] ?></button>
								</span>
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class="panel-body">
				<table class="table table-bordered">
					<tr>
						<th>ID</th>
						<th><?= TEXT['names'] ?></th>
						<th><?= TEXT['id_number'] ?></th>
						<th><?= TEXT['salary'] ?></th>
						<th><?= TEXT['position'] ?></th>
						<th><?= TEXT['absences'] ?></th>
						<th><?= TEXT['delays'] ?></th>
						<th><?= TEXT['earned'] ?></th>
						<th><?= TEXT['extra_hours'] ?></th>
						<th><?= TEXT['total'] ?></th>
						<th><?= TEXT['show'] ?></th>
					</tr>
					<?php foreach(\Employee::all() as $employee): ?>
						<?php $payment_data=$employee->calcular_pagos($year,$month) ?>
						<tr>
							<td><?= $employee->id ?></td>
							<td><?= $employee->nombres.' '.$employee->apellidos ?></td>
							<td><?= $employee->cedula ?></td>
							<td><?= $employee->sueldo_base ?></td>
							<td><?= $employee->cargo ?></td>
							<td><?= $payment_data['faltas'] ?></td>
							<td><?= $payment_data['retrasos'] ?></td>
							<td><?= $payment_data['ganado'] ?></td>
							<td><?= $payment_data['extras'] ?></td>
							<td><?= $payment_data['ganado']+$payment_data['extras'] ?></td>
							<td><a href="/employees/resume/<?= $employee->id ?>?month=<?=$month?>&year=<?=$year?>" class='btn btn-xs btn-primary'><?= Fa::lg('eye') ?></a></td>
						</tr>
					<?php endforeach; ?>
				</table>
			</div>
		</div>
	</div>
</div>

<div class="mask text-center">
	<h1 class="process_status"></h1>
	<img class='verifying' src="/assets/img/finger.gif" style='vertical-align: middle;width:200px;height:200px'>
</div>

<style type="text/css">
.mask{
	width:100%;
	height:100%;
	position:fixed;
	top:0px;
	left:0px;
	z-index:10000;
	background-color:black;
	display:none;
	align-items: center;
	justify-content: center;
}
</style>