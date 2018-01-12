<script type="text/javascript">

</script>
<div class="container" style='margin-top: 50px'>
	<div class="row">
		<div class="panel panel-login">
			<div class="panel-heading"><?= TEXT['payroll'] ?></div>
			<div class="panel-body">
				<table class="table table-bordered">
					<tr><th>ID</th><th><?= TEXT['names'] ?></th><th><?= TEXT['admission'] ?></th><th><?= TEXT['salary'] ?></th><th><?= TEXT['id_number'] ?></th><th><?= TEXT['actions'] ?></th></tr>
					<?php foreach(App\Models\Employee::all() as $employee): ?>
						<tr>
							<td><?= ($employee->asistio(date('Y'),date('m'), date('d')) ? App\Libs\Fa::lg('check" style="color:green"') :App\Libs\Fa::lg('times" style="color:red"')) ?></td>
							<td><?= $employee->nombres.' '.$employee->apellidos ?></td>
							<td><?= $employee->fecha_ingreso->format('d-m-Y') ?></td>
							<td><?= $employee->sueldo_base ?></td>
							<td><?= $employee->cedula ?></td>
							<td>
								<a href="/employees/edit/<?= $employee->id ?>" class='btn btn-ok btn-xs'><?= App\Libs\Fa::lg('pencil') ?> <?= TEXT['edit'] ?></a>
								<a href="/employees/resume/<?= $employee->id ?>" class='btn btn-success btn-xs'><?= App\Libs\Fa::lg('eye') ?> <?= TEXT['show'] ?></a>
								<?php if($employee->finger): ?>
									<a href='<?= $employee->verification_link() ?>' onclick='verification_start()' class='btn btn-xs btn-primary'><?= App\Libs\Fa::lg('hand-o-up') ?> <?= TEXT['verify'] ?></a>
									<a href="/employees/unreg/<?= $employee->id ?>" class='btn btn-danger btn-xs'><?= App\Libs\Fa::lg('close') ?></i><?= TEXT['delete_f'] ?></a>
								<?php else: ?>
									<a href='#' class='btn btn-xs btn-primary' onclick="user_register('<?= $employee->id ?>','<?= $employee->nombres ?>')"><i class="fa fa-hand-o-up" aria-hidden="true"></i><?= TEXT['register'] ?></a>
								<?php endif; ?>
							</td>
							<td style='display:none' id='user_finger_<?= $employee->id ?>'><?= ($employee->finger?1:0) ?></td>
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