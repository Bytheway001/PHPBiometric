<?php 
namespace App\Controllers;
use Core\View;
use \Feriado as Feriado;
use \Employee as Employee;
use \Baja as Baja;
class feriadosController extends Controller{
	public function create(){
		View::set('title','Crear Feriado');
		View::render('/feriados/new');
	}

	public function json(){
		$feriados=Feriado::all();
		foreach($feriados as $f){
			switch($f->tipo){
				case "NACIONAL":
				$tipo='red';
				break;

				case "ESTADAL":
				$tipo='blue';
				break;

				case "EMPRESA";
				$tipo='yellow';
				break;

				default:
				$tipo='green';
				break;
			}
			$json[]=['id'=>$f->id,'name'=>$f->motivo,'startDate'=>$f->start->format('Y,m,d'),'endDate'=>$f->end->format('Y,m,d'),'color'=>$tipo];
		}

		foreach(Employee::all(['select'=>'id,nombres, fecha_ingreso']) as $e){
			$year=date('Y');
			$ingreso=$e->fecha_ingreso->format('m,d');
			$aniversario=$year.','.$ingreso;
			$years_passed=$year-$e->fecha_ingreso->format('Y');
			if($years_passed>0){
				$json[]=[
					'id'=>$f->id,
					'name'=>$e->nombres.', '.$years_passed.' Años de servicio'
					,'startDate'=>$aniversario
					,'endDate'=>$aniversario
					,'color'=>'purple'
				];

			}
		}

		foreach(\Baja::all() as $b){
			$json[]=[
				'id'=>$b->id,
				'name'=>$b->employee->nombres.', '.$b->motivo
				,'startDate'=>$aniversario
				,'endDate'=>$aniversario
				,'color'=>'red'
			];

		}
		header('Content-type:application/json');
		echo json_encode($json);
	}

	public function add(){
		if($_POST['tipo']=="PERMISO"){
			$employee=Employee::find($_POST['employee_id']);
			$baja=$employee->create_baja(['start'=>$_POST['start'],'end'=>$_POST['end'],'motivo'=>$_POST['motivo']]);
			$feriado=['id'=>$baja->id,'name'=>$employee->nombres.', '.$baja->motivo,'startDate'=>$baja->start->format('Y,m,d'),'endDate'=>$baja->end->format('Y,m,d'),'color'=>'green'];
		}
		else{
			$f=Feriado::create($_POST);
			switch($f->tipo){
				case "NACIONAL":
				$tipo='red';
				break;

				case "ESTADAL":
				$tipo='blue';
				break;

				case "EMPRESA";
				$tipo='yellow';
				break;

				default:
				$tipo='green';
				break;
			}
			$feriado=['id'=>$f->id,'name'=>$f->motivo,'startDate'=>$f->start->format('Y,m,d'),'endDate'=>$f->end->format('Y,m,d'),'color'=>$tipo];
		}


		header('Content-type:application/json');
		echo json_encode($feriado);
		
	}

	public function delete($id){
		
	}

}

?>

