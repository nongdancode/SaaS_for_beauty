<?php
/**
 * Created by IntelliJ IDEA.
 * User: letua
 * Date: 2/22/2020
 * Time: 7:44 AM
 */

namespace App\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
class ScheduleTask  extends MyModel
{

    protected $ScheduleTask = 'scheduletask';

    protected $serviceTable = 'service';
    protected $staffTable = 'user';

    function getScheduleForStaff($employeeId,$vendor){
        $queryState = DB::table('scheduletask')
            ->join('service', 'scheduletask.services_ids', '=', 'service.id')
            ->select( 'scheduletask.services_ids as id', 'service.service_name as name','service.image as img',
                'service.duration as stepping','service.image as img','scheduletask.status'
                ,DB::raw('(TIME_TO_SEC(scheduletask.start_time) +  UNIX_TIMESTAMP(scheduletask.day)) as start'),
                DB::raw('(TIME_TO_SEC(scheduletask.end_time) +  UNIX_TIMESTAMP(scheduletask.day)) as end'))
            ->where('scheduletask.vendor',  $vendor)
            ->where('scheduletask.user_ids',  $employeeId)
            ->get();
        return  $this->decodeStd($queryState);
    }



    function getBookingTurnForChecking($vendor,$user_id,$start_time,$end_time,$day){
        $data = DB::table('scheduletask')
            ->where('vendor',$vendor)
            ->where('user_ids',$user_id)
            ->where('day','=',$day)
            ->where('status' ,'=','booking')
            ->where('start_time','<=',$end_time)
            ->where('end_time','>=',$start_time)
            ->get();
        return $this->decodeStd($data);
    }

    function confirmBooking($vendorid,$cus_id,$service_id,$employee_id,$start_time,$end_time,$day){
      $data =   DB::table('scheduletask')
          ->insertGetId(['vendor'=>$vendorid,'user_ids'=>$employee_id,'cus_id'=>$cus_id,
              'services_ids'=>$service_id,'day'=>$day,'start_time'=>$start_time,'end_time'=>$end_time,'status'=>'booking']);

        return $data;
    }

    function confirmCheckin($vendorid,$cus_id,$service_id,$employee_id,$start_time,$end_time,$day){
        DB::table('scheduletask')
            ->where('cus_id',$cus_id)
            ->whereRaw('scheduletask.day = CURDATE()')
            ->where('status','=',null)
            ->delete();

        DB::table('scheduletask')->insertGetId(
            ['cus_id' => $cus_id,'vendor'=>$vendorid,'day'=>DB::raw('CURDATE()'),'task'=>'checkin',
            'services_ids'=>$service_id,'start_time'=>$start_time,'end_time'=>$end_time,'status'=>'booking','user_ids'=>$employee_id]
        );
    }

    function addCusCheckin($vendorId,$cus_id){
        DB::table('scheduletask')->updateOrInsert(
            ['cus_id' => $cus_id,'vendor'=>$vendorId,'day'=>DB::raw('CURDATE()')],
            ['task'=>'checkin']
        );

    }
    function updateCusBooking($vendorId,$cus_id){
        DB::table('scheduletask')
            ->where('vendor','=',$vendorId)
            ->where('cus_id',$cus_id)
            ->whereRaw('day = CURDATE()')
            ->update(['task'=>'checkin']);

    }

    function getCusBooking($vendorId,$cusID){
       $data =  DB::table('scheduletask')

            ->where('scheduletask.status','=','booking')
      ->where('scheduletask.cus_id','=',$cusID)
           ->whereRaw('scheduletask.day = CURDATE()')
            ->where('scheduletask.vendor',$vendorId)
            ->get();

        return $this->decodeStd($data);
    }


  function getScheduleOfStaffForCheckingDelete($vendorId,$staffId){
      $data =  DB::table('scheduletask')
          ->where('vendor',$vendorId)
          ->where('user_ids',$staffId)
          ->get();
      return $this->decodeStd($data);
  }

  function getScheduleOfStaffForCheckAdd($vendorId,$staffId,$start_time,$service_id){
      $data =  DB::table('scheduletask')
          ->where('vendor',$vendorId)
          ->where('user_ids',$staffId)
          ->where('services_ids',$service_id)
          ->whereRaw('(TIME_TO_SEC(scheduletask.start_time) +  UNIX_TIMESTAMP(scheduletask.day)) = ?',[$start_time])
          ->get();
      return $this->decodeStd($data);
  }

  function addScheduleForStaff($vendorId,$staffId,$start_time,$service_id,$end_time,$day){
      $data =  DB::table('scheduletask')
          ->  insertGetId(['start_time'=>$start_time,'end_time'=> $end_time,'day'=>$day,
              'services_ids' => $service_id, 'user_ids'=> $staffId,'vendor'=>$vendorId,'status'=>'active']);

      return $data;
  }

  function getScheduleTaskIDbyConditions($vendorId,$staffId,$start_time,$service_id){
      $data =  DB::table('scheduletask')
         ->select('id')
          ->where('vendor',$vendorId)
          ->where('user_ids',$staffId)
          ->where('services_ids',$service_id)

          ->whereRaw('(TIME_TO_SEC(scheduletask.start_time) +  UNIX_TIMESTAMP(scheduletask.day)) = ?',[$start_time])
          ->get();
      return $this->decodeStd($data);
  }

  function deleteScheduleTaskByCondition($id,$vendorId){
      DB::table('scheduletask')
          ->where('id', '=', $id)
          ->where('vendor',$vendorId)
          ->delete();
  }

    function deleteTaskForWaitlistCheckout($vendorID,$cusId,$service_id,$employee_id){
        $data = DB::table('scheduletask')
            ->where('vendor',$vendorID)
            ->where('services_ids',$service_id)
            ->where('cus_id',$cusId)
            ->where('user_ids',$employee_id)
            ->where('task','=','checkin')
            ->where('status','=','booking')
            ->whereRaw('day = CURDATE()')
            ->delete();

        return $data;
 }
}
