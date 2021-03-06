<?php


namespace App\Model;

use Illuminate\Support\Facades\DB;
class ConfigVendorModel extends MyModel
{
  function getClientBannerConfig($vendor){
      $data = DB::table('vendor_key')
          ->select('key_type as key', 'description as content')
          ->where('vendor_id', $vendor)
          ->where('key_type','=','banner_client_promotion')
          ->get();
      return $this->decodeStd($data);
  }

  function setClientBannerPromotion($vendor,$content){
      $data = DB::table('vendor_key')
          ->updateOrInsert(['vendor_id'=>$vendor,'key_type'=>'banner_client_promotion'],['description'=>$content]);
  }

 function getConfig($vendor){
     $data = DB::table('vendor_key')
         ->select( 'description as content')
         ->where('vendor_id', $vendor)
         ->where('key_type','=','vendor_config')
         ->get();
     return $this->decodeStd($data);
 }

 function setConfig($vendor,$content){
     $data = DB::table('vendor_key')
         ->updateOrInsert(['vendor_id'=>$vendor,'key_type'=>'vendor_config'],['description'=>$content]);
 }

 function setOpenHours($vendor,$content){
     $data = DB::table('vendor_key')
         ->updateOrInsert(['vendor_id'=>$vendor,'key_type'=>'open_hours'],['description'=>$content]);
 }


    function getOpenhours($vendor){
        $data = DB::table('vendor_key')
            ->select( 'description as content')
            ->where('vendor_id', $vendor)
            ->where('key_type','=','open_hours')
            ->get();
        return $this->decodeStd($data);
    }
}
