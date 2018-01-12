<?php 
namespace App\Controllers;
use Core\View;
class employeesController extends Controller{
	public function login(){
		View::set('title','login');
		View::render('employees/login');
	}

	public function edit($id){
		try{
			$employee=\Employee::find($id);
			View::set('employee',\Employee::find($id));
			View::set('title','Modificar Empleado');
			View::render('employees/edit');
		}
		catch(\ActiveRecord\RecordNotFound $e){
			$this->msg->error('No existe un empleado con este ID','/users/dashboard');
		}
	}

	public function update($id){
		try{
			$employee=\Employee::find($id);
			if($employee->update_attributes($_POST['Employee'])){
				$this->msg->success('Información Actualizada con Éxito','/users/dashboard');
			}
			else{
				$this->msg->error('No se pudo actualizar la información','/users/dashboard');
			}
		}
		catch(\ActiveRecord\RecordNotFound $e){
			$this->msg->error('No existe un empleado con este ID','/users/dashboard');
		}
	}

	public function resume($id){
		try{
			$employee=\Employee::find($id);
			View::set('employee',\Employee::find($id));
			View::set('mes',$this->month);
			View::set('year',$this->year);
			View::set('title','Modificar Empleado');
			View::render('employees/resume');
		}
		catch(\ActiveRecord\RecordNotFound $e){
			$this->msg->error('No existe un empleado con este ID','/users/dashboard');
		}
	}
	// Aqui llegamos cuando el usuario va a loguear
	// El ejecutable envia una peticion aqui ANTES DE VALIDAR, para solicitar el AC y la data de la huella de usuario
	public function request_validation($id){
		$user=\Employee::find($id);
		$verification_url=DOMAIN.'/employees/process_validation';
		$activation_code_url=DOMAIN.'/devices/getac';
		// El tiempo limite para la verificación
		$time_limit=20; 
		$finger=$user->finger;
		echo $user->id.";".$user->finger->finger_data.";SecurityKey;".$time_limit.";".$verification_url.";".$activation_code_url.';extraparams';
	}
	// El ejecutable envia una peicion aqui DESPUES de validar
	public function process_validation(){
		if (isset($_POST['VerPas']) && !empty($_POST['VerPas'])) {
			$data=explode(";",$_POST['VerPas']);
			$employee_id= $data[0]; 
			$vStamp=$data[1];
			$time= $data[2];
			$sn=$data[3];
			try{
				$employee=\Employee::find($employee_id);
				$device=\Device::find($sn);
				$salt = md5($sn.$employee->finger->finger_data.$device->vc.$time.$employee_id.$device->vkey);
				if (strtoupper($vStamp) == strtoupper($salt)) {
					$employee->marcar();
					$myfile = fopen("../app/api/logged.txt", "w");
					$txt = "logged In";
					fwrite($myfile, $txt);
					fclose($myfile);
				}
				else{
					echo DOMAIN.'/employees/showmsg2';
				}
			}
			catch(Exception $e){
				die($e->getMessage());
			}
		}
		else{
			$msg = "Parameter invalid..";
			echo DOMAIN."/messages.php?msg=$msg";
		}	
	}

	// El ejecutable envia una peticion aqui Al finalizar el registro
	public function process_registration(){
		if (isset($_POST['RegTemp']) && !empty($_POST['RegTemp'])) {
			$data 		= explode(";",$_POST['RegTemp']);
			
			$vStamp 	= $data[0];
			$sn 		= $data[1];
			$user_id	= $data[2];
			$regTemp 	= $data[3];
			$device=\Device::find_by_sn($sn);
			$salt = md5($device->ac.$device->vkey.$regTemp.$sn.$user_id); 
			if (strtoupper($vStamp) == strtoupper($salt)) {
				$result1=\Finger::all(['select'=>'MAX(finger_id) as fid','conditions'=>['employee_id = ?',$user_id]]);
				$fid=$result1[0]->fid;
				if ($fid == 0) {
					$finger=new \Finger(['employee_id'=>$user_id,'finger_id'=>$fid+1,'finger_data'=>$regTemp]);
					$result2= $finger->save();
					if($result1 && $result2){
						$res['result'] = true;
					}
					else{
						$res['server'] = "Error Al registrar!";
					}
				} 
				else {
					$res['result'] = false;
					$res['user_finger_'.$user_id] = "Template already exist.";
				}

				echo "empty";

			} else {
				$msg = "Parameter invalid..";
				echo $msg;
			}
		}
		else{
			echo 'invalid request';
		}
	}
	// Peticion hecha via ajax;
	public function check_registration($id){
		$ct=\Finger::count(['conditions'=>['employee_id = ?',$id]]);
		if (intval($ct) > intval($_POST['current'])) {
			$res['result'] = true;			
			$res['current'] = intval($ct);			
		}
		else
		{
			$res['result'] = false;
		}
		echo json_encode($res);
	}

	public function could_log(){
		if(file_exists('../app/api/logged.txt')){
			unlink('../app/api/logged.txt');
			echo true;
		}
		else{
			echo false;
		}
		
	}

}


?>