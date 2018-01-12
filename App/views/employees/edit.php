<div class="container">
	<div class="row">
		<h1 class="text-center">Modificar Empleado</h1>
	</div>
	<div class="row">
		<div class="panel panel-primary">
			<div class="panel-heading">Datos del Empleado</div>
			<div class="panel-body">
				<form action="/employees/update/<?=$employee->id ?>" method='post'>
					<div class="col-sm-4">
						<fieldset>
							<legend>Datos Personales</legend>
							<div class="form-group">
								<label for='Nombres'><?= TEXT['names'] ?>:</label>
								<div class="input-group">
									<div class="input-group-addon input-sm"><i class='fa fa-user-circle'></i></div>
									<input type="text" name="Employee[nombres]" value="<?= $employee->nombres ?>" class='form-control input-sm'>
								</div>
							</div>
							<div class="form-group">
								<label for='Apellidos'><?= TEXT['last_names'] ?>:</label>
								<div class="input-group">
									<div class="input-group-addon input-sm"><i class='fa fa-user-circle'></i></div>
									<input type="text" name="Employee[apellidos]" value="<?= $employee->apellidos ?>" class='form-control input-sm'>
								</div>
							</div>
							<div class="form-group">
								<label for='cedula'><?= TEXT['id_number'] ?></label>
								<div class="input-group">
									<div class="input-group-addon input-sm"><i class="fa fa-id-card-o"></i></div>
									<input type="text" name="Employee[cedula]" value="<?= $employee->cedula ?>" class='form-control input-sm'>
								</div>
							</div>
							<div class="form-group">
								<label for='nacionalidad'><?= TEXT['nationality'] ?></label>
								<div class="input-group">
									<div class="input-group-addon input-sm"><i class="fa fa-globe"></i></div>
									<input type="text" name="Employee[nacionalidad]" value="<?= $employee->nacionalidad ?>" class='form-control input-sm'>
								</div>
							</div>
						</fieldset>
					</div>
					<div class="col-sm-4">
						<fieldset>
							<legend>Datos Laborales</legend>
							<div class="form-group">
								<label for="sueldo_base"><?= TEXT['salary'] ?></label>
								<div class="input-group">
									<div class="input-group-addon input-sm"><i class="fa fa-usd"></i></div>
									<input type="text" name="Employee[sueldo_base]" value="<?= $employee->sueldo_base ?>" class='form-control input-sm'>
								</div>
							</div>
							<div class="form-group">
								<label for="cargo"><?= TEXT['position'] ?></label>
								<div class="input-group">
									<div class="input-group-addon input-sm"><i class="fa fa-briefcase" aria-hidden="true"></i></div>
									<input type="text" name="Employee[cargo]" value="<?= $employee->cargo ?>" class='form-control input-sm'>
								</div>
							</div>
							<div class="form-group">
								<label for="fecha_ingreso"><?= TEXT['admission'] ?></label>
								<div class="input-group">
									<div class="input-group-addon input-sm"><i class="fa fa-calendar-plus-o"></i></div>
									<input type="text" name="Employee[fecha_ingreso]" value="<?= $employee->fecha_ingreso->format('d-m-Y') ?>" class='form-control input-sm datepicker' readonly>
								</div>
							</div>
							<div class="form-group">
								<label for="hora_entrada"><?= TEXT['working_hours'] ?></label>
								<div class="input-group">

									<i class="input-group-addon input-sm"><?= TEXT['in'] ?></i>
									<input type="text" name="Employee[hora_entrada]" value="<?= $employee->hora_entrada ?>" class='form-control input-sm timepicker'>
									<i class="input-group-addon input-sm"><?= TEXT['out'] ?></i>
									<input type="text" name="Employee[hora_salida]" value="<?= $employee->hora_salida ?>" class='form-control input-sm timepicker'>
								</div>
							</div>
						</fieldset>
					</div>
					<div class="col-sm-4">
						<fieldset>
							<legend>Otros</legend>
							<div class="form-group">
								<label for="sede"><?= TEXT['office'] ?>:</label>
								<div class="input-group">
									<div class="input-group-addon input-sm"><i class="fa fa-briefcase" aria-hidden="true"></i></div>
									<select name='Employee[sede]' class='form-control input-sm'>
										<option value='OFICINA'>OFICINA</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="comment"><?= TEXT['comments'] ?></label>
								<textarea name="Employee[comment]" id="" cols="30" rows="4" class='form-control'></textarea>
							</div>
							<div class="form-group btn-group">
								<button class='btn btn-primary'><?= TEXT['save'] ?> <i class="fa fa-arrow-right"></i> </button>
								<a href='<?= $_SERVER['HTTP_REFERER']?>' class='btn btn-danger'><?= TEXT['back'] ?></a>
							</div>
						</fieldset>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
