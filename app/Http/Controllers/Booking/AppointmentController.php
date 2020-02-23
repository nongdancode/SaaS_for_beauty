<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use App\Lib\MyUtils;
use App\Model\BookingTurn;
use App\Model\Customer;
use App\Model\ScheduleTask;
use App\Model\ServicesVendor;
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

    public function __construct(Request $request,Response  $input)
    {

        $this->ServiceModel = new ServicesVendor();
        $this->Customer = new Customer();

        $this->UserModel = new UserAdmin();
        $this->Twillo = new SMSTwillo();
        $this->util = new MyUtils();
        $this->requestBooking = $request->all();
        $this->BookingTurn = new BookingTurn();

        $this->requestBooking2 = $input->content();
        $this->dateTime = new DateTime();
        $this->dateTimeUtil = new DateTimeUtils();
        $this->AuthorizePayment = new AuthorizePayment();

        $this->Vendor = new Vendor();

        $this->scheduleTask = new ScheduleTask();


    }


    function getReadyServices()
    {

        $data = $this->ServiceModel->getAllServicesByVendor(1);

        return $data;

    }

    function getAllFromEmployee()
    {

        $data = $this->UserModel->getStaffByAllServices(1);



        for ($i = 0; $i < sizeof($data); $i++) {

            $subDay = $this->UserModel->getTurnDayOfEmployeeForBooking($data[$i]['id'], $data[$i]['service_id'], $this->VendorId);

            for ($a = 0; $a < sizeof($subDay); $a++) {
                $data[$i]['available'][$subDay[$a]['day2']] =

                    $this->UserModel
                        ->getAllEmployeeTurnInDayForBooking($data[$i]['id'], $data[$i]['service_id'], $subDay[$a]['day1'], 1);


            }

        }


        return $data;
    }

    function confirmBooking()
    {
        $bookingturn = new BookingTurn();
        $data  = $this->requestBooking;

        $price = 0;
        $services = [];
        $servicesReturn = [];
        $checkTimeValid = false;
        $bookingturn2 = '';




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
//            $time2  = $this->dateTimeUtil->convertUnixTSToLocalTX($time1,'d/m/Y H:i:s');

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
            $servicesReturn2['code']=1;
            return \response($servicesReturn2['code']);
//            return \response(  "error");
        }


    }

    function confirmCharge(){
        $payemnt = new AuthorizePayment();
        $data  = $this->requestBooking;
        $vendor = $this->Vendor;
        $customer_name = $data['booking']['info']['name'];
        $customer_phone = $data['booking']['info']['phone'];
        $messages = '';
        $price = 0;
        $services = [];
        $servicesReturn = [];
        $key = $this->Vendor->getVendorAuthorizeKey($this->VendorId);


        $login_key = $key[0]['key1'];
        $trans_key = $key[0]['key3'];
        $servicesReturn['price'] = $price;
        $cardNumber = $data['payment']['cardNumber'];
        $cardEx = $data['payment']['cardExpiry'];
        $cardcvv = $data['payment']['cardCVV'];

        $confirm = $payemnt->handleonlinepay($login_key, $trans_key, "", $cardNumber, $cardEx, $cardcvv, 0.2);


        if ($confirm->getResultCode() == 'Ok') {
            $this->Customer->addCustomerByBooking($customer_phone, $customer_name, $price, 5);
            for ($i = 0; $i < sizeof($data['booking']['services']); $i++) {

                $user_name = $this->UserModel->getUserNameInfoById($data['booking']['services'][$i]['employeeId'], $this->VendorId);


                $service_name = $this->ServiceModel->getServicesNameByIdandVendor(1, $data['booking']['services'][$i]['serviceId']);



                $services[$service_name[0]['name']]['start_time'] = $data['booking']['services'][$i]['timeRange']['start'];
                $services[$service_name[0]['name']]['end_time'] = $data['booking']['services'][$i]['timeRange']['end'];
                $services[$service_name[0]['name']]['staff'] = $user_name[0]['id'];
                $services[$service_name[0]['name']]['phone_staff'] = $user_name[0]['phone_number'];
                $services[$service_name[0]['name']]['price'] = $service_name[0]['price'];

                $discontPrice = $service_name[0]['price'] / 100 * 15;


                $servicesReturn[$service_name[0]['name']]['id'] = $service_name[0]['id'];
                $price = $price + $discontPrice;


                $time1 = $data['booking']['services'][$i]['timeRange']['start'];
                $time2  = $this->dateTimeUtil->convertUnixTSToLocalTX($time1,'Y-m-d H:i:s');
//                $datesql_start1 =  strtotime($time2);
                $datesql_start2 =  date("Y-m-d H:i:s", strtotime($time2));

                $time3 = $data['booking']['services'][$i]['timeRange']['end'];
                $time4  = $this->dateTimeUtil->convertUnixTSToLocalTX($time3,'Y-m-d H:i:s');
//                $datesql_end1 = strtotime($time4);
                $datesql_end2 =  date("Y-m-d H:i:s",strtotime($time4) );


                $s = $service_name[0]['name'];
                $s2 = $user_name[0]['name'];

                $this->scheduleTask->confirmBooking($this->VendorId,$user_name[0]['id'],$service_name[0]['id'],$time1);


                $messages = $messages . "  " . $s . ' with ' . $s2 . "  " . ' at ' . $time2;

            }
            $message = "Welcome " . $customer_name  .  ".You book success with us:". '  ' .$messages  ;

            $this->Twillo->SenMessageByNumber($message, $customer_phone);
            $response['code'] = 0;



        }
        else{
            $response['code'] = 1;
        }








       return \response($response);




    }




}
