<?php 
if(count($_POST)>0){
	try{
		$mysqli=new \mysqli($_POST['bd_host'],$_POST['bd_user'],$_POST['bd_pass'], $_POST['bd_prefix'].'biometric');
	}

	catch (\Exception $e) {
		die('Las credenciales de la base de datos no son validas, por favor verifique con el administrador de la misma');
	}
	$upload_dir='assets/img/';
	$extension = pathinfo($_FILES['company_logo']['name'],PATHINFO_EXTENSION);
	$upload_file=$upload_dir.'company_logo.'.$extension;
	move_uploaded_file($_FILES["company_logo"]["tmp_name"],$upload_file);
	$config=json_encode($_POST);
	$config_file=fopen('../config/settings.json','w');
	fwrite($config_file, $config);
	fclose($config_file);
	$config=json_decode(file_get_contents('../config/settings.json'));
	require('../install/db_setup.php');
	//header('location:/');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>BIOMETRIC - Instalación</title>
	<link rel="stylesheet" type="text/css" href="/assets/css/application.css">
	<script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

	<script type="text/javascript" src='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.6/js/fileinput.min.js'></script>
	<script type="text/javascript" src='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.6/js/plugins/piexif.min.js'></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/i18n/defaults-en.min.js"></script>
</head>
<body>
	<script type="text/javascript">
		$(document).ready(function(){
			$("#input-id").fileinput({
				showCaption:false,
				showUpload:false,
				showClose:false,

			});
		})
	</script>
	<?php 
	if(!file_exists('../config/settings.json')){
		$alert='Por favor Llene el siguiente formulario para completar la instalación';
	}
	else{
		$alert='Nota: Se recomienda no modificar esta sección si no se tiene conocimiento';
	}

	?>
	<div style='border-radius:0px' class="alert dismissable alert-warning"><button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span class='fa fa-times'></span>
	</button><?= $alert ?></div>
	<div class="container">
			<form method="post" action='/settings/set' enctype='multipart/form-data'>
		<h1 class="text-center">AJUSTES</h1>
		<div class="row">
			<div class="panel panel-login">
				<div class="panel-body">
					<div class="col-sm-4">
						<h4>Configuración de la Empresa</h4>
						<div class="form-group">
							<label for="">Nombre de la empresa</label>
							<input type="text" class='form-control input-sm' name="company[name]">
						</div>
						<div class="form-group">
							<label for="">Codigo <small>(Numero de identificación tributaria)</small></label>
							<input type="text" class='form-control input-sm' name="company[nit]">
						</div>
						<div class="form-group">
							<label for="">Dominio</label>
							<input type="" class='form-control input-sm' name="company[domain]">
						</div>
						<div class="form-group">
							<label for="">Puerto</label>
							<input type="" class='form-control input-sm' name="company[port]">
						</div>
						<div class="form-group">
							<label for="">Zona Horaria</label>
							<select class='form-control input-sm selectpicker' data-live-search='true' name='company[timezone]'>
								<?php foreach(timezone_abbreviations_list() as $abbr => $timezone): ?>
									<?php foreach($timezone as $val): ?>
										<?php if(isset($val['timezone_id'])): ?>
											<option value='<?= $val['timezone_id'] ?>'><?= $val['timezone_id'] ?></option>
										<?php endif ?>
									<?php endforeach ?>
								<?php endforeach ?>
							</select>
						</div>
					</div>
					<div class="col-sm-4">
						<h4>Credenciales de la BD </h4>
						<div class="form-group">
							<label for="">Host de la BD</label>
							<input type="" class='form-control input-sm' name="database[host]">
						</div>
						<div class="form-group">
							<label for="">Usuario</label>
							<input type="" class='form-control input-sm' name="database[user]"> 
						</div>
						<div class="form-group">
							<label for="">Clave</label>
							<input type="" class='form-control input-sm' name="database[password]">
						</div>
						<div class="form-group">
							<label for="">prefijo</label>
							<input type="" class='form-control input-sm' name="database[preffix]">
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<h4>Logotipo <small>(200x200px jpg,png,gif)</small></h4>
							<input type="file" id="input-id" name='logo'>
						</div>
					</div>
				</div>
				<div class="panel-footer">
					<button type='submit' class='btn btn-success'>Guardar Cambios</button>
				</div>
					

			</div>
		</div>
	</form>
	</div>

	
</body>
</html>

