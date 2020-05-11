<?php


namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Lib\MyUtils;
use App\Lib\SMSTwillo;
use App\Model\Customer;
use App\Model\GroupService;
use App\Model\InternalTransaction;
use App\Model\ScheduleTask;
use App\Model\ServicesVendor;
use App\Model\ServiceWaitlistModel;
use App\Model\Transaction;
use App\Model\UserAdmin;
use Illuminate\Http\Request;


class VendorController
{

    protected $vendorId = 1;
    protected $customerModel;
    protected $util;

    function __construct(Request $request){
        $this->util = new MyUtils();

    }

}
//8326437502 anh nguyen
