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
                'service.duration as stepping','service.image as img'
                ,DB::raw('(TIME_TO_SEC(scheduletask.start_time) +  UNIX_TIMESTAMP(scheduletask.day)) as start'),
                DB::raw('(TIME_TO_SEC(scheduletask.end_time) +  UNIX_TIMESTAMP(scheduletask.day)) as end'))
            ->where('scheduletask.vendor', '=', $vendor)
            ->where('scheduletask.user_ids', '=', $employeeId)

            ->get();
        return  $this->decodeStd($queryState);
    }
    function getBookingTurnForChecking($vendor,$user_id,$service_id,$start_timecheck){
        $data = DB::table('scheduletask')



            ->where('vendor',$vendor)
            ->where('user_ids',$user_id)
            ->where('services_ids',$service_id)

            ->where('status' ,'=','active')
            ->whereRaw('(TIME_TO_SEC(scheduletask.start_time) +  UNIX_TIMESTAMP(scheduletask.day))*1000 = ?',[$start_timecheck])

            ->get();

        return $this->decodeStd($data);

    }

    function confirmBooking($vendorid,$cus_id,$service_id,$start_time){
        DB::table('scheduletask')
            ->where('services_ids', '=',$service_id)
            ->where('user_ids','=',$cus_id)
            ->where('vendor','=',$vendorid)
            ->whereRaw('(TIME_TO_SEC(scheduletask.start_time) +  UNIX_TIMESTAMP(scheduletask.day))*1000 = ?',[$start_time])
            ->update(['status'=>'booking']);
    }


//    function getCusWaitlist($vendorId){
//        $data = DB::table('scheduletask')
//            ->join('service','service.id','=','scheduletask.services_ids')
//            ->join('user','user.id','=','scheduletask.user_ids')
//            ->select('')
//    }
}
