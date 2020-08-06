<?php


namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Lib\MyUtils;
use App\Lib\SMSTwillo;
use App\Model\ConfigVendorModel;
use App\Model\Customer;
use App\Model\GroupService;
use App\Model\InternalTransaction;
use App\Model\ScheduleTask;
use App\Model\ServicesVendor;
use App\Model\ServiceWaitlistModel;
use App\Model\Transaction;
use App\Model\UserAdmin;
use Illuminate\Http\Request;
use App\Model\Vendor;


class VendorController
{

    protected $vendorId = 1;
    protected $customerModel;
    protected $util;
    protected $vendor;
    protected $vendorConfig;

    function __construct(Request $request){
        $this->util = new MyUtils();
        $this->vendor = new Vendor();
        $this->vendorConfig = new ConfigVendorModel();
    }

    function updateVendorInformation(){
    $data = $this->vendorConfig->getConfig($this->vendorId);
    $object = json_decode($data['data'],true);
//    $this->vendor->updateVendorInfo($)
        return $data;
    }

    function getVendorInfo(){

    }

}


//8326437502 anh nguyen
