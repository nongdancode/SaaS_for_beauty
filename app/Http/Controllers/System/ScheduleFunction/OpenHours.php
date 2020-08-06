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
        $Openhour2 = json_decode($Openhour,true);


        return $Openhour2;
    }
}
