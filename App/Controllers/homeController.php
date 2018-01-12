<?php 
namespace App\Controllers;
use Core\View;
use App\Models\User;
class homeController extends Controller{
	public function index(){
		if(User::is_authenticated()){
			header('location:/users/dashboard');
		}
		else{
			header('location:/employees/login');
		}
	}

	public function settings(){
		$config=json_decode(file_get_contents('../config/settings.json'));
		View::set('config',$config);
		View::set('title','ajustes');
		View::render('home/settings');
	}

	public function set(){
		try{
			$mysqli=new \mysqli($_POST['database']['host'],$_POST['database']['user'],$_POST['database']['password'], $_POST['database']['preffix'].'biometric');
		}
		
		catch (\Exception $e) {
			$this->msg->error('Las credenciales de la base de datos no son validas, por favor verifique con el administrador de la misma','/settings');
		}
		// Codigo para subir la imagen
		$upload_dir='assets/img/';
		$extension = pathinfo($_FILES['logo']['name'],PATHINFO_EXTENSION);
		$upload_file=$upload_dir.'logo.'.$extension;
		if(!move_uploaded_file($_FILES["logo"]["tmp_name"],$upload_file)){
			
		}

		$config=json_encode($_POST);
		$config_file=fopen('../config/settings.json','w');
		fwrite($config_file, $config);
		fclose($config_file);
		$this->msg->success('configuracion guardada con éxito!','/settings');
	}

	public function install(){
		View::set('title','Instalación');
		View::render('home/settings');
	}

	public function test(){
		View::set('title','Class Parser');
		View::render('home/test');
	}
}

?>