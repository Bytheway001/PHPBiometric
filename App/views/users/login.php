<div class="container" style='padding-top:150px'>
	<div class="row">
		<form method='post' action="/users/authenticate">
			<div class="col-sm-5 col-sm-offset-4">
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="col-xs-2">
							<img src="/assets/img/logo.png" style='height:238px'>
						</div>
						<div class="col-xs-9 col-xs-offset-1">
							<h4 class="text-center"><?= TEXT['admin'] ?></h4>
							<div class="form-group">
								<label for=""><?= TEXT['user_name'] ?>:</label>
								<input type="text" name='usuario' class='form-control' >
							</div>
							<div class="form-group">
								<label for=""><?= TEXT['password'] ?>:</label>
								<input type="password" class='form-control' name='clave'>
							</div>
							<div class="col-sm-12 text-center btn-group">
								<button type='submit'  class='btn btn-danger'><?= TEXT['login'] ?></button>
								<a href='/' class='btn btn-info'><?= TEXT['back'] ?></a>
							</div>
						</div>

					</div>
				</div>
			</div>
		</form>
	</div>
