
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?= $title ?></title>
	<link rel="icon" href="/assets/img/misc/imago.ico">
	<link rel="stylesheet" type="text/css" href="/assets/css/application.css">
	<script type="text/javascript" src='/assets/js/main.js'></script>
	<script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<script type="text/javascript" src="/assets/bscalendar/js/language/es-MX.js"></script>
	<script type="text/javascript" src='/assets/bscalendar/js/calendar.js'></script>
	<script type="text/javascript" src='/assets/js/digitalpersona.js'></script>
	<script type="text/javascript" src='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.6/js/fileinput.min.js'></script>
	<script type="text/javascript" src='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.6/js/plugins/piexif.min.js'></script>
</head>
<body>
	<?php 
	if(App\Models\User::is_authenticated()){
		include('../app/views/partials/navbar.php');
		echo $navbar;
	}
	?>
	<?php $msg = new \Plasticbrain\FlashMessages\FlashMessages(); ?>
	<?php $msg->display(); ?>
	<?= $str ?>
	
	<script type="text/javascript" src="/assets/bscalendar/js/language/es-MX.js"></script>
	
</body>
</html>

