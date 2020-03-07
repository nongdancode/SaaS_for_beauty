<?php
/**
 * Created by IntelliJ IDEA.
 * User: letua
 * Date: 2/29/2020
 * Time: 3:39 AM
 */

namespace App\Model;
use Illuminate\Support\Facades\DB;

class ServiceWaitlistModel  extends MyModel
{
    protected $table = "service";

    function getServiceForWaitlistCheckout($vendorId,$cus_id){
        $dbData = DB::table('scheduletask')
            ->join('service','service.id', '=','scheduletask.services_ids')
            ->select('service.service_name','service.price','service.duration','scheduletask.user_ids','scheduletask.vendor','service.id')
            ->where('scheduletask.vendor',$vendorId)
            ->where('cus_id',$cus_id)
            ->where('task','=','checkin')
            ->get();
        return $this->decodeStd($dbData);
     }

     function checkoutForWatilist($vendorId,$cus_id,$service_id){

     }

//     function updateSchedueleTaskForCheckin($vendor,$cus_id,$start_time,$end_time,$day,$service_id){
//         $dbData = DB::table('scheduletask')
//             ->updateOrInsert(['vendor'=>$vendor,'cus_id'=>$cus_id])
//     }
}
