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
use App\Model\ServiceWaitlistModel;
use App\Model\Transaction;
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
    protected $TransactionModel;
    protected $ServiceModel;



    function __construct(Request $request)
    {

        $this->customerModel = new Customer();
        $this->util = new MyUtils();
        $this->TwilloSMS = new SMSTwillo();
        $this->SMSUser = $request->getContent();
        $this->TransactionModel = new Transaction();
        $this->ServiceModel = new ServiceWaitlistModel();

    }

    function getWaitlist(){


     $dataCus = $this->customerModel->getCustomerForWaitlist($this->VendorId);
     $CusNonBooking = $this->customerModel->getCusCheckinNonBooking($this->VendorId);
     $CusBooking =  $this->customerModel->getCusCheckinAndBooking($this->VendorId);
     $returnData = [];
     $discount = 0;





     for($i=0; $i< sizeof($dataCus);$i++){
         $invoiceInfo['id'] =rand(10,100000);
         $invoiceInfo['tax'] = 10;


         $aboutInfo['companyName']='The lash supply';
         $aboutInfo['phone'] = '8327744593';
         $address['street'] = 'Bellard';
         $address['city'] = "Houston";
         $address['stage'] = "Texas";
         $aboutInfo['address'] = $address;
         $invoiceInfo['about'] = $aboutInfo;

         $deposit = $dataCus[$i]['deposit'];
       $returnData[$i]['id'] = $dataCus[$i]['id'];
       $returnData[$i]['name'] = $dataCus[$i]['name'];
       $returnData[$i]['phone'] = $dataCus[$i]['phone_number'];
         $returnData[$i]['phone'] = $dataCus[$i]['phone_number'];
         if($deposit > 0){
             $returnData[$i]['status'] = 'booking';
         }else{
             $returnData[$i]['status'] = 'checkin';
         }


         $currentDate = date('Y-m-d');
         $transactions = $this->TransactionModel->getTransactionForCus($this->VendorId,$returnData[$i]['id'], $currentDate);
         if(sizeof($transactions)>0){
             for($a=0; $a< sizeof($transactions);$a++){
                 $deposit = $deposit + $transactions[$a]['amount'];
             }
         }
         $returnData[$i]['deposit'] = $deposit;
         $returnData[$i]['invoice'] = $invoiceInfo;
         $service = $this->ServiceModel->getServiceForWaitlistCheckout($this->VendorId,$returnData[$i]['id']);
         for($a=0;$a< sizeof($service);$a++){
             $returnData[$i]['invoice']['service'][$a]['name'] = $service[$a]['service_name'];
             $returnData[$i]['invoice']['service'][$a]['discount'] = $discount;
             $returnData[$i]['invoice']['service'][$a]['price'] = $service[$a]['price'];
         }


     }

     return  $returnData;

    }

}
