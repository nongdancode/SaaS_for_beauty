<?php
/**
 * Created by IntelliJ IDEA.
 * User: letua
 * Date: 2/17/2020
 * Time: 5:36 AM
 */

namespace App\Model;

use Illuminate\Support\Facades\DB;
class BookingTurn  extends MyModel
{
    protected $table = "bookingturns";

    function confirmBookingTurn($service_id,$user_id,$cus_id,$star_time,$end_time){
        $queryState = DB::table('bookingturns')->insertGetId(
            ['service_id' => $service_id,'user_id'=> $user_id,'cus_id'=>$cus_id,'start_time'=>$star_time,'end_time'=>$end_time]
        );
    }

    function getBookingTurnForChecking($vendor,$user_id,$service_id,$start_timecheck){
        $data = DB::table('bookingturns')
            ->where('vendor_id',$vendor)
            ->where('user_id',$user_id)
            ->where('service_id',$service_id)
            ->where('start_time','<=',$start_timecheck)
            ->where('end_time','>=',$start_timecheck)
            ->get();

        return $data;

    }


}
