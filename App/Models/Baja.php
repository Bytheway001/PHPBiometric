<?php 
namespace App\Models;
class Baja extends \ActiveRecord\Model{
	private $fecha;
	static $belongs_to=[['Employee']];
}

 ?>