<script type="text/javascript">

</script>
<div class="container" style='margin-top: 50px'>
	<div class="row">
		<div class="panel panel-login">
			<div class="panel-heading"><?= TEXT['devices'] ?></div>
			<div class="panel-body">
				<a href='/devices/new' class='btn btn-primary'><?= TEXT['add_device'] ?></a>
				<table class="table table-bordered">
					<tr><th><?= TEXT['name'] ?></th><th>SN</th><th>VC</th><th>AC</th><th>Vkey</th></tr>
					<?php foreach($devices as $device): ?>
						<tr>
						<td><?= $device->device_name ?></td>
						<td><?= $device->sn ?></td>
						<td><?= $device->vc ?></td>
						<td><?= $device->ac ?></td>
						<td><?= $device->vkey ?></td>
						<td><a href="/devices/<?=$device->id ?>/delete"><?= TEXT['delete'] ?></a></td>
						</tr>
					<?php endforeach ?>
				</table>
			</div>
		</div>
	</div>
</div>
