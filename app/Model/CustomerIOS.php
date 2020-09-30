<?php


namespace App\Model;
use Illuminate\Support\Facades\DB;

class CustomerIOS  extends MyModel
{

    function customerIOS($customer){
         if(!isset($customer['name']))
         {
             $customer['name'] = null;
         }if (!isset($customer['birthday'])){
             $customer['birthday'] = null;
         }if (!isset($customer['email'])){
             $customer['email'] = null;
         }if (!isset($customer['phone_number'])){
             $customer['phone_number'] = null;
         }if (!isset($customer['visit_count'])){
             $customer['visit_count'] = null;
         }if (!isset($customer['last_visit'])){
             $customer['last_visit'] = null;
         }if (!isset($customer['card_number'])){
             $customer['card_number'] = null;
         }if (!isset($customer['card_exp_date'])){
             $customer['card_exp_date'] = null;
         }if (!isset($customer['card_issue'])){
             $customer['card_issue'] = null;
         }
         if (!isset($customer['card_type'])){
             $customer['card_type'] = null;
         }

        return $customer;
    }


    function AssigneCustomerForIOS($vendor,$name,$phone,$email,$birthday,$visit_count){
        $data = DB::table('customer')->updateOrInsert(['phone_number' => $phone,'vendor'=>$vendor],
            ['name'=> $name ,'last_visit'=>DB::raw('NOW()'),'birthday'=>$birthday,'email'=>$email,'visit_count'=>$visit_count]);
        return $data;
    }
    function listIOSCustomer($vendor){
        $data = DB::table('customer')
            ->leftjoin('membercard','membercard.cus_id','=','customer.id')
            ->select('customer.id','customer.name','customer.phone_number','customer.email',
                'customer.birthday','customer.visit_count','customer.last_visit','membercard.card_number'
                ,'membercard.card_exp_date','membercard.card_issue','membercard.card_type')
            ->where('customer.vendor','=',$vendor)
            ->get();

        return  $this->decodeStd($data);
    }
    function assignaCardForCustomer($vendor,$cus_id,$card_number,$card_exp,$card_type,$card_issue){
        $data = DB::table('membercard')->updateOrInsert(['vendor'=>$vendor,'cus_id'=>$cus_id]
        ,['card_number'=>$card_number,'card_type'=>$card_type,'card_issue'=>$card_issue,'card_exp_date'=>$card_exp]);

        return $data;
    }

    function deleteCustomer($vendor,$customerID){
       $data =  DB::table('customer')
           ->where('vendor',$vendor)
           ->where('id',$customerID)
           ->delete();
    }
    function unsignCard($vendor,$cus_id){
        $data =  DB::table('membercard')
            ->where('vendor',$vendor)
            ->where('cus_id',$cus_id)
            ->delete();
    }
    function getCusById($vendor,$cus_id){
        $data = DB::table('customer')
            ->leftjoin('membercard','membercard.cus_id','=','customer.id')
            ->select('customer.id','customer.name','customer.phone_number','customer.email',
                'customer.birthday','customer.visit_count','membercard.card_number','membercard.card_exp_date','membercard.card_issue','membercard.card_type')
            ->where('customer.vendor','=',$vendor)
            ->where('customer.id','=',$cus_id)
            ->get();

        return  $this->decodeStd($data);
    }

    function filterByPhoneAndName($vendor,$phone,$name){
        $data = DB::table('customer')
            ->leftjoin('membercard','membercard.cus_id','=','customer.id')
            ->select('customer.id','customer.name','customer.phone_number','customer.email',
                'customer.birthday','customer.visit_count','customer.last_visit','membercard.card_number'
                ,'membercard.card_exp_date','membercard.card_issue','membercard.card_type')
            ->where('customer.vendor','=',$vendor)
            ->where('customer.name','like','%'.$name.'%')
            ->where('customer.phone_number','like','%'.$phone.'%')
            ->get();

        return  $this->decodeStd($data);
    }
    function filterByPhone($vendor,$phone){
        $data = DB::table('customer')
            ->leftjoin('membercard','membercard.cus_id','=','customer.id')
            ->select('customer.id','customer.name','customer.phone_number','customer.email',
                'customer.birthday','customer.visit_count','customer.last_visit','membercard.card_number'
                ,'membercard.card_exp_date','membercard.card_issue','membercard.card_type')
            ->where('customer.vendor','=',$vendor)
            ->where('customer.phone_number','like','%'.$phone.'%')
            ->get();

        return  $this->decodeStd($data);
    }
    function filterByName($vendor,$name){
        $data = DB::table('customer')
            ->leftjoin('membercard','membercard.cus_id','=','customer.id')
            ->select('customer.id','customer.name','customer.phone_number','customer.email',
                'customer.birthday','customer.visit_count','customer.last_visit','membercard.card_number'
                ,'membercard.card_exp_date','membercard.card_issue','membercard.card_type')
            ->where('customer.vendor','=',$vendor)
            ->where('customer.name','like','%'.$name.'%')
            ->get();

        return  $this->decodeStd($data);
    }


}
