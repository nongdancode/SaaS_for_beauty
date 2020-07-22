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
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class MarketingController extends Controller
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
        date_default_timezone_set('America/Chicago');


    }

    function flectCustomerForMarketing()
    {
        $cus1 = $this->customerModel->getCustomerByDemand(1000,$this->VendorId);

        return $this->util->returnHttps( $cus1,0,'');

    }

    function sendSMSForMkt(){

        $data = $this ->util->decodeJson($this->SMSUser);
        $nums = [];
        for($i = 0 ; $i < sizeof($data['customerIds']);$i++){
          $cus_phone = $this->customerModel->getCustomerByIdVendor($data['customerIds'][$i],$this->VendorId);

          $this->TwilloSMS->SendMessageByNumber($data['message'],$cus_phone[0]['phone_number']);
//
//          print($cus_phone2[0]['phone_number']);
//            exit();
        }
//        $return['code'] = 0;
        return $this->util->returnHttps( '',0,'');


//          return $this->TwilloSMS->SendMessageByList($data['message'],$nums);
    }
    function sendMMSForMkt(Request $request){
        $data = $request ->all();

      for($i = 0 ; $i < sizeof($data['customerIds']);$i++){

          $media = $data['images'];
          $message = $data['message'];

          $cus_phone = $this->customerModel->getCustomerByIdVendor($data['customerIds'][$i],$this->VendorId);
          $this->TwilloSMS->SendMMSbyNumber($message,$cus_phone[0]['phone_number'],$media);


    }

//        $return['code'] = 0;
//        return $return;
        return $this->util->returnHttps( '',0,'');
    }


    function editCustomer(Request $request){
       $data = $request->all();

       $this->customerModel->editCustomer($this->VendorId,$data['id'],$data['phone_number'],$data['email'],$data['birthday'],$data['name']);
//        $return['code'] = 0;
//        return $return;
        return $this->util->returnHttps( '',0,'');
    }

    function bulkCustomerData(Request $request){
        $data = $request->all();
        $flagMessage = "Wrong format , please review your format below
        1: name:
        2: phone_number: 10 number only ( ex:8327744593)";

        $flagMessage2 = 'cannot exceed 200 records in one time';
        $flagCode =  true;
        $cusModel = $this->customerModel;
        $listKey =  array_keys($data[0]);
        if($listKey[0]!='name'|| $listKey[1]!='phone_number' ){
            $flagCode = false;
            return $this->util->returnHttps( '',1,$flagMessage);
        }

        $dataError ='';
        if(sizeof($data) >200){
            $flagCode = false;
            return $this->util->returnHttps( '',1,$flagMessage2);
        }

        if($flagCode == true){
            for($i = 0; $i< sizeof($data);$i++){

                if($data[$i]['name'] != null && $data[$i]['phone_number'] !=null &&preg_match('~^\d{10}$~', $data[$i]['phone_number']) ){
                    $cusModel->addCustomerBulk($this->VendorId,$data[$i]['name'],$data[$i]['phone_number']);
                }else{
                    $st = json_encode($data[$i]);
                    return $this->util->returnHttps( $data[$i],1,"record " . $st ." has wrong format");
                }
            }
        }

        if($flagCode == true){
            return $this->util->returnHttps( '',0,'');
        }else{
            return $this->util->returnHttps( $dataError,1,$flagMessage);
        }
    }




}
