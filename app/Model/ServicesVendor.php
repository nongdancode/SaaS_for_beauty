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

    public function getAllServicesByVendor($vendor){
        $dbData = DB::table($this->table)
            ->select('id', 'image as img', 'service_name as name', 'duration as stepping','price')
            ->where("vendor", $vendor)->get();

        return $dbData;

    }

    public function getServicesNameByIdandVendor($vendor,$serviceID)
    {
        $dbData = DB::table($this->table)
            ->select('id', 'image as img', 'service_name as name', 'duration as stepping','price')
            ->where("vendor", $vendor)
             ->where("id", $serviceID)
            ->get();

        return $dbData;
    }

}
