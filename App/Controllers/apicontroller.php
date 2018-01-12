<?php 
namespace App\Controllers;

use mikehaertl\wkhtmlto\Pdf;
use \Employee;
use \Checkin;
use \Feriado;
use \Libs\Timemanager;

class Api extends Controller
{
    public function details($id)
    {
        include('../app/api/details.php');
    }

    public function invoice($id)
    {
        if (!isset($_GET['year'])) {
            $_GET['year']=$this->year;
        }
        if (!isset($_GET['month'])) {
            $_GET['month']=$this->month;
        }
        include('../app/api/invoice.php');
    }

    public function invoicePDF($id)
    {
        if (!isset($_GET['year'])) {
            $_GET['year']=$this->year;
        }
        if (!isset($_GET['month'])) {
            $_GET['month']=$this->month;
        }
        try {
            $employee=\Employee::find($id);
            if (file_exists('../app/files/invoices/'.$employee->cedula.'/'.$_GET['month'].'-'.$_GET['year'].'.pdf')) {
                $created_date=date('m', filemtime('../app/files/invoices/'.$employee->cedula.'/'.$_GET['month'].'-'.$_GET['year'].'.pdf'));
            } else {
                $created_date=date('m');
            }
            // el mes fecha en la que fue creado
            
            if ($created_date==date('m')) {
                if (!is_dir('../app/files/invoices/'.$employee->cedula)) {
                    mkdir('../app/files/invoices/'.$employee->cedula, 0777, true);
                }
                if (file_exists('../app/files/invoices/'.$employee->cedula.'/'.$_GET['month'].'-'.$_GET['year'].'.pdf')) {
                    header('Content-type: application/pdf');
                    readfile('../app/files/invoices/'.$employee->cedula.'/'.$_GET['month'].'-'.$_GET['year'].'.pdf');
                } else {
                    $pdf = new Pdf('http://www.irene.com/api/invoice/'.$employee->id);
                    $pdf->setOptions([
                        'binary' => 'c:/Program Files/wkhtmltopdf/bin/wkhtmltopdf.exe',
                        'commandOptions' => ['useExec' => true],
                    ]);

                    if (!$pdf->saveAs('../app/files/invoices/'.$employee->cedula.'/'.$_GET['month'].'-'.$_GET['year'].'.pdf')) {
                        echo $pdf->getError();
                    } else {
                        $pdf->send();
                    }
                }
            }
        } catch (Exception $e) {
        }
    }

    public function events($id)
    {
        header('Content-type:application/json');
        $y=$this->year;
        $m=$this->month;
        $employee=Employee::find($id);
    
        $checkins=Checkin::all(['conditions'=>['employee_id = ? AND MONTH(fecha) = ? and YEAR(fecha) = ?',$id,$m,$y]]);
        foreach ($checkins as $c) {
            $entrada=strtotime($c->fecha->format('Y-m-d').' '.$c->entrada)*1000;
            $salida=strtotime($c->fecha->format('Y-m-d').' '.$c->salida)*1000;
            if ($c->employee->late($y, $m, $c->fecha->format('d'))) {
                $event_class='event-special';
                $event_title=" Entrada (retraso)";
            } else {
                $event_class='event-success';
                $event_title='Entrada';
            }
            $ev[]=['id'=>$c->id,'title'=>$c->entrada.' - '.$event_title,'class'=>$event_class,'start'=>$entrada,'end'=>$entrada];
            if ($c->salida) {
                $ev[]=['id'=>$c->id,'title'=>$c->salida.' - Salida','class'=>'event-warning','start'=>$salida,'end'=>$salida];
            }
        }
        for ($day=1;$day<cal_days_in_month(0, $m, $y);$day++) {
            if (Timemanager::is_holiday($y, $m, $day)) {
                $motivo=Feriado::find_by_start($y.'-'.$m.'-'.$day)->motivo;
                $start=strtotime($y.'-'.$m.'-'.$day.' 00:00:00');
                $end=strtotime($y.'-'.$m.'-'.$day.' 12:59:59');
                $ev[]=['id'=>$day,'title'=>$motivo,'class'=>'event-inverse','start'=>$start,'end'=>$end];
            } elseif (!Timemanager::is_laborable($y, $m, $day)) {
                $motivo='sunday';
                $start=strtotime($y.'-'.$m.'-'.$day.' 00:00:00')*1000;
                $end=strtotime($y.'-'.$m.'-'.$day.' 12:59:59')*1000;
                $ev[]=['id'=>$day,'title'=>$motivo,'class'=>'event-inverse','start'=>$start,'end'=>$end,'x'=>$day];
            }
        }
        foreach ($employee->bajas as $baja) {
            $start=strtotime($baja->start->format('Y-m-d H:i:s'))*1000;
            $end=strtotime($baja->end->format('Y-m-d').' 23:59:59')*1000;
            $ev[]=['id'=>$day,'title'=>'Permiso ('.$baja->motivo.')','class'=>'event-default','start'=>$start,'end'=>$end];
        }
        $response['success']=1;
        $response['result']=$ev;
        echo json_encode($response);
    }

    public function test()
    {
        throw new \Exception("Mielda Loco");
    }
}
