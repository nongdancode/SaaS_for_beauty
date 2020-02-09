<?php
/**
 * Created by IntelliJ IDEA.
 * User: letua
 * Date: 2/4/2020
 * Time: 8:21 PM
 */

namespace App\Model;


class ServicesVendor
{
    protected $table = "services";

    public function getAllServicesByVendor($vendor){
        $dbData = $this->selectRaw('id,service_name,phone_numbermimage' )->where("vendor",$vendor)->get();

//        return view('/admin/sms',$dbData);


    }


}
