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
use App\Model\GroupService;
use App\Model\InternalTransaction;
use App\Model\ScheduleTask;
use App\Model\ServicesVendor;
use App\Model\ServiceWaitlistModel;
use App\Model\Transaction;
use App\Model\UserAdmin;
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
    protected $InternalTransaction;
    protected $Tax = 10;
    protected $ScheduleTask;
    protected $GroupService;
    protected $userModel;
    protected $serviceModel;




    function __construct(Request $request)
    {

        $this->customerModel = new Customer();
        $this->util = new MyUtils();
        $this->TwilloSMS = new SMSTwillo();
        $this->SMSUser = $request->getContent();
        $this->TransactionModel = new Transaction();
        $this->ServiceModel = new ServiceWaitlistModel();
        $this->InternalTransaction = new InternalTransaction();
        $this->ScheduleTask = new ScheduleTask();
        $this->GroupService = new GroupService();
        $this->serviceModel = new ServicesVendor();
        $this->userModel = new UserAdmin();

        date_default_timezone_set('America/Chicago');

    }

    function getWaitlist(){


     $dataCus = $this->customerModel->getCustomerForWaitlist($this->VendorId);
     $CusNonBooking = $this->customerModel->getCusCheckinNonBooking($this->VendorId);
     $CusBooking =  $this->customerModel->getCusCheckinAndBooking($this->VendorId);
     $returnData = [];
     $discount = 0;
     $deposit = 0;



     for($i=0; $i< sizeof($dataCus);$i++){
         //info vendor
         $invoiceInfo['id'] =rand(10,100000);
         $invoiceInfo['tax'] = $this->Tax;

         $aboutInfo['companyName']='The lash supply';
         $aboutInfo['phone'] = '8327744593';
         $address['streetAddress'] = '250 Bellard';
         $address['city'] = "Houston";
         $address['state'] = "Texas";
         $aboutInfo['address'] = $address;




         $returnData[$i]['id'] = $dataCus[$i]['id'];
       $returnData[$i]['name'] = $dataCus[$i]['name'];
       $returnData[$i]['phone'] = $dataCus[$i]['phone_number'];
         $returnData[$i]['phone'] = $dataCus[$i]['phone_number'];
//check cus is booking or checkin
         if($dataCus[$i]['status'] == 'booking'){

             $returnData[$i]['status'] = 'booking';
             $deposit2 = $this->TransactionModel->getTransactionForCusDeposit($this->VendorId,$dataCus[$i]['phone_number']);
             if(sizeof($deposit2)>0){
                 $deposit = $deposit2[0]['amount'];
             }else{
                 $deposit = 0;
             }
             $invoiceInfo['about'] = $aboutInfo;
             $invoiceInfo['about']['customer']['name'] = $dataCus[$i]['name'];
             $invoiceInfo['about']['customer']['phone'] = $dataCus[$i]['phone_number'];
         }else{
             $returnData[$i]['status'] = 'checkin';
             $deposit = 0;
         }

         $currentDate = date('Y-m-d');


         $returnData[$i]['invoice'] = $invoiceInfo;
         $returnData[$i]['invoice']['deposit'] = $deposit;
         //get data of services for checkout step
         $service = $this->ServiceModel->getServiceForWaitlistCheckout($this->VendorId,$returnData[$i]['id']);
         for($a=0;$a< sizeof($service);$a++){
             $returnData[$i]['invoice']['services'][$a]['name'] = $service[$a]['service_name'];
             $returnData[$i]['invoice']['services'][$a]['discount'] = $discount;
             $returnData[$i]['invoice']['services'][$a]['price'] = $service[$a]['price'];
             $returnData[$i]['invoice']['services'][$a]['employee_id'] = $service[$a]['user_ids'];
             $returnData[$i]['invoice']['services'][$a]['service_id'] = $service[$a]['id'];

         }
     }

     return  $returnData;

    }

    function CheckinToCheckoutWaitlist(Request $request){
        $billInfo  = $request->all();
        $check = [];
        $checkTimeValid = true;
//        dd($billInfo);
//        exit();
        $cusInfo = $this->customerModel->getCusByPhoneVendor($this->VendorId,$billInfo['phone']);

        foreach($billInfo['services'] as $service){

            $user_name = $this->userModel->getUserNameInfoById($service['employeeId'],$this->VendorId);
            $service_name = $this->serviceModel->getServicesNameByIdandVendor($this->VendorId,$service['serviceId']);


            $date_start1 = date('yy-m-d', $service['timeRange']['start']);
            $time_start1 = date('H:i:s', $service['timeRange']['start']);
            $time_end1 = date('H:i:s', $service['timeRange']['end']);
            $bookingturn2 = $this->ScheduleTask->getBookingTurnForChecking($this->VendorId, $user_name[0]['id'], $time_start1, $time_end1,$date_start1);
            if(sizeof($bookingturn2)>0){
                $checkTimeValid = false;
            }

        }

        if($checkTimeValid == true){
            foreach($billInfo['services'] as $service){
                $user_name = $this->userModel->getUserNameInfoById($service['employeeId'],$this->VendorId);
                $service_name = $this->serviceModel->getServicesNameByIdandVendor($this->VendorId,$service['serviceId']);
                $date_start1 = date('yy-m-d', $service['timeRange']['start']);
                $time_start1 = date('H:i:s', $service['timeRange']['start']);
                $time_end1 = date('H:i:s', $service['timeRange']['end']);
                $this->ScheduleTask->confirmCheckin($this->VendorId,$cusInfo[0]['id'],$service_name[0]['id'],$user_name[0]['id'],$time_start1,$time_end1,$date_start1);
            }

//            $this->ScheduleTask->confirmBooking($this->VendorId,$cusId2,$service_name[0]['id'],$user_name[0]['id'],$time_start1,$time_end1,$date_start1);
            $response['code'] = 0;
            $response['start_time'] = $time_start1;
            $response['date'] = $date_start1;
            $response['end_time'] = $time_end1;
            return $response;
        }
        else{
            $response['start_time'] = $time_start1;
            $response['date'] = $date_start1;
            $response['end_time'] = $time_end1;
            $response['code'] = 1;
            return $response;
        }

    }

    function confirmCheckoutWaitlist(Request $request){
        $billInfo  = $request->all();
        $deposit = $billInfo['invoice']['deposit'];
        $totalDiscount = 0;
        $check = [];
        $total = $billInfo['invoice']['total'];

        foreach ($billInfo['invoice']['services'] as $ser){
            if(!isset($ser['service_id'])){
                $ser['service_id'] = '';
                $ser['employee_id'] ='';
        
            }
            $totalDiscount = $totalDiscount +$ser['discount'];
            $this->InternalTransaction->saveTransactionForCheckout($this->VendorId,$billInfo['id'],
                $billInfo['invoice']['id'],$ser['discount'],$ser['service_id'], $ser['employee_id'],$billInfo['paymentType'],
                'split_bill',$billInfo['note'],$ser['price']);

            $this->ScheduleTask->deleteTaskForWaitlistCheckout($this->VendorId, $billInfo['id'],$ser['service_id'],$ser['employee_id']);

        }
        $this->InternalTransaction->saveTransactionForCheckout($this->VendorId,$billInfo['id'],
            $billInfo['invoice']['id'],$totalDiscount,'','',$billInfo['paymentType'],'summary_bill',$billInfo['note'],$total);
//        $this->InternalTransaction->saveTransactionForCheckout($this->VendorId,$billInfo['id'],$billInfo['invoice']['id'],)
        $return['code'] = 0;

       return $return;
    }

}
