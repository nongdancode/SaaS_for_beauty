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


}
