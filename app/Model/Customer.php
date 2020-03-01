<?php

namespace App;

namespace App\Model;

use Illuminate\Support\Facades\DB;

class Customer extends MyModel

{
    protected $table = "customer";
    protected $ScheduleTable = "scheduletask";



    function getCustomerPhoneByVendor($vendor)
    {
        $data = DB::table('customer')->select('name', 'phone_number')->where('vendor', $vendor)->get();


        return $this->decodeStd($data);
//         return $data;
    }

    function getCustomerByDemand($limit,$vendorId)
    {
        $data = DB::table('customer')
            ->where('vendor',$vendorId)

            ->limit($limit)->get();


        return $this->decodeStd($data);
    }

    function getCustomerByDemandandTimeSteamp($limit)
    {
        $data = DB::table('customer')->select('id',DB::raw('UNIX_TIMESTAMP(last_visit) as last_visit'),
            DB::raw('UNIX_TIMESTAMP(birthday) as birthday'),'visit_count','amount_paid'
            )->limit($limit)->get();


        return $this->decodeStd($data);
    }

    function getCustomerByIdVendor($cusId,$vendorID){
        $data = DB::table('customer')->select('name', 'phone_number')
            ->where('vendor', $vendorID)
            ->where('id',$cusId)
            ->get();


        return $this->decodeStd($data);
    }

    function addCustomerByBooking($vendorId,$phone_number , $name ,$amount_paid ,$point){
        $data = DB::table('customer')->updateOrInsert(['phone_number' => $phone_number],
            ['vendor'=>$vendorId,'name'=> $name ,'amount_paid'=> $amount_paid,'point' => $point,'last_visit'=>DB::raw('NOW()')]);
        return $data;
    }

    function getCusByPhoneVendor($vendor,$phone){
        $data = DB::table('customer')->select('name', 'phone_number','id','amount_paid','birthday')
            ->where('vendor', $vendor)
            ->where('phone_number',$phone)
            ->get();


        return $this->decodeStd($data);

    }

    function addCustomerCheckin($vendorId,$phone_number,$name){
        $data = DB::table('customer')->updateOrInsert(['phone_number' => $phone_number],
            ['vendor'=>$vendorId,'name'=> $name ,'last_visit'=>DB::raw('NOW()')]
        );

    }

    function getCustomerForWaitlist($vendor){
        $data = DB::table('scheduletask')
            ->join('customer','customer.id','=','scheduletask.cus_id')
        ->select('scheduletask.status','scheduletask.task',
            'customer.name','customer.phone_number','customer.id','customer.amount_paid as deposit')
        ->where('scheduletask.vendor',$vendor)
        ->where('scheduletask.task','=','checkin')
        ->get();

        return $this->decodeStd($data);
    }

    function getCusCheckinNonBooking($vendorId){
        $data =  DB::table('scheduletask')
            ->join('customer','customer.id','=','scheduletask.cus_id')
            ->select('customer.id','customer.name','customer.phone_number','scheduletask.status')
            ->where('scheduletask.task','=','checkin')
            ->where('scheduletask.status','=','active')
            ->where('scheduletask.vendor',$vendorId)
            ->get();

        return $this->decodeStd($data);
    }

    function getCusCheckinAndBooking($vendorId){
        $data =  DB::table('scheduletask')
            ->join('customer','customer.id','=','scheduletask.cus_id')
            ->select('customer.id','customer.name','customer.phone_number','scheduletask.status')
            ->where('scheduletask.task','=','checkin')
            ->where('scheduletask.status','=','booking')
            ->where('scheduletask.vendor',$vendorId)
            ->get();

        return $this->decodeStd($data);
    }


}
