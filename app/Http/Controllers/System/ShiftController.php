<?php
/**
 * Created by IntelliJ IDEA.
 * User: letua
 * Date: 3/7/2020
 * Time: 12:50 AM
 */

namespace App\Http\Controllers\System;
use App\Http\Controllers\Controller;
use App\Lib\MyUtils;
use App\Model\BookingTurn;
use App\Model\ScheduleTask;
use App\Model\ServicesVendor;
use App\Model\ShiftModel;
use Illuminate\Http\Request;

use App\Model\UserAdmin;


class ShiftController  extends Controller
{
    protected $staffServices;
    protected $staffId ;
    protected $Staff;
    protected $VendorId = 1;
    protected $bookingTurn;
    protected $CurrentSchedule;
    protected $requestData;
    protected $ShiftModel;


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
        $this->ShiftModel = new ShiftModel();

    }


    function addShiftForEmployee(Request $request){
         $info = $request->all();
         $timestamp_start = $info['date'];
         $timestamp_end = $timestamp_start + 60*60*$info['duration'];
        $date_start1 = date('yy-m-d', $timestamp_start);
        $time_start1 = date('H:i:s', $timestamp_start);

        $date_end1 = date('yy-m-d', $timestamp_end);
        $time_end1 = date('H:i:s', $timestamp_end);

        $dupShift = $this->ShiftModel->returnDupShift($date_start1,$time_start1,$time_end1,$this->VendorId,$info['employeeId']);
        $return = [];

        if(sizeof($dupShift) > 0){
         $return['code'] = 1;
         return $return;

        }
        else{
            $this->ShiftModel->addShift($date_start1,$time_start1,$time_end1,$this->VendorId,$info['employeeId']);
            $return['code'] = 0;
            return $return;
        }
    }

    function listShiftForEmployee(Request $request)
    {
        $employeeId = $request->employeeId;
        $listShift = $this->ShiftModel->listShiftForEmployee($this->VendorId,$employeeId);
        for($i = 0 ;$i< sizeof($listShift);$i++){

            $booking = $this->ShiftModel->getBoookingForShift($this->VendorId,$listShift[$i]['services_ids']);
            $listShift[$i]['count']['booking'] = sizeof($booking);
        }

        return $listShift;

    }

    function listShiftDetail(Request $request)
    {
        $detail = $request->all();
        dd($detail);
        exit();

    }





}
