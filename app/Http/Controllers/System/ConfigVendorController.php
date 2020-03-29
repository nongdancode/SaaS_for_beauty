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

    function setClientBannerConfig(Request $request){

    }


}
