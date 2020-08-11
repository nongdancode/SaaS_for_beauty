<?php


namespace App\Http\Controllers\System\ScheduleFunction;


use App\Lib\MyUtils;
use App\Model\ConfigVendorModel;
use App\Model\Vendor;

class OpenHours
{

    protected $vendorId = 1;
    function __construct(){
        $this->util = new MyUtils();
        $this->ConfigModel = new ConfigVendorModel();
        $this->Vendor = new Vendor();
    }
    function validateOpenHours($start_time,$end_time){
        $Openhour = $this->ConfigModel->getOpenhours($this->vendorId);
        $flag = true;
        $Openhour2 = json_decode($Openhour[0]['content'],true);
        $dayinweek = date("D",$start_time);
        $TimeStart =  date("H:i:s",$start_time) ;
        $TimeEnd =  date("H:i:s",$end_time);
        $TimeStartInSecond = strtotime("1970-01-01 $TimeStart UTC");
        $TimeEndInSecond = strtotime("1970-01-01 $TimeEnd UTC");

        foreach ($Openhour2 as $day=>$hour){
            $hourFrom =  $hour['from'];
            $hourTo =  $hour['to'];
            $FromInSecond = $seconds = strtotime("1970-01-01 $hourFrom UTC");
            $ToInSecond = $seconds = strtotime("1970-01-01 $hourTo UTC");

            if($day == $dayinweek ){
               if($TimeStartInSecond< $FromInSecond || $TimeEndInSecond> $ToInSecond){
                   $flag = false;
               }
            }

        }
        return $flag;








//        return strtotime($Openhour2['Mon']['from']);
    }
}
