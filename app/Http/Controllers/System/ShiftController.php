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
use DateTimeZone;
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

        date_default_timezone_set('America/Chicago');

    }


    function addShiftForEmployee(Request $request){
         $info = $request->all();
         $timestamp_start = $info['date'];

         $timestamp_end = $timestamp_start + 60*60*$info['duration'];
        $date_start1 = date('yy-m-d', $timestamp_start);;
        $time_start1 = date('H:i:s', $timestamp_start);

        $date_end1 = date('yy-m-d', $timestamp_end);
        $time_end1 = date('H:i:s', $timestamp_end);

        $dupShift = $this->ShiftModel->returnDupShift($date_start1,$time_start1,$time_end1,$this->VendorId,$info['employeeId']);
        $return = [];

        if(sizeof($dupShift) > 0){
            $return['dup'] = $dupShift;
            $return['start'] =  $date_start1;
            $return['end_end'] = $date_end1;
            $return['start2'] =   $timestamp_start;
            $return['start3'] =   $time_start1;
            $return['end_time1'] =   $time_end1;
            $return['end_time2'] =   $timestamp_end;
         $return['code'] = 1;
            $return['dup'] = $dupShift;
         return $return;

        }
        if($date_start1 != $date_end1){
            $return['code'] = 1;
            $return['dup'] = $dupShift;
            $return['start'] =  $date_start1;
            $return['end_end'] = $date_end1;
            $return['start2'] =   $timestamp_start;
            $return['start3'] =   $time_start1;
            $return['end_time1'] =   $time_end1;
            $return['end_time2'] =   $timestamp_end;

            return $return;
        }
        else{
            $this->ShiftModel->addShift($date_start1,$time_start1,$time_end1,$this->VendorId,$info['employeeId']);

            $return['dup'] = $dupShift;
            $return['start'] =  $date_start1;
            $return['end_end'] = $date_end1;
            $return['start2'] =   $timestamp_start;
            $return['start3'] =   $time_start1;
            $return['end_time1'] =   $time_end1;
            $return['end_time2'] =   $timestamp_end;
            $return['code'] = 0;

            return $return;
        }
    }

    function listShiftForEmployee(Request $request)
    {
        $employeeId = $request->employeeId;
        $listShift = $this->ShiftModel->listShiftForEmployee($this->VendorId,$employeeId);

//        dd($listShift);
//        exit();
        for($i = 0 ;$i< sizeof($listShift);$i++){
            $serviceInfo = $this->staffServices->getservicesByStaff($this->VendorId,$employeeId);






            $listShift[$i]['start'] = strtotime($listShift[$i]['start']);
            $listShift[$i]['end'] = strtotime($listShift[$i]['end']);
            $date_start1 = date('yy-m-d', $listShift[$i]['start']);;
            $time_start1 = date('H:i:s', $listShift[$i]['start']);
            $date_end1 = date('yy-m-d',$listShift[$i]['end']);
            $time_end1 = date('H:i:s', $listShift[$i]['end']);

            $booking = $this->ShiftModel->getBoookingForShift($this->VendorId,$employeeId,$date_start1,$time_start1,$time_end1);
            $listShift[$i]['count']['booking'] = sizeof($booking);

        }

        return $listShift;

    }

    function listShiftDetail(Request $request)
    {
        $shiftId = $request->id;
        $shiftInfo = $this->ShiftModel->getShiftDetailById($this->VendorId,$shiftId);


        $shiftInfo[0]['start'] = strtotime($shiftInfo[0]['start']);
        $shiftInfo[0]['end'] = strtotime($shiftInfo[0]['end']);
        $date_start1 = date('yy-m-d', $shiftInfo[0]['start']);;
        $time_start1 = date('H:i:s', $shiftInfo[0]['start']);
        $date_end1 = date('yy-m-d',$shiftInfo[0]['end']);
        $time_end1 = date('H:i:s', $shiftInfo[0]['end']);


        $booking = $this->ShiftModel->getBoookingForShift($this->VendorId,$shiftInfo[0]['employee_id'],$date_start1,$time_start1,$time_end1);
//        $return['shiftinfo'] = $shiftInfo;
//        $return['booking'] = $booking;
//        $return['start'] =  $date_start1;
//        $return['end_end'] = $date_end1;
//
//        $return['start3'] =   $time_start1;
//        $return['end_time1'] =   $time_end1;

        $return['user'] = $shiftInfo[0]['employee_id'];

        $timexx1 = strtotime($booking[0]['start']);
        $timexx2 = strtotime($booking[0]['end']);

        $booking[0]['start'] = $timexx1;
        $booking[0]['end'] = $timexx2;



        return $booking;

    }

    function showFullCalendar(){
        $InfoShift =  $this->ShiftModel->listShiftForAllEmployee($this->VendorId);
        for($i = 0 ;$i< sizeof($InfoShift);$i++){
            $employee = $this->Staff->getInforStaff($this->VendorId,$InfoShift[$i]['employee_id']);
            $InfoShift[$i]['employee_id'] = (int)$InfoShift[$i]['employee_id'] ;
            $InfoShift[$i]['name'] = $employee[0]['name'] ;

            $InfoShift[$i]['start'] = strtotime($InfoShift[$i]['start']);
            $InfoShift[$i]['end'] = strtotime($InfoShift[$i]['end']);

            $date_start1 = date('yy-m-d', $InfoShift[$i]['start']);;
            $time_start1 = date('H:i:s', $InfoShift[$i]['start']);
            $date_end1 = date('yy-m-d',$InfoShift[$i]['end']);
            $time_end1 = date('H:i:s', $InfoShift[$i]['end']);

            $booking = $this->ShiftModel->getBoookingForShift($this->VendorId,$InfoShift[$i]['employee_id'],$date_start1,$time_start1,$time_end1);
            $InfoShift[$i]['count']['booking'] = sizeof($booking);
        }


        return $InfoShift;

    }

    function deleteShift(Request $request){
        $shiftId = $request->shiftid;
        $shiftInfo = $this->ShiftModel->getShiftDetailById($this->VendorId,$shiftId);
        $booking = $this->ShiftModel->getBoookingForShift($this->VendorId, $shiftInfo[0]['employee_id'],$shiftInfo[0]['day'],$shiftInfo[0]['start_time'],$shiftInfo[0]['end_time']);
        foreach ($booking  as $b){
          $this->ShiftModel->deleteBookingInShift($this->VendorId,$shiftInfo[0]['employee_id'],$b['schedule_id']);
        }
        $this->ShiftModel->deleteShift($this->VendorId,$shiftInfo[0]['employee_id'],$shiftId);

        $return['code'] = 0;

        return $return;




    }





}
