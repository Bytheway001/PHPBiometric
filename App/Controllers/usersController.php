<?php 
namespace App\Controllers;
use Core\View;
use App\Models\User;
use App\Models\Employee;
class usersController extends Controller{
	public function login(){
		View::set('title',"Ingreso de Usuario");
		View::render('users/login');
	}

	public function authenticate(){
		if(User::authenticate($_POST['usuario'],$_POST['clave'])){
			$this->msg->success('Bienvenido '.$_SESSION['usuario'],'/users/dashboard');
		}
		else{
			$this->msg->error('Credenciales Inválidas', '/users/login'); 
		}
	}

	public function deauthenticate(){
		if(User::deauthenticate()){
			$this->msg->success('Se ha cerrado la Sesión','/employees/login');
		}
	}

	public function dashboard(){
		View::set('title',"Página Principal");
		View::render('users/dashboard');
	}

	public function nomina(){
		View::set('month',$this->month);
		View::set('year',$this->year);
		View::set('title',"Página Principal");
		View::render('users/nomina');
	}


}

 ?>