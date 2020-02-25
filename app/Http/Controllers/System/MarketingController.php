<?php
/**
 * Created by IntelliJ IDEA.
 * User: letua
 * Date: 2/11/2020
 * Time: 3:03 AM
 */

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Lib\MyUtils;
use App\Lib\SMSTwillo;
use App\Model\Customer;
use Illuminate\Http\Request;

class MarketingController extends Controller
{
    protected $util;
    protected $fromDate;
    protected $toDate;
    protected $customerModel;
    protected $TwilloSMS;
    protected $SMSDatatable;
    protected $SMSUser;

    function __construct(Request $request)
    {

        $this->customerModel = new Customer();
        $this->util = new MyUtils();
        $this->TwilloSMS = new SMSTwillo();
        $this->SMSUser = $request->getContent();


    }

    function flectCustomerForMarketing()
    {
        $cus1 = $this->customerModel->getCustomerByDemand(50);

        return $cus1;

    }

    function sendSMSForMkt(){

        $data = $this ->util->decodeJson($this->SMSUser);
        $nums = [];
        for($i = 0 ; $i < sizeof($data['customerIds']);$i++){
          $cus_phone = $this->customerModel->getCustomerByIdVendor($data['customerIds'][$i],1);

          $this->TwilloSMS->SendMessageByNumber($data['message'],$cus_phone[0]['phone_number']);
//
//          print($cus_phone2[0]['phone_number']);
//            exit();
        }


//          return $this->TwilloSMS->SendMessageByList($data['message'],$nums);
    }


}
