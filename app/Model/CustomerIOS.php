<?php


namespace App\Model;
use Illuminate\Support\Facades\DB;

class CustomerIOS  extends MyModel
{
    function AssigneCustomerForIOS($vendor,$name,$phone,$email,$birthday,$visit_count){
        $data = DB::table('customer')->updateOrInsert(['phone_number' => $phone,'vendor'=>$vendor],
            ['name'=> $name ,'last_visit'=>DB::raw('NOW()'),'birthday'=>$birthday,'email'=>$email,'visit_count'=>$visit_count]);
        return $data;
    }
    function listIOSCustomer($vendor){
        $data = DB::table('customer')->select('customer.name','customer.phone_number','customer.email',
            'customer.birthday','customer.visit_count','membercard.card_number','membercard.card_exp_date','membercard.card_issue')
            ->join('membercard','membercard.cus_id','=','customer.id')
            ->where('customer.vendor','=',$vendor);
        return  $this->decodeStd($data);
    }
    function assignaCardForCustomr($vendor,$cus_id,$card_number,$card_exp,$card_type,$card_issue){
        $data = DB::table('membercard')->updateOrInsert(['card_number'=>$card_number,'vendor'=>$vendor]
        ,['cus_id'=>$cus_id,'card_type'=>$card_type,'card_issue'=>$card_issue,'card_exp'=>$card_exp]);

        return $data;
    }

}
