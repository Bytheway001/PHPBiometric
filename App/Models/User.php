<?php 
namespace App\Models;
class User extends \ActiveRecord\Model{
	static function is_authenticated(){
		return (isset($_SESSION['id']) and $_SESSION['autentica']=="SI");
	}

	static function authenticate($user,$pass){
		if(isset($_SESSION['id'])){
			unset($_SESSION['id']);
		}
		$usuario=static::find(array('conditions'=>array("usuario='".$user."' and clave='".$pass."'")));
		if(!$usuario){
			return false;
		}

		else{
			$_SESSION['id']=$usuario->id;
			$_SESSION['usuario']=$usuario->usuario;
			$_SESSION['autentica']=true;
			$_SESSION['date']=date('d-m-Y h:i:s', strtotime("+30 minutes"));
			$_SESSION['type']='User';
			return true;
		}
	}

	static function deauthenticate(){
		unset($_SESSION['id']);
		unset($_SESSION['usuario']);
		unset($_SESSION['autentica']);
		unset($_SESSION['date']);
		unset($_SESSION['type']);
		return true;
	}
}

?>