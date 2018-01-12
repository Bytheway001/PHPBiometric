<?php 
use \Libs\Timemanager;
$year=(isset($_GET['year'])? $_GET['year'] : date('y'));
$mes=(isset($_GET['month'])? $_GET['month'] : date('m')); 
$start_date=$year.'-'.$mes.'-'.'01';
$end_date=$year.'-'.$mes.'-'.'31';
$ev=[];
$employee=\Employee::find(4);
$checkins=Checkin::all(['conditions'=>['employee_id = ? and MONTH(fecha) = ? AND YEAR(fecha) = ?',$employee->id,$mes,$year]]);
foreach($checkins as $i=>$checkin){
	$entrada_ts=strtotime($checkin->fecha->format('Y-m-d').' '.$checkin->entrada)*1000;
	$salida_ts=strtotime($checkin->fecha->format('Y-m-d').' '.$checkin->salida)*1000;
	if($checkin->employee->late($year,$mes,$checkin->fecha->format('d'))){
		$eclass='event-special';
		$etitle=" Entrada (retraso)";
	}
	else{
		$eclass='event-success';
		$etitle='Entrada';
	}
	$ev[]=['id'=>$checkin->id,'title'=>$checkin->entrada.' - '.$etitle,'class'=>$eclass,'start'=>$entrada_ts,'end'=>$entrada_ts];
	if($checkin->salida){
		$ev[]=['id'=>$checkin->id,'title'=>$checkin->salida.' - Salida','class'=>'event-warning','start'=>$salida_ts,'end'=>$salida_ts];
	}
}

for($day=1;$day<cal_days_in_month(0,$mes,$year);$day++){
	if(Timemanager::is_holiday($year,$mes,$day)){
		$motivo=Feriado::find_by_start($year.'-'.$mes.'-'.$day)->motivo;
		$start=strtotime($year.'-'.$mes.'-'.$day.' 00:00:00')*1000;
		$end=strtotime($year.'-'.$mes.'-'.$day.' 12:59:59')*1000;
		$ev[]=['id'=>$day,'title'=>$motivo,'class'=>'event-inverse','start'=>$start,'end'=>$end,'x'=>$day];
	}
	else if(!Timemanager::is_laborable($year,$mes,$day)){
		$motivo='sunday';
		$start=strtotime($year.'-'.$mes.'-'.$day.' 00:00:00')*1000;
		$end=strtotime($year.'-'.$mes.'-'.$day.' 12:59:59')*1000;
		$ev[]=['id'=>$day,'title'=>$motivo,'class'=>'event-inverse','start'=>$start,'end'=>$end,'x'=>$day];
	}

}
foreach($employee->bajas as $baja){
	$start=strtotime($baja->date->format('Y-m-d H:i:s'))*1000;
	$end=strtotime($baja->date->format('Y-m-d').' 23:59:59')*1000;
	$ev[]=['id'=>$day,'title'=>'Permiso ('.$baja->motivo.')','class'=>'event-default','start'=>$start,'end'=>$end];
}
//$events[]=['id'=>$checkin->id,'title'=>'Entrada','class'=>'event-success','start'=>1502524800000,'end'=>1502539200000];
$events=json_encode($ev);
//events_source: [{"id": 293,"title": "Event 1","url": "http://example.com","class": "event-important","start": 1502524800000, 'end':1502539200000}]


?>