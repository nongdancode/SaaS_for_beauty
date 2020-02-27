<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use App\Lib\MyUtils;
use App\Model\BookingTurn;
use App\Model\Customer;
use App\Model\ScheduleTask;
use App\Model\ServicesVendor;
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
    }


    function getReadyServices()
    {

        $data = $this->ServiceModel->getAllServicesByVendor($this->VendorId);

        return $data;

    }

    function getAllFromEmployee()
    {

        $data = $this->UserModel->getStaffByALlServicesVer2($this->VendorId);

        for ($i = 0; $i < sizeof($data); $i++) {

            $subDay = $this->UserModel->getTurnDayOfEmployeeForBooking($data[$i]['id'], $data[$i]['service_id'], $this->VendorId);

            for ($a = 0; $a < sizeof($subDay); $a++) {
                $data[$i]['available'][$subDay[$a]['day2']] =

                    $this->UserModel
                        ->getAllEmployeeTurnInDayForBooking($data[$i]['id'], $data[$i]['service_id'], $subDay[$a]['day1'], $this->VendorId);


            }

        }


        return $data;
    }





    function confirmBooking()
    {
        $data  = $this->requestBooking;

        $price = 0;
        $services = [];
        $servicesReturn = [];
        $checkTimeValid = false;


        for ($i = 0 ; $i < sizeof($data['services']);$i++ ){

            $user_name = $this->UserModel->getUserNameInfoById($data['services'][$i]['employeeId'],$this->VendorId);
            $service_name = $this->ServiceModel->getServicesNameByIdandVendor(1,$data['services'][$i]['serviceId']);



            $services[$service_name[0]['name']]['start_time'] = $data['services'][$i]['timeRange']['start'];
            $services[$service_name[0]['name']]['end_time'] = $data['services'][$i]['timeRange']['end'];
            $services[$service_name[0]['name']]['staff'] = $user_name[0]['id'];
            $services[$service_name[0]['name']]['phone_staff'] = $user_name[0]['phone_number'];
            $services[$service_name[0]['name']]['price'] =  $service_name[0]['price'];

            $discontPrice =  $service_name[0]['price']/100*15;
            $servicesReturn[$service_name[0]['name']]['id'] = $service_name[0]['id'];


            $price = $price + $discontPrice;


            $time1 =   $data['services'][$i]['timeRange']['start'];

            $bookingturn2 = $this->scheduleTask->getBookingTurnForChecking($this->VendorId, $user_name[0]['id'],$service_name[0]['id'],$time1);


            if(sizeof($bookingturn2)>0){
                $checkTimeValid = True;
            }
        }


        $servicesReturn['price'] = $price;
        $servicesReturn2['data']['price'] = $price;

        if($checkTimeValid == True){
            $servicesReturn2['code']=0;
            return \response( $servicesReturn2);
        }
        else{
            $servicesReturn2['code']=0;
            return \response($servicesReturn2);
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
        $services = [];
        $servicesReturn = [];
        $discountRate = 20;
        $key = $this->Vendor->getVendorAuthorizeKey($this->VendorId);
        $staffname = '';


        $login_key = $key[0]['key1'];
        $trans_key = $key[0]['key3'];
        $servicesReturn['price'] = $price;
        $cardNumber = $data['payment']['cardNumber'];
        $cardEx = $data['payment']['cardExpiry'];
        $cardcvv = $data['payment']['cardCVV'];


        for ($i = 0; $i < sizeof($data['booking']['services']); $i++){

            $service_name = $this->ServiceModel->getServicesNameByIdandVendor($this->VendorId, $data['booking']['services'][$i]['serviceId']);

            $discontPrice = $service_name[0]['price'] / 100 * $discountRate;
            $servicesReturn[$service_name[0]['name']]['id'] = $service_name[0]['id'];
            $price = $price + $discontPrice;


        }

        $confirm = $payemnt->handleonlinepay($login_key, $trans_key, "", $cardNumber, $cardEx, $cardcvv, $price);

        if ($confirm->getResultCode() == 'Ok') {
            $this->Transaction->insertTransactionByVendor
            (substr($cardNumber,-5,4),'','Success',$data['payment']['cardName'],
                $price,$this->VendorId,'deposit',$customer_phone);
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
                $this->Customer->addCustomerByBooking($this->VendorId,$customer_phone, $customer_name, $price, 5);

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

                $this->scheduleTask->confirmBooking($this->VendorId,$user_name[0]['id'],$service_name[0]['id'],$time1,$cusId2);


                $messagesForcus = $messagesForcus . "  " . $s . ' with ' . $s2 . "  " . ' at ' . $time2;
                $messagesForStaff =      $messagesForStaff ." You have booking at " . $time2  . " for service ". $s ;
                $messagesForVendor = $messagesForVendor . "  " . $s2 . " have booking at: ". $time2;

            }


            $messagesForcus = "Welcome " . $customer_name  .  ".You book success with us:". '  ' .$messagesForcus  ;
            $this->Twillo->SendMessageByNumber( $messagesForcus, $customer_phone);
            $this->Twillo->SendMessageByNumber( $messagesForStaff, $staffphone);
            $this->Twillo->SendMessageByNumber( $messagesForVendor,'3463290285');
//            $this->Twillo->SendMessageByNumber( $messagesForVendor,'8327744593');
            $response['code'] = 0;

        }
        else{
            $response['code'] = 1;
        }


       return \response($response);




    }




}
