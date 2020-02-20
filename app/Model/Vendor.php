<?php
/**
 * Created by IntelliJ IDEA.
 * User: letua
 * Date: 2/18/2020
 * Time: 12:46 PM
 */

namespace App\Model;

use Illuminate\Support\Facades\DB;
class Vendor
{
    protected $vendor_key = "vendor_key";
    protected  $vendor =  "vendor_store";

    function getVendorAuthorizeKey($vendor){
       $queryState = DB::table($this->vendor_key)->select('key_1','key_3')->where('vendor_id',$vendor)->get();
       return $queryState;
    }
    function getVendor($vendor){
        $queryState = DB::table($this->vendor)->where('id',$vendor)->get();
        return $queryState;
    }
}
