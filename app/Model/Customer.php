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
}
