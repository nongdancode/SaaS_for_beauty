<?php
/**
 * Created by IntelliJ IDEA.
 * User: letua
 * Date: 2/20/2020
 * Time: 7:36 AM
 */

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Lib\MyUtils;
use App\Model\BookingTurn;
use App\Model\ScheduleTask;
use App\Model\ServicesVendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Input;
use App\Model\UserAdmin;

class ScheduleTaskController extends Controller
{

    protected $staffServices;
    protected $staffId ;
    protected $Staff;
    protected $VendorId = 1;
    protected $bookingTurn;
    protected $CurrentSchedule;
    protected $requestData;


    function __construct(Request $request)
    {
        $this->bookingTurn = new BookingTurn();
        $this->ServicesTurn = new UserAdmin();
        $this->util = new MyUtils();
        $this->Staff = new UserAdmin();
        $this->staffServices = new ServicesVendor();
        $this->CurrentSchedule= new ScheduleTask();
        $this->staffId = $request->staffid;
        $this->requestData = $request->all();


    }

    function getStafffForSchdedule(){
        $data = $this->Staff->getStaffByVendor($this->VendorId);
        return $data;
    }


   function getServicesOfStaffForScheduling(){
     $services = $this->staffServices->getservicesByStaff($this->VendorId,$this->staffId);
     $services2['data'] = $services;

     $services2['code']=1;
       return   $services2;
   }

   function getScheduleForStaff(){
    $bookingData = $this->CurrentSchedule->getScheduleForStaff($this->staffId,$this->VendorId);
//    $bookingData2 = $this->util->decodeObjectStdJson($bookingData);
//    $bookingData2[0]['sadasd'] = 'test';
    $bookingDataReturn = [];



    for($i = 0; $i< sizeof($bookingData);$i++){


       $bookingDataReturn['data'][$i]= [
           'start' => $bookingData[$i]['start'],
           'end' => $bookingData[$i]['end'],
           'type' => $bookingData[$i]['status'],
           'task'=>[
               'id'=> $bookingData[$i]['id'],
               'name'=>$bookingData[$i]['name'],
               'stepping'=>$bookingData[$i]['stepping'],
               'img'=>$bookingData[$i]['img']


           ]

       ];
    }
    $bookingDataReturnp['code'] = 1;
    return $bookingDataReturn;



   }

   function editSchedule(){
        $dataUpdateSchedule = $this->requestData;

        $staffId = $this->staffId;
        for($i=0;$i< sizeof($dataUpdateSchedule); $i++){
            $start_time = $dataUpdateSchedule[$i]['start'];
            $end_time = $dataUpdateSchedule[$i]['end'];
            $date_start1 = date('yy-m-d',$start_time);
            $time_start1 = date('H:i:s',$start_time);

            $date_end1 = date('yy-m-d',$end_time);
            $time_end1 = date('H:i:s',$end_time);



            dd( $time_start1);
            exit();
        }

      return response($dataUpdateSchedule);
   }

}
