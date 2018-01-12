<?php use Libs\Timemanager; ?>
		<div class="container-fluid">
			<div class="row">
				<nav class="col-sm-4 col-md-3 d-none d-sm-block sidebar">
					<div class="image">
						<img src="/assets/webmasters.png">
					</div>
					<table class='table panel-table'>
						<tr><td>Nº De empleado:</td><td><?= $employee->id; ?></td></tr>
						<tr><td>Nombres:</td><td><?= $employee->nombres; ?></td></tr>
						<tr><td>Apellidos:</td><td><?= $employee->apellidos; ?></td></tr>
						<tr><td>Nacionalidad:</td><td><?= $employee->nacionalidad; ?></td></tr>
						<tr><td>C.I:</td><td><?= $employee->cedula; ?></td></tr>
						<tr><td>Cargo:</td><td><?= $employee->cargo; ?></td></tr>   
						<tr><td>Ingreso:</td><td><?= $employee->fecha_ingreso->format('d-m-Y'); ?></td></tr>
						<tr><td>Sede:</td><td><?= $employee->sede; ?></td></tr>
						<tr><td>Horario:</td><td><?= $employee->hora_entrada.' - '.$employee->hora_salida; ?></td></tr>
					</table>

				</nav>

				<main role="main" class="col-sm-8 ml-sm-auto col-md-9 pt-3">
					<h1 class='text-gold'>Reporte de Asistencia</h1>
										<table class='table table-data'>
						<tr>
							<td>Horas Contratadas: <span class="pull-right" style='color:white'><?= Timemanager::seconds_to_hours($employee->horas_contratadas_mes($year,$mes)) ?></span></td>
							<td>Horas Trabajadas: <span class="pull-right" style='color:green'><?= Timemanager::seconds_to_hours($employee->horas_trabajadas_mes($year,$mes)) ?></span></td>
							<td>Inasistencias: <span class="pull-right" style='color:red'><?=$employee->inasistencias_mes($year,$mes) ?></span></td>
							<td>Retrasos: <span class="pull-right" style='color:yellow'><?=$employee->retrasos_mes($year,$mes) ?></span></td>
							<td>Horas de Retraso: <span class="pull-right" style='color:yellow'><?= Timemanager::seconds_to_hours($employee->tiempo_retraso_mes($year,$mes)) ?></span></td>
							<td>Horas Extra: <span class="pull-right" style='color:green'><?= Timemanager::seconds_to_hours($employee->horas_extra_mes($year,$mes)) ?></span></td>
						</tr>
					</table>
				</main>



		</div>
