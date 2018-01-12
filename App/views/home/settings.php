<?php 
$regions = array(
	'Africa' => DateTimeZone::AFRICA,
	'America' => DateTimeZone::AMERICA,
	'Antarctica' => DateTimeZone::ANTARCTICA,
	'Aisa' => DateTimeZone::ASIA,
	'Atlantic' => DateTimeZone::ATLANTIC,
	'Europe' => DateTimeZone::EUROPE,
	'Indian' => DateTimeZone::INDIAN,
	'Pacific' => DateTimeZone::PACIFIC
);
$timezones = array();
foreach ($regions as $name => $mask) {
	$zones = DateTimeZone::listIdentifiers($mask);
	foreach ($zones as $timezone) {
		// Lets sample the time there right now
		$time = new DateTime(null, new DateTimeZone($timezone));
		// Us dumb Americans can't handle millitary time
		$ampm = $time->format('H') > 12 ? ' ('. $time->format('g:i a'). ')' : '';
		// Remove region name and add a sample time
		$timezones[$name][$timezone] = substr($timezone, strlen($name) + 1) . ' - ' . $time->format('H:i') . $ampm;
	}
}
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/i18n/defaults-en.min.js"></script>

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
if (!file_exists('../config/settings.json')) {
	$alert='Por favor Llene el siguiente formulario para completar la instalación';
} else {
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
							<label for="">Idioma</label>
							<select class='form-control input-sm' name="company[locale]">
								<option style='background-color:black' value="en" <?= ($config->company->locale=="en"?"selected":'') ?>>English</option>
								<option style='background-color:black' value="es" <?= ($config->company->locale=="es"?"selected":'') ?>>Español</option>
							</select>
						</div>
						<div class="form-group">
							<label for="">Nombre de la empresa</label>
							<input type="text" class='form-control input-sm' name="company[name]" value='<?= $config->company->name ?>'>
						</div>
						<div class="form-group">
							<label for="">Codigo <small>(Numero de identificación tributaria)</small></label>
							<input type="text" class='form-control input-sm' name="company[nit]" value='<?= $config->company->nit ?>'>
						</div>
						<div class="form-group">
							<label for="">Dominio</label>
							<input type="" class='form-control input-sm' name="company[domain]" value='<?= $config->company->domain ?>'>
						</div>
						<div class="form-group">
							<label for="">Puerto</label>
							<input type="" class='form-control input-sm' name="company[port]" value='<?= $config->company->port ?>'>
						</div>
						<div class="form-group">
							<label for="">Zona Horaria</label>
							<select class='form-control input-sm selectpicker' data-live-search='true' name='company[timezone]'>
								<?php foreach ($timezones as $region => $list): ?>
									<optgroup label="<?= $region ?>">
										<?php foreach($list as $timezone => $name): ?>
											<option <?= ($timezone==$config->company->timezone ? "Selected":"")?> value="<?= $timezone ?>"><?= str_replace("_"," ",$name) ?></option>
										<?php endforeach; ?>
									</optgroup>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div class="col-sm-4">
						<h4>Credenciales de la BD </h4>
						<div class="form-group">
							<label for="">Host de la BD</label>
							<input type="" class='form-control input-sm' name="database[host]" value='<?= $config->database->host ?>'>
						</div>
						<div class="form-group">
							<label for="">Usuario</label>
							<input type="" class='form-control input-sm' name="database[user]" value='<?= $config->database->user ?>'> 
						</div>
						<div class="form-group">
							<label for="">Clave</label>
							<input type="" class='form-control input-sm' name="database[password]" value='<?= $config->database->password ?>'>
						</div>
						<div class="form-group">
							<label for="">prefijo</label>
							<input type="" class='form-control input-sm' name="database[preffix]" value='<?= $config->database->preffix ?>'>
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
