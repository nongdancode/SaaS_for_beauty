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


        return $dbData;
    }

    public function getTransactionByVendorBytimStamp($vendor,$limit){
        $dbData = DB::table($this->table)->select('card_type','status','amount',DB::raw('UNIX_TIMESTAMP(charge_at) as charge_at'))->   where("vendor", $vendor)->limit($limit)->get();


        return $dbData;
    }

    public function storeTransactionOnlineetail(){

    }

}
