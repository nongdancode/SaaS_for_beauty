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
        $dbData = DB::table($this->table)->select('id', 'image as img', 'service_name as name', 'duration as stepping')->where("vendor", $vendor)->get();

//        return view('/admin/sms',$dbData);
        return $dbData;

    }


}
