<?php 

$parser=new Parser('Device');
$data=$parser->dump();
//print_r($data);
//die();
?>
<style type="text/css">
	.table{
		font-size: 0.8em;
	}
	.return_type{
		color:purple;
	}
	.Public{
		color:blue;
	}
	.Private{
		color:red;
	}
	.Static{
		color:green;
	}

	.int{
		font-style: italic;
		color:green;
	}
	.bool{
		font-style: italic;
		color:blue;
	}
</style>

<div class="container-fluid">
	<h1 class="text-center"><?= $parser->name ?></h1>
	<div class="row">
		<div class="col-sm-12">	
			<div class="panel panel-login">	
				<table class="table table-bordered">
					<tr><th>Inherits From</th></tr>
					<tr><td><a href="/test?class_name=<?= $parser->parent ?>"><?= $parser->parent ?>	</a></td></tr>
				</table>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
		<div class="panel panel-login">
			<table class="table table-bordered">
				<tr><th>Type</th><th>Name</th><th>Parameters</th><th>Returns</th></tr>
			<?php foreach($data as $method): ?>
				<tr>
					<td class='<?= $method['type'] ?>'><?= $method['type'] ?> </td>
					<td><?=$method['name'] ?></td>
					<td>
						<?php foreach($method['parameters'] as $parameter): ?>
							<span class='<?=$parameter['type'] ?>'><?= $parameter['type'] ?> </span><?=$parameter['name'] ?>, 
						<?php endforeach; ?>
					</td>
					<td><?= $method['returns'] ?></td>
				</tr>
			<?php endforeach; ?>
			</table>
		</div>
		</div>
	</div>
</div>
