<?php 
namespace App\Controllers;
use Core\View;
use \Device;
class devicesController extends Controller{
	public function new(){
		View::set('title','Nuevo Dispositivo');
		View::render('devices/new');
	}
	public function create(){
		$device=new Device($_POST);
		$device->save();
		$this->msg->success('Dispositivo Creado con éxito','/devices');
	}
	public function edit($id){}
	public function update($id){}
	public function delete($id){
		$device=Device::find($id);
		$device->delete();
		$this->msg->success('Dispositivo eliminado exitosamenteP','/devices');

	}
	public function index(){
		$devices=Device::all();
		View::set('title',"Devices");
		View::set('devices',$devices);
		View::render('devices/index');
	}
}

 ?>