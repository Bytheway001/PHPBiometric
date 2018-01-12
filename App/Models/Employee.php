<?php 
declare(strict_types=1);
namespace App\Models;
use Libs\Timemanager;
class Employee extends \ActiveRecord\Model{

	/********************RELATIONS***********************/
	static $has_one=[['Finger']];
	static $has_many=[['Checkins'],['lastcheck','class_name'=>'Checkin','limit'=>1,'order'=>'id DESC'],['Bajas']];
	/********************VALDATIONS***********************/
	static $validates_format_of=[
		['nombres','with'=>'/^[A-z]+$/'],
		['apellidos','with'=>'/^[A-z]+$/']
	];
	static $validates_presence_of = [
		['nombres'],['apellidos'],['cedula'],['nacionalidad'],['sueldo_base'],['cargo'],['hora_entrada'],['hora_salida'],['fecha_ingreso']

	];


	/****************** LAS HORAS SE DEBEN DEVOLVER SIEMPRE EN SEGUNDOS *****************************/
// El link donde se verifica el empleado en el captahuellas
	public function verification_link():string{
		return 'finspot:FingerspotVer;'.base64_encode(VERIFICATION_PATH.$this->id);
	}
// EL link en donde se registra el empleado en el captahuellas
	public function registration_link():string{
		return 'finspot:FingerspotReg;'.base64_encode(REGISTRATION_PATH.$this->id);
	}
// Verifica si el empleado asistio ese dia
	public function asistio(int $y,int $m,int $d):bool{
		$date=$y.'-'.$m.'-'.$d;
		$a=Checkin::count(['conditions' => ['employee_id = ? AND fecha = ?',$this->id,$date]]);
		return $a>0;
	}
// Verifica si el empleado Estaba de permiso
	public function had_permission(int $y,int $m,int $d):bool{
		$date=$y.'-'.$m.'-'.$d;
		$baja=Baja::count(['conditions'=>['employee_id = ? and start <= ? and end >= ?',$this->id,$date,$date]]);
		return $baja>0;
	}
// Verifica si el empleado llego tarde
	public function late(int $y,int $m,int $d):bool{
		$c=Checkin::first(['order'=>'entrada ASC','conditions' =>['employee_id = ? AND fecha = ?',$this->id,$y.'-'.$m.'-'.$d]]);
		return strtotime($c->entrada)>strtotime($this->hora_entrada)+300;
	}
// Las horas que DEBERIA HABER TRABAJADO EN EL MES
	public function horas_contratadas_mes(int $y,int $m):int{
		$horas=0; 
		$lastday=Timemanager::dias_transcurridos($y,$m);
		for($d=1;$d<=$lastday;$d++){
			// Validamos que:
			// 1- Sea laborable
			// 2- No estaba de permiso
			// 3- No era feriado
			if(Timemanager::is_laborable($d,$m,$y) && !$this->had_permission($y,$m,$d) && !Timemanager::is_holiday($y,$m,$d)){
				$horas=$horas+$this->horas_contratadas_dia($y,$m,$d);
			}
		}
		return $horas;
	}
// Las horas que DEBERIA HABER TRABAJADO EN EL DIA
	public function horas_contratadas_dia(int $y,int $m,int $d):int{
		$contratadas=strtotime($this->hora_salida)-strtotime($this->hora_entrada);
		return $contratadas;
	}
// Las horas que TRABAJO EN EL MES (seconds)
	public function horas_trabajadas_mes(int $y,int $m):int{
		$horas=0; 
		$lastday=Timemanager::dias_transcurridos($y,$m);
		for($d=1;$d<=$lastday;$d++){
			// Validamos que:
			// 1- Sea laborable
			// 2- No estaba de permiso
			// 3- No era feriado
			// 4- Asistio
			if(Timemanager::is_laborable($d,$m,$y) && !$this->had_permission($y,$m,$d) && !Timemanager::is_holiday($y,$m,$d) && $this->asistio($y,$m,$d)){
				$horas=$horas+$this->horas_trabajadas_dia($y,$m,$d);
			}
		}
		return $horas;
	}
// Las horas que TRABAJO EN EL DIA (seconds)
	public function horas_trabajadas_dia(int $y,int $m,int $d):int{
		$hours=0;
		$date=$y.'-'.$m.'-'.$d;
		$checkins=Checkin::all(['conditions'=>['employee_id = ? AND DATE(fecha) = ?',$this->id,$date]]);
		foreach($checkins as $c){
			if($c->salida){
				$salida=strtotime($c->salida);
				$entrada=strtotime($c->entrada);
				if($salida-$entrada>0){
					$hours=$hours+$salida-$entrada;
				}
			}

		}
		return $hours;
	}
// Las veces que falto el MES
	public function inasistencias_mes(int $y,int $m):int{
		$faltas=0;
		$days_in_month=Timemanager::dias_transcurridos($y,$m);
		for($d=1;$d<$days_in_month;$d++){
			if(Timemanager::is_laborable($d,$m,$y) && !$this->had_permission($y,$m,$d) && !Timemanager::is_holiday($y,$m,$d) && !$this->asistio($y,$m,$d)){
				$faltas=$faltas+1;
			}
		}
		return $faltas;
	}
// El numero de veces que llego tarde
	public function retrasos_mes(int $y,int $m):int{
		$retrasos=0;
		$days_in_month = Timemanager::dias_transcurridos($y,$m);
		for($d=1;$d<$days_in_month;$d++){
			if(Timemanager::dias_transcurridos($y,$m,$d) && $this->asistio($y,$m,$d)){
				if($this->late($y,$m,$d)){
					$retrasos=$retrasos+1;
				}
			}
			
		}
		return $retrasos;
	}
// El tiempo total de retraso EN EL MES (en segundos)
	public function tiempo_retraso_mes(int $y,int $m):int{
		$horas=0;
		$days_in_month=Timemanager::dias_transcurridos($y,$m);
		for($d=1;$d<=$days_in_month;$d++){
			if(Timemanager::is_laborable($d,$m,$y) && !Timemanager::is_holiday($y,$m,$d) and $this->asistio($y,$m,$d)){
				$horas=$horas+$this->tiempo_retraso_dia($y,$m,$d);
			}
		}
		return $horas;
	}
// EL tiempo total de retraso EN EL DIA
	public function tiempo_retraso_dia(int $y,int $m,int $d):int{
		if($this->horas_trabajadas_dia($y,$m,$d)>$this->horas_contratadas_dia($y,$m,$d)){
			return 0;
		}
		$c=Checkin::first(['order'=>'entrada ASC','conditions' =>['employee_id = ? AND fecha = ?',$this->id,$y.'-'.$m.'-'.$d]]);
		$result=strtotime($c->entrada)-strtotime($this->hora_entrada);
		if($result>0){
			return $result;
		}
		else{
			return 0;
		}
	}
// El numero (en horas) de horas extra laboradas EN EL MES
	public function horas_extra_mes(int $y,int $m):int{
		$horas=0;
		$days_in_month=Timemanager::dias_transcurridos($y,$m);
		for($d=1;$d<$days_in_month;$d++){
			$horas=$horas+$this->horas_extra_dia($y,$m,$d);
		}
		return $horas;
	}
// El numero (en horas) de horas extra laboradas EN EL POR DIA
	public function horas_extra_dia(int $y,int $m,int $d):int{
		$trabajadas=$this->horas_trabajadas_dia($y,$m,$d);
		if(!Timemanager::is_laborable($d,$m,$y) || Timemanager::is_holiday($d,$m,$y)){
			$contratadas=0;
		}
		else{
			$contratadas=$this->horas_contratadas_dia($y,$m,$d);
		}
		if($trabajadas>$contratadas){
			return $trabajadas-$contratadas;
		}
		else{
			return 0;
		}
	}
// El numero (En BOB) de bonificacion referente a las horas extra
	public function bonus_horas_extra_mes(int $year,int $mes):int{
		$horas_extra=$this->horas_extra_mes($year,$mes)/3600;
		$bonus_modifier=2; 
		$bonus=$horas_extra*$bonus_modifier; 
		$horas_contratadas= strtotime($this->hora_salida)-strtotime($this->hora_entrada)/3600;
		$porhora=$this->sueldo_base/cal_days_in_month(0,(int)$mes,$year)/$horas_contratadas;
		$monto=$porhora*$bonus;
		return round($monto,2);
	}
// Nueva entrada/salida del empleado
	public function marcar(){
		if(count($this->lastcheck)==0){
			$this->create_lastcheck(['fecha'=>date('Y-m-d'),'entrada'=>date('H:i:s')]);
		}
		else{
			$checkin=$this->lastcheck[0];
			if($checkin->fecha->format('Y-m-d')!=date('Y-m-d')){
				$this->create_lastcheck(['fecha'=>date('Y-m-d'),'entrada'=>date('H:i:s')]);
			}
			else{
				if(!$checkin->salida){
					$checkin->salida=date('H:i:s');
					$checkin->save();
				}
				else{
					$this->create_lastcheck(['fecha'=>date('Y-m-d'),'entrada'=>date('H:i:s')]);
				}
			}
		}
	}
// Calcular el sueldo ganado en el mes
	public function get_day_types(int $y,int $m){
		$domingos=0;
		$feriados=0;
		$laborables=0;
		$laborados=0;
		$permisos=0;
		$inasistencias=0;
		$total_days=cal_days_in_month(0,$m,$y);
		if($y==date('Y') && $m==date('m')){
			$days=date('d');
		}
		else{
			$days=cal_days_in_month(0,$m,$y);
		}
		for($d=1;$d<=$days;$d++){
			if(Timemanager::is_holiday($y,$m,$d)){
				$feriados++;
			}
			elseif(!Timemanager::is_laborable($y,$m,$d)){
				$domingos++;
			}
			else{
				$laborables++;
			}
			if(Timemanager::is_laborable($y,$m,$d) && !Timemanager::is_holiday($y,$m,$d)){
				try {
					if(!$this->asistio($y,$m,$d)){
						if(Baja::count([
							'conditions'=>[
								'employee_id = ? and start => ? AND end <= ?',
								$this->id,
								$y.'-'.$m.'-'.$d,
								$y.'-'.$m.'-'.$d
							]
						])>0){
							$permisos++;
						}
						else{
							$inasistencias++;
						}
					}
					else{
						$laborados++;
					}
				} catch (Exception $e) {
					Baja::table()->last_sql;
				}

			}
		}
		return['transcurridos'=>$days,'total_days'=>$total_days,'domingos'=>$domingos,'feriados'=>$feriados,'laborados'=>$laborados,'laborables'=>$laborables,'permisos'=>$permisos,'inasistencias'=>$inasistencias];

	}
	public function calcular_pagos(int $y,int $m){
		$d=$this->get_day_types($y,$m);
		$diaria=$this->sueldo_base/$d['total_days'];
		$horaria=$diaria/($this->hora_salida-$this->hora_entrada);
		$r=round($this->tiempo_retraso_mes($y,$m)/3600,2);
		$retrasos=round($r*$horaria,2);
		$e=round($this->horas_extra_mes($y,$m)/3600,2);
		$extras=round($r*2*$horaria,2);
		$inasistencias= round($d['inasistencias']*$diaria,2);
		$abonos=($d['laborables']+$d['domingos']+$d['feriados'])*$diaria;
		$cargos=($d['inasistencias'])*$diaria+round($r*$horaria,2);
		$total=round($abonos-$cargos,2);
		
		return ['faltas'=>$inasistencias,'retrasos'=>$retrasos,'ganado'=>$total,'extras'=>$extras];	
	}


}

?>