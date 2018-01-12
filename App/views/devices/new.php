<div class="container">
	<div class="row">
		<h1 class="text-center"><?= TEXT['new_device'] ?></h1>
		<div class="col-sm-4 col-sm-offset-4">
			<form method='post' action='/devices'>
				<div class="form-group">
					<label for="device_name"><?= TEXT['name'] ?></label>
					<input class='form-control input-sm' type="text" name="device_name">
				</div>
				<div class="form-group">
					<label for="device_name">SN</label>
					<input class='form-control input-sm' type="text" name="sn">
				</div>
				<div class="form-group">
					<label for="device_name">VC</label>
					<input class='form-control input-sm' type="text" name="vc">
				</div>
				<div class="form-group">
					<label for="device_name">AC</label>
					<input class='form-control input-sm' type="text" name="ac">
				</div>
				<div class="form-group">
					<label for="device_name">Vkey</label>
					<input class='form-control input-sm' type="text" name="vkey">
				</div>
				<div class="form-group">

					<button class='btn btn-ok'><?= TEXT['save'] ?></button>
				</div>
			</form>
		</div>
	</div>
</div>