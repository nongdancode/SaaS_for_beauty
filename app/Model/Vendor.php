<?php
/**
 * Created by IntelliJ IDEA.
 * User: letua
 * Date: 2/18/2020
 * Time: 12:46 PM
 */

namespace App\Model;

use Illuminate\Support\Facades\DB;
class Vendor extends MyModel
{
    protected $vendor_key = "vendor_key";
    protected  $vendor =  "vendor_store";

    function getVendorAuthorizeKey($vendor){
       $queryState = DB::table($this->vendor_key)->select('key1','key3')->where('vendor_id',$vendor)->get();
       return $this->decodeStd($queryState);
    }
    function getVendor($vendor){
        $queryState = DB::table($this->vendor)->where('id',$vendor)->get();
        return $this->decodeStd($queryState);
    }
    function updateVendorInfo($vendor,$name,$address,$phone){
        $queryState = DB::table($this->vendor)->updateOrInsert(['id'=>$vendor,],['name'=>$name,'address'=>$address,'phone_number'=>$phone]);
        return $queryState;
    }
    function updateVendorFinancialInfo($tax,$vendor){
        $queryState = DB::table($this->vendor_key)
            ->updateOrInsert(['key_type'=>'financial_info','vendor_id'=>$vendor],['key1'=>$tax]);
        return $queryState;
    }
}
