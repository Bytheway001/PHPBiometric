<?php 
$sqlSource = file_get_contents('../config/db_schema.sql');
try{
	print_r($mysqli->multi_query($sqlSource));
}
catch(Exception $e){
	die($e->getMessage());
}

















 ?>