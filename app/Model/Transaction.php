<?php
/**
 * Created by IntelliJ IDEA.
 * User: letua
 * Date: 2/12/2020
 * Time: 6:57 AM
 */

namespace App\Model;


use Illuminate\Support\Facades\DB;

class Transaction extends MyModel
{
    protected $transactionTable = "transaction";
    protected $transactiononline = "transactiononline";



    public function getTransactionByVendor($vendor,$limit){
        $dbData = DB::table($this->table)->where("vendor", $vendor)->limit($limit)->get();


        return $this->decodeStd($dbData);
    }

    public function getTransactionByVendorBytimStamp($vendor,$limit){
        $dbData = DB::table($this->table)
            ->select('card_type','status',
                'amount',DB::raw('UNIX_TIMESTAMP(charge_at) as charge_at'))
            ->   where("vendor", $vendor)->limit($limit)->get();


        return $this->decodeStd($dbData);
    }

  public function getTransactionForCusDeposit($vendor,$cus_phone){
      $dbData = DB::table('transaction')
          ->where('vendor',$vendor)
          ->where('user_phone',$cus_phone)
          ->where('type_charge','=','deposit')
///
          ->get();
      return $this->decodeStd($dbData);
  }




    public function insertTransactionByVendor($card_number,$card_type,$status,$name_on_card,$amount,$vendor,$type_charge,$user_phone,$ref_id){
        $dbData = DB::table('transaction')->insertGetId(
            ['card_number' => $card_number,
                'card_type'=> $card_type,'status'=>$status
                ,'name_on_card'=> $name_on_card,
                'amount'=>$amount,
                'charge_at'=>DB::raw('NOW()'),
                'vendor'=>$vendor,
                'type_charge'=>$type_charge,
                'user_phone'=>$user_phone,
                'ref_id'=>$ref_id]);
        return $dbData;
    }

}
