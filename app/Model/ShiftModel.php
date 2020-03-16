<?php
/**
 * Created by IntelliJ IDEA.
 * User: letua
 * Date: 3/7/2020
 * Time: 2:04 AM
 */

namespace App\Model;
use Illuminate\Support\Facades\DB;

class ShiftModel  extends MyModel
{
   function addShift($day,$start_time,$end_time,$vendor,$employee_id){
       $data = DB::table('scheduletask')

           ->insertGetId(['day'=>$day,'start_time'=>$start_time,'end_time'=>$end_time,'vendor'=>$vendor,'user_ids'=>$employee_id,'status'=>'em_shift']);
       return $data;
   }


   function returnDupShift($day,$star_time,$end_time,$vendor,$employeeId){
       $data = DB::table('scheduletask')
           ->where('day','=',$day)
           ->where('vendor',$vendor)
           ->where('user_ids',$employeeId)
           ->where('start_time','<=',$end_time)
           ->where('end_time','>=',$star_time)
           ->where('status','=','em_shift')
           ->get();

       return $this->decodeStd( $data);
   }

   function getShiftDetailById($vendor,$shiftId){
       $data = DB::table('scheduletask')
           ->select( 'id','user_ids as employee_id','scheduletask.day as day',
               'scheduletask.services_ids','scheduletask.status','scheduletask.start_time as start_time', 'scheduletask.end_time as end_time'
//               ,DB::raw('(TIME_TO_SEC(scheduletask.start_time) +  UNIX_TIMESTAMP(scheduletask.day)) as start')
               ,DB::raw('concat(scheduletask.day, \' \', scheduletask.start_time) as start'),
//               DB::raw('(TIME_TO_SEC(scheduletask.end_time) +  UNIX_TIMESTAMP(scheduletask.day)) as end'),
               DB::raw('concat(scheduletask.day, \' \', scheduletask.end_time) as end'))

           ->where('scheduletask.vendor','=',$vendor)
           ->where('scheduletask.id','=',$shiftId)
           ->get();
       return $this->decodeStd($data);

   }

   function listShiftForEmployee($vendor,$employeeId){
       $data = DB::table('scheduletask')


           ->select( 'id','user_ids as employee_id',
               'scheduletask.services_ids','scheduletask.status'
//               ,DB::raw('(TIME_TO_SEC(scheduletask.start_time) +  UNIX_TIMESTAMP(scheduletask.day)) as start')
               ,DB::raw('concat(scheduletask.day, \' \', scheduletask.start_time) as start'),
//               DB::raw('(TIME_TO_SEC(scheduletask.end_time) +  UNIX_TIMESTAMP(scheduletask.day)) as end'),
               DB::raw('concat(scheduletask.day, \' \', scheduletask.end_time) as end'))
           ->whereRaw('day >= CURDATE()')
           ->where('vendor',$vendor)
           ->where('user_ids',$employeeId)
           ->where('status','=','em_shift')
           ->get();


       return $this->decodeStd($data);
   }

   function getBoookingForShift($vendor,$employeeId,$day,$start_time,$end_time){
       $queryState = DB::table('scheduletask')

           ->join('service', 'scheduletask.services_ids', '=', 'service.id')
           ->select( 'scheduletask.services_ids as id', 'service.service_name as name','service.image as img','scheduletask.id as schedule_id',
               'service.duration as stepping','service.image as img','scheduletask.status',
//               DB::raw('(TIME_TO_SEC(scheduletask.start_time) +  UNIX_TIMESTAMP(scheduletask.day)) as start'),
//               DB::raw('(TIME_TO_SEC(scheduletask.end_time) +  UNIX_TIMESTAMP(scheduletask.day)) as end'),
               DB::raw('concat(scheduletask.day, \' \', scheduletask.start_time) as start'),
               DB::raw('concat(scheduletask.day, \' \', scheduletask.end_time) as end'))
           ->where('scheduletask.vendor',  $vendor)
           ->where('scheduletask.user_ids',  $employeeId)
           ->where('scheduletask.status',  '=' ,'booking')
           ->where('day','=',$day)

           ->where('scheduletask.start_time','>=',$start_time)
           ->where('scheduletask.end_time','<=',$end_time)

           ->get();
       return  $this->decodeStd($queryState);
   }



   function listShiftForAllEmployee($vendor ){
       $data = DB::table('scheduletask')
           ->select( 'id','user_ids as employee_id',
               'scheduletask.services_ids','scheduletask.status',
//               DB::raw('(TIME_TO_SEC(scheduletask.start_time) +  UNIX_TIMESTAMP(scheduletask.day)) as start'),
//               DB::raw('(TIME_TO_SEC(scheduletask.end_time) +  UNIX_TIMESTAMP(scheduletask.day)) as end')
              DB::raw('concat(scheduletask.day, \' \', scheduletask.start_time) as start'),
               DB::raw('concat(scheduletask.day, \' \', scheduletask.end_time) as end'))
           ->whereRaw('day >= CURDATE()')
           ->where('vendor',$vendor)
           ->where('status','=','em_shift')
           ->get();
       return $this->decodeStd($data);
   }

   function deleteShift($vendor,$employeeId,$shiftId){
       $data = DB::table('scheduletask')
           ->where('vendor',$vendor)
           ->where('user_ids',$employeeId)
           ->where('id',$shiftId)
           ->where('status','=','em_shift')
           ->delete();


   }

  function deleteBookingInShift($vendor,$employeeId,$bookingId){
             $data2 = DB::table('scheduletask')
           ->where('vendor',$vendor)
           ->where('user_ids',$employeeId)
           ->where('id',$bookingId)
           ->where('status','=','booking')
           ->delete();
  }

}
