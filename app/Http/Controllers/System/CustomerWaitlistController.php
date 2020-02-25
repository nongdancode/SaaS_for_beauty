<?php
/**
 * Created by IntelliJ IDEA.
 * User: letua
 * Date: 2/24/2020
 * Time: 3:41 PM
 */

namespace App\Http\Controllers\System;
use App\Http\Controllers\Controller;
use App\Lib\MyUtils;
use App\Lib\SMSTwillo;
use App\Model\Customer;
use Illuminate\Http\Request;

class CustomerWaitlistController extends Controller
{
    protected $util;
    protected $fromDate;
    protected $toDate;
    protected $customerModel;
    protected $TwilloSMS;
    protected $SMSDatatable;
    protected $SMSUser;
    protected $VendorId = 1;



    function __construct(Request $request)
    {

        $this->customerModel = new Customer();
        $this->util = new MyUtils();
        $this->TwilloSMS = new SMSTwillo();
        $this->SMSUser = $request->getContent();

    }

    function getWaitlist(){


     $dataCus = $this->customerModel->getCustomerForWaitlist($this->VendorId);

     $CusNonBooking = $this->customerModel->getCusCheckinNonBooking($this->VendorId);
     $CusBooking =  $this->customerModel->getCusCheckinAndBooking($this->VendorId);
     $returnData = [];

     $invoiceInfo['id'] =rand(10,100000);
     $invoiceInfo['tax'] = 10;


     $aboutInfo['companyName']='The lash supply';
        $aboutInfo['phone'] = '8327744593';
        $address['street'] = 'Bellard';
        $address['city'] = "Houston";
        $address['stage'] = "Texas";
        $aboutInfo['address'] = $address;
        $invoiceInfo['about'] = $aboutInfo;



     for($i=0; $i< sizeof($dataCus);$i++){

     }
//     $returnData =


     return $dataCus;

    }
}
