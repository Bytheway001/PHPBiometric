<?php 
use App\Models\Employee; 
use App\Models\User;

?>
<script type="text/javascript">
	function set_link(val){
		$('#verification_link').prop('href','finspot:FingerspotVer;'+val)
	}
</script>
<div class="container" style='padding-top:100px'>
	<div class="row">
		<form method='post' action="<users/authenticate">
			<div class="col-sm-4 col-sm-offset-4">
				<div class="panel">
					<div class="panel-body">
						<div class="row text-center">
							<img src="/assets/img/logo.png" style='width:120px;height:120px'>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<p class="text-center" style='color:white'><?= TEXT['user_login'] ?></p>
								<div class="form-group">
									<label for=""><?= TEXT['employee'] ?>:</label>
									<select class="selectpicker form-control input-sm" data-live-search="true" data-dropupAuto='false' onchange='set_link($(this).val())'>
										<option><?= TEXT['select'] ?></option>
										<?php foreach(Employee::all(['select'=>'id, nombres, apellidos']) as $employee): ?>
											<option value='<?= $employee->verification_link() ?>'><?= $employee->nombres.' '.$employee->apellidos ?></option>
										<?php endforeach; ?>
									</select>
								</div>
								<div class="col-sm-12">
									<div class="btn-group btn-group-justified">
										<a id='verification_link' href='' class='btn btn-primary'><i class="fa fa-hand-o-up"></i><?= TEXT['login'] ?></a>
										<?php if(!User::is_authenticated()): ?>
											<a href="/users/login" class='btn btn-success'><i class="fa fa-sign-in" aria-hidden="true"></i> Iniciar Sesion</a>
										<?php endif ?>
									</div>
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
