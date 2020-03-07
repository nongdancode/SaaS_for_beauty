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
           ->insertGetId(['day'=>$day,'start_time'=>$start_time,'end_time'=>$end_time,'vendor'=>$vendor,'user_ids'=>$employee_id]);
       return $data;

   }
}
