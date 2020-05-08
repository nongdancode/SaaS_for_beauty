<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use App\Lib\MyUtils;
use App\Model\BookingTurn;
use App\Model\Customer;
use App\Model\GroupService;
use App\Model\ScheduleTask;
use App\Model\ServicesVendor;
use App\Model\ShiftModel;
use App\Model\Transaction;
use App\Model\UserAdmin;
use App\Model\Vendor;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Lib\SMSTwillo;
use App\Lib\AuthorizePayment;
use App\Lib\DateTimeUtils;
use DateTime;
use DateTimeZone;
use function MongoDB\BSON\toJSON;
use Carbon\Carbon;

class AppointmentController extends Controller
{

    protected $requestBooking;
    protected $requestBooking2;
    protected $util;
    protected $fromDate;
    protected $toDate;
    protected $ServiceModel;
    protected $UserModel;
    protected $Twillo;
    protected $dateTimeUtil;
    protected  $message;
    protected $Customer;
    protected  $BookingTurn;
    protected $AuthorizePayment;
    protected $VendorId = 1;
    protected $Vendor;
    protected  $scheduleTask;
    protected  $services;
    protected $Transaction;
    protected $GroupService;
    protected $ShiftModel;

    public function __construct(Request $request)
    {
        $this->ServiceModel = new ServicesVendor();
        $this->Customer = new Customer();
        $this->UserModel = new UserAdmin();
        $this->Twillo = new SMSTwillo();
        $this->util = new MyUtils();
        $this->requestBooking = $request->all();
        $this->BookingTurn = new BookingTurn();
        $this->dateTime = new DateTime();
        $this->dateTimeUtil = new DateTimeUtils();
        $this->AuthorizePayment = new AuthorizePayment();
        $this->Vendor = new Vendor();
        $this->Transaction = new Transaction();
        $this->scheduleTask = new ScheduleTask();
        $this->GroupService = new GroupService();
        $this->ShiftModel = new ShiftModel();

        date_default_timezone_set('America/Chicago');
    }


    function getReadyServices()
    {

        $data = $this->ServiceModel->getAllServicesByVendor($this->VendorId);
        for($i =0 ; $i< sizeof($data);$i++){
           $groupService = $this->GroupService->getGroupForService($this->VendorId,$data[$i]['id']);
           foreach ($groupService as $g){
               $data[$i]['groupIds'][] = (int)$g['id'];
           }
        }

        return $this->util->returnHttps($data,0,'');


    }

    function listGroupService(){
        $data = $this->GroupService->listServiceGroup($this->VendorId);


        return $this->util->returnHttps($data,0,'');
//        return $data;


    }



    function getAllFromEmployee()
    {

        $data = $this->UserModel->getStaffByALlServicesVer2($this->VendorId);
         $nowday = date("Y-m-d");

        for ($i = 0; $i < sizeof($data); $i++) {
            $data[$i]['id'] = (int)$data[$i]['id'];


           $shifts =  $this->ShiftModel->listShiftForEmployee($this->VendorId,$data[$i]['id']);
           for($a= 0;$a <sizeof($shifts);$a ++){

               $data[$i]['available'][$a]['start'] =  strtotime($shifts[$a]['start']);
               $data[$i]['available'][$a]['end'] =  strtotime($shifts[$a]['end']);
           }

        }
        return $this->util->returnHttps($data,0,'');
//        return $data;
    }





    function confirmBooking()
    {
        $data  = $this->requestBooking;

        $price = 0;
        $services = [];
        $servicesReturn = [];
        $checkTimeValid = true;
        $priceHard = 20;


        for ($i = 0 ; $i < sizeof($data['services']);$i++ ){

            $user_name = $this->UserModel->getUserNameInfoById($data['services'][$i]['employeeId'],$this->VendorId);
            $service_name = $this->ServiceModel->getServicesNameByIdandVendor($this->VendorId,$data['services'][$i]['serviceId']);



            $services[$service_name[0]['name']]['start_time'] = $data['services'][$i]['timeRange']['start'];
            $services[$service_name[0]['name']]['end_time'] = $data['services'][$i]['timeRange']['end'];
            $services[$service_name[0]['name']]['staff'] = $user_name[0]['id'];
            $services[$service_name[0]['name']]['phone_staff'] = $user_name[0]['phone_number'];
            $services[$service_name[0]['name']]['price'] =  $service_name[0]['price'];

            $discontPrice =  $service_name[0]['price']/100*20;
            $servicesReturn[$service_name[0]['name']]['id'] = $service_name[0]['id'];


            $date_start1 = date('yy-m-d', $data['services'][$i]['timeRange']['start']);
            $time_start1 = date('H:i:s',$data['services'][$i]['timeRange']['start']);
            $time_end1 = date('H:i:s', $data['services'][$i]['timeRange']['end']);

            $price = $price + $discontPrice;


            $time1 =   $data['services'][$i]['timeRange']['start'];

            $bookingturn2 = $this->scheduleTask->getBookingTurnForChecking($this->VendorId, $user_name[0]['id'], $time_start1, $time_end1,$date_start1);
            if(sizeof($bookingturn2)>0){
                $checkTimeValid = false;
            }
        }
        $servicesReturn['price'] = $price;
        $servicesReturn2['data']['price'] = $priceHard;

        if($checkTimeValid == true){
//            $servicesReturn2['code']=0;
//            return \response( $servicesReturn2);
            return $this->util->returnHttps($data,0,'');
        }
        else{
            return $this->util->returnHttps('',1,'your service is not avaiable , please pick again');
//            $servicesReturn2['code']=1;
//            return \response($servicesReturn2);
//            return \response(  "error");
        }

    }

    function confirmCharge(){
        $payemnt = new AuthorizePayment();
        $data  = $this->requestBooking;
        $customer_name = $data['booking']['info']['name'];
        $customer_phone = $data['booking']['info']['phone'];
        $messagesForcus = '';
        $messagesForStaff='';
        $messagesForVendor='';
        $price = 0;
        $priceHard = 20;
        $services = [];
        $servicesReturn = [];
        $discountRate = 20;
        $key = $this->Vendor->getVendorAuthorizeKey($this->VendorId);
        $staffname = '';


        $login_key = $key[0]['key1'];
        $trans_key = $key[0]['key3'];
        $servicesReturn['price'] = $priceHard;
        $cardNumber = $data['payment']['cardNumber'];
        $cardEx = $data['payment']['cardExpiry'];
        $cardcvv = $data['payment']['cardCVV'];


        for ($i = 0; $i < sizeof($data['booking']['services']); $i++){

            $service_name = $this->ServiceModel->getServicesNameByIdandVendor($this->VendorId, $data['booking']['services'][$i]['serviceId']);

            $discontPrice = $service_name[0]['price'] / 100 * $discountRate;
            $servicesReturn[$service_name[0]['name']]['id'] = $service_name[0]['id'];
            $price = $price + $discontPrice;
        }

        $confirm = $payemnt->handleonlinepay($login_key, $trans_key, "", $cardNumber, $cardEx, $cardcvv,0.2);
//       $confirm = 'Ok';

        $code = $confirm->getMessages()->getResultCode();

        if ($code == 'Ok') {
            $this->Transaction->insertTransactionByVendor
            (substr($cardNumber,-5,4),'','Success',$data['payment']['cardName'],
                $priceHard,$this->VendorId,'deposit',$customer_phone,$confirm->getRefId());
            $date2 = date('m/d/Y h:i:s a', time());

            for ($i = 0; $i < sizeof($data['booking']['services']); $i++) {

                $user_name = $this->UserModel->getUserNameInfoById($data['booking']['services'][$i]['employeeId'], $this->VendorId);


                $service_name = $this->ServiceModel->getServicesNameByIdandVendor(1, $data['booking']['services'][$i]['serviceId']);


                $services[$service_name[0]['name']]['start_time'] = $data['booking']['services'][$i]['timeRange']['start'];
                $services[$service_name[0]['name']]['end_time'] = $data['booking']['services'][$i]['timeRange']['end'];
                $services[$service_name[0]['name']]['staff'] = $user_name[0]['id'];
                $services[$service_name[0]['name']]['phone_staff'] = $user_name[0]['phone_number'];
                $services[$service_name[0]['name']]['price'] = $service_name[0]['price'];




                $servicesReturn[$service_name[0]['name']]['id'] = $service_name[0]['id'];
                $price = $price + $discontPrice;
                $this->Customer->addCustomerByBooking($this->VendorId,$customer_phone, $customer_name, $priceHard, 5);

                $time1 = $data['booking']['services'][$i]['timeRange']['start'];
                $time2  = $this->dateTimeUtil->convertUnixTSToLocalTX($time1,'Y-m-d H:i:s');

                $datesql_start2 =  date("Y-m-d H:i:s", strtotime($time2));

                $time3 = $data['booking']['services'][$i]['timeRange']['end'];
                $time4  = $this->dateTimeUtil->convertUnixTSToLocalTX($time3,'Y-m-d H:i:s');

                $datesql_end2 =  date("Y-m-d H:i:s",strtotime($time4) );


                $s = $service_name[0]['name'];
                $s2 = $user_name[0]['name'];
                $staffphone = $user_name[0]['phone_number'];
                $cusId = $this->Customer->getCusByPhoneVendor($this->VendorId,$customer_phone);

                $cusId2 =$cusId[0]['id'];

                $date_start1 = date('yy-m-d',$data['booking']['services'][$i]['timeRange']['start']/1000);
                $time_start1 = date('H:i:s',$data['booking']['services'][$i]['timeRange']['start']/1000);
                $time_end1 = date('H:i:s', $data['booking']['services'][$i]['timeRange']['end']/1000);


                $this->scheduleTask->confirmBooking($this->VendorId,$cusId2,$service_name[0]['id'],$user_name[0]['id'],$time_start1,$time_end1,$date_start1);


                $messagesForcus = $messagesForcus . "  " . $s . ' with ' . $s2 . "  " . ' at ' . $time2;
                $messagesForStaff =      $messagesForStaff ." You have booking "  . "  at " . $time2  . " for service ". $s ;
                $messagesForVendor = $messagesForVendor . "  " . $s2 . " have booking "    . "  at: ". $time2 . " for service ". $s ;

            }


            $messagesForcus = "Welcome " . $customer_name  .  ".You book success with us:". '  ' .$messagesForcus  ;
            $this->Twillo->SendMessageByNumber( $messagesForcus, $customer_phone);
            $this->Twillo->SendMessageByNumber( $messagesForStaff, $staffphone);
            $this->Twillo->SendMessageByNumber( $messagesForVendor,'2814777810');
            $this->Twillo->SendMessageByNumber( $messagesForVendor,'8327744593');
            $response['code'] = 0;
            return $this->util->returnHttps($data,0,'');

        }
        else{
            return $this->util->returnHttps('',1,'your payment failed and not be charged');
        }


//       return \response($response);




    }




}
