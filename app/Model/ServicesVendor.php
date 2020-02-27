<?php
/**
 * Created by IntelliJ IDEA.
 * User: letua
 * Date: 2/4/2020
 * Time: 8:21 PM
 */

namespace App\Model;

use Illuminate\Support\Facades\DB;

class ServicesVendor extends MyModel
{
    protected $table = "service";
    protected $table2 = "users_services";

    public function getAllServicesByVendor($vendor){
        $dbData = DB::table($this->table)
            ->select('id', 'image as img', 'service_name as name', 'duration as stepping','price')
            ->where("vendor", $vendor)->get();

        return $this->decodeStd($dbData);

    }

    public function getServicesNameByIdandVendor($vendor,$serviceID)
    {
        $dbData = DB::table($this->table)
            ->select('id', 'image as img', 'service_name as name', 'duration as stepping','price')
            ->where("vendor", $vendor)
             ->where("id", $serviceID)
            ->get();

        return $this->decodeStd($dbData);
    }

    public function getservicesByStaff($vendor,$user_id){
        $dbData = DB::table('service')->join('users_services' ,'users_services.services_id','=','service.id')
            ->select('service.service_name as name','service.id as id','service.image as img','service.duration as stepping',
                DB::raw('CAST("booking" AS char) as type'))
            ->where('users_services.vendor_id',$vendor)
            ->where('users_services.user_id',$user_id)
            ->get();
        return $this->decodeStd($dbData);

    }

    function addServices($vendorId, $servicenName,$servicePrice,$duration){
        $dbData = DB::table('service')->insertGetId( ['vendor' => $vendorId, 'service_name'=> $servicenName,'duration'=>$duration,'price'=> $servicePrice
           ]);
        return $dbData;
    }
    function addEmployeeForServies($vendorId,$servicesID,$employeeId){
        $dbData = DB::table('users_services')->insertGetId(['vendor_id'=>$vendorId,'services_id'=>$servicesID,'user_id'=>$employeeId
            ]);

        return $dbData;
    }


}
