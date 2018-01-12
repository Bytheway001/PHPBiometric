<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;
//phpunit --bootstrap ../autoload.php ../../Test/Models/userTest.php 
use App\Models\Employee;
ActiveRecord\Config::initialize(function ($cfg) {
	$cfg->set_connections(array(
		'development' => 'mysql://root:Silvereye1990@localhost/biometric;charset=utf8'));
});

class testEmployee extends TestCase{
	private $employee;

	public function setUp(){
		$this->emlpoyee=Employee::find(5);
	}
	/**
	* @dataProvider all_dates
	*/
	public function testforHoras($y,$m,$d){
		$employee=Employee::find(5);
		$this->assertInternalType("int",$employee->horas_trabajadas_dia($y,$m,$d));
		$this->assertInternalType("int",$employee->horas_contratadas_dia($y,$m,$d));
		$this->assertInternalType("bool",$employee->asistio($y,$m,$d));
		$this->assertInternalType("bool",$employee->had_permission($y,$m,$d));
	}

	public function all_dates(){
		$arr=[];
		for($m=1;$m<=12;$m++){
			for($d=1;$d<=cal_days_in_month(CAL_GREGORIAN, $m, 2017);$d++){
				$arr[]=[2017,$m,$d];
			}
		}
		return $arr;
	}



	
}




?>