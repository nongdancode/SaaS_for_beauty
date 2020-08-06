<?php


namespace App\Http\Controllers\System;


use App\Http\Controllers\Controller;
use App\Lib\MyUtils;
use App\Model\ConfigVendorModel;
use App\Model\Vendor;
use Illuminate\Http\Request;

class ConfigVendorController extends Controller
{
    protected $util;
    protected $ConfigModel;
    protected $Vendor_id = 1;
    protected $Vendor;

    function __construct(Request $request){
        $this->util = new MyUtils();
        $this->ConfigModel = new ConfigVendorModel();
        $this->Vendor = new Vendor();
    }

    function getClientBannerConfig()
    {
        $contentBanner = $this->ConfigModel->getClientBannerConfig($this->Vendor_id);
        return $this->util->returnHttps($contentBanner,0,'') ;
    }

  function getVendorConfig(){
        $data = $this->ConfigModel->getConfig($this->Vendor_id);

      return $this->util->returnHttps($data[0]['content'],0,'') ;
  }

    function setVendorConfig(Request $request){
        $content = $request->all();
        $data = $this->ConfigModel->setConfig($this->Vendor_id,$content['data']);
        $jsonContent = json_decode($content['data'],true);
        $InfoStore = $jsonContent['information'];
        $this->Vendor->updateVendorInfo($this->Vendor_id,$InfoStore['store-name']['value'],$InfoStore['store-address']['value'],$InfoStore['store-phone']['value']);
        $this->Vendor->updateVendorFinancialInfo($InfoStore['store-tax']['value'],$this->Vendor_id);
        return  $this->util->returnHttps('',0,'') ;
    }

    function getOpenHourConfig(){
      $data = $this->ConfigModel->getOpenhours($this->Vendor_id);
        return $this->util->returnHttps($data[0]['content'],0,'') ;

    }
    function setOpenHourConfig(Request $request){
        $content = $request->all();

        $saveOpenhours = $this->ConfigModel->setOpenHours($this->Vendor_id,$content['data']);

        return $this->util->returnHttps('',0,'');
    }






}
