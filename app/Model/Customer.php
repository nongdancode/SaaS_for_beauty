<?php

namespace App;

namespace App\Model;

use Illuminate\Support\Facades\DB;

class Customer extends MyModel

{
    protected $table = "customer";



    function getCustomerPhoneByVendor($vendor)
    {
        $data = DB::table('customer')->select('name', 'phone_number')->where('vendor', $vendor)->get();


        return $data;
//         return $data;
    }

    function getCustomerByDemand($limit)
    {
        $data = DB::table('customer')->limit($limit)->get();


        return $data;
    }

    function getCustomerByDemandandTimeSteamp($limit)
    {
        $data = DB::table('customer')->select('id',DB::raw('UNIX_TIMESTAMP(last_visit) as last_visit'),
            DB::raw('UNIX_TIMESTAMP(birthday) as birthday'),'visit_count','amount_paid'
            )->limit($limit)->get();


        return $data;
    }

    function getCustomerByIdVendor($cusId,$vendorID){
        $data = DB::table('customer')->select('name', 'phone_number')
            ->where('vendor', $vendorID)
            ->where('id',$cusId)
            ->get();


        return $data;
    }

    function addCustomerByBooking($phone_number , $name ,$amount_paid ,$point){
        $data = DB::table('customer')->updateOrInsert(['phone_number' => $phone_number],
            ['name'=> $name ,'amount_paid'=> $amount_paid,'point' => $point]);
    }

    function getCusByPhoneVendor($vendor,$phone){
        $data = DB::table('customer')->select('name', 'phone_number','id','amount_paid','birthday')
            ->where('vendor', $vendor)
            ->where('phone',$phone)
            ->get();


        return $data;

    }


}
