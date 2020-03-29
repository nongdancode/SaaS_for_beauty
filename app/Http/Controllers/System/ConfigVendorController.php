<?php


namespace App\Http\Controllers\System;


use App\Http\Controllers\Controller;
use App\Lib\MyUtils;
use App\Model\ConfigVendorModel;
use Illuminate\Http\Request;

class ConfigVendorController extends Controller
{
    protected $util;
    protected $ConfigModel;
    protected $Vendor_id = 1;

    function __construct(Request $request){
        $this->util = new MyUtils();
        $this->ConfigModel = new ConfigVendorModel();
    }

    function getClientBannerConfig()
    {
        $contentBanner = $this->ConfigModel->getClientBannerConfig($this->Vendor_id);
        return $contentBanner;

    }

  function getVendorConfig(){
        $data = $this->ConfigModel->getConfig($this->Vendor_id);
        return $data[0]['content'];
  }

    function setVendorConfig(Request $request){
        $content = $request->all();
        $data = $this->ConfigModel->setConfig($this->Vendor_id,$content['data']);

        $return['code']= 0;
        return $return;

    }




}
