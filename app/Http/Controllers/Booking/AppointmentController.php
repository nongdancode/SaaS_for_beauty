<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use App\Lib\MyUtils;
use App\Model\BookingTurn;
use App\Model\Customer;
use App\Model\ServicesVendor;
use App\Model\UserAdmin;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Lib\SMSTwillo;
use App\Lib\AuthorizePayment;
use App\Lib\DateTimeUtils;
use DateTime;
use DateTimeZone;
use function MongoDB\BSON\toJSON;


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
    }


    function getReadyServices()
    {

        $data = $this->ServiceModel->getAllServicesByVendor(1);

        return $data;

    }

    function getAllFromEmployee()
    {

        $data = $this->UserModel->getStaffByAllServices(1);
        $data2 = json_decode(json_encode($data), true);


        for ($i = 0; $i < sizeof($data); $i++) {

            $subDay = $this->UserModel->getTurnDayOfEmployeeForBooking($data2[$i]['id'], $data2[$i]['service_id'], 1);
            $subDay2 = $this->util->decodeObjectStdJson($subDay);
            for ($a = 0; $a < sizeof($subDay); $a++) {
                $data2[$i]['available'][$subDay2[$a]['day2']] = $this->util->decodeObjectStdJson(

                    $this->UserModel
                        ->getAllEmployeeTurnInDayForBooking($data2[$i]['id'], $data2[$i]['service_id'], $subDay2[$a]['day1'], 1));


            }

        }


        return $data2;
    }

    function confirmBooking()
    {
        $bookingturn = new BookingTurn();
        $data  = $this->requestBooking;
        $customer_name = $data['info']['name'];
        $customer_phone = $data['info']['phone'];
        $messages = '';
        $price = 0;
        $services = [];
        $servicesReturn = [];
        $checkTimeValid = True;




        for ($i = 0 ; $i < sizeof($data['services']);$i++ ){

            $user_name = $this->UserModel->getUserNameInfoById($data['services'][$i]['employeeId'],1);
            $user_name2 = $this->util->decodeObjectStdJson($user_name );

            $service_name = $this->ServiceModel->getServicesNameByIdandVendor(1,$data['services'][$i]['serviceId']);
            $service_name2 = $this->util->decodeObjectStdJson($service_name );






            $services[$service_name2[0]['name']]['start_time'] = $data['services'][$i]['timeRange']['start'];
            $services[$service_name2[0]['name']]['end_time'] = $data['services'][$i]['timeRange']['end'];
            $services[$service_name2[0]['name']]['staff'] = $user_name2[0]['id'];
            $services[$service_name2[0]['name']]['phone_staff'] = $user_name2[0]['phone_number'];
            $services[$service_name2[0]['name']]['price'] =  $service_name2[0]['price'];

            $discontPrice =  $service_name2[0]['price']/100*15;



            $servicesReturn[$service_name2[0]['name']]['id'] = $service_name2[0]['id'];


            $price = $price + $discontPrice;


            $time1 =   $data['services'][$i]['timeRange']['start'];
            $time2  = $this->dateTimeUtil->convertUnixTSToLocalTX($time1,'d/m/Y H:i:s');
            $bookingturn2 = $bookingturn->getBookingTurnForChecking(1, $user_name2[0]['id'],$service_name2[0]['id'],$time2);
            $bookingturn3 =  $this->util->decodeObjectStdJson($bookingturn2 );

            if(sizeof($bookingturn3)>0){
                $checkTimeValid = false;
            }


//
//            $s = $service_name2[0]['name'];
//            $s2 = $user_name2[0]['name'];
//
//
//            $messages =  $messages .    "  " . $s . " with " . $s2  . "  " . " at " . $time2;

//            $this->Customer->addCustomerByBooking($customer_phone,$customer_name,$price,5);
//            $cus_add = $this->Customer->getCusByPhoneVendor(1,$customer_phone);
//            $cus_add2 =  $this->util->decodeObjectStdJson($cus_add );

//            $this->BookingTurn->confirmBookingTurn()
        }
        $servicesReturn['price'] = $price;



//
//        $message = "Welcome " . $customer_name  .  ".You book success with us:". '  ' .$messages  ;
//        $this->message = $message;
//        $this->services = $services;

        $servicesReturn2['data'] = $servicesReturn;

        if($checkTimeValid == true){
            $servicesReturn2['code'] = 1;
            return \response($servicesReturn2);
        }
        else{
            $servicesReturn2['code'] = -1;
            return $servicesReturn2['code'];
        }


        //change toconfirm later





//        return $services;
//        $sendMessage =  $this->Twillo->SenMessageByNumber($message,$customer_phone);



    }

    function confirmCharge(){
        $payemnt = new AuthorizePayment();
        $data  = $this->requestBooking;
        $customer_name = $data['booking']['info']['name'];
        $customer_phone = $data['booking']['info']['phone'];
        $messages = '';
        $price = 0;
        $services = [];
        $servicesReturn = [];
        $payemntinfo = $data['payment'];




        for ($i = 0 ; $i < sizeof($data['booking']['services']);$i++ ){

            $user_name = $this->UserModel->getUserNameInfoById($data['booking']['services'][$i]['employeeId'],1);
            $user_name2 = $this->util->decodeObjectStdJson($user_name );

            $service_name = $this->ServiceModel->getServicesNameByIdandVendor(1,$data['booking']['services'][$i]['serviceId']);
            $service_name2 = $this->util->decodeObjectStdJson($service_name );





            $services[$service_name2[0]['name']]['start_time'] = $data['booking']['services'][$i]['timeRange']['start'];
            $services[$service_name2[0]['name']]['end_time'] = $data['booking']['services'][$i]['timeRange']['end'];
            $services[$service_name2[0]['name']]['staff'] = $user_name2[0]['id'];
            $services[$service_name2[0]['name']]['phone_staff'] = $user_name2[0]['phone_number'];
            $services[$service_name2[0]['name']]['price'] =  $service_name2[0]['price'];

            $discontPrice =  $service_name2[0]['price']/100*15;



            $servicesReturn[$service_name2[0]['name']]['id'] = $service_name2[0]['id'];


            $price = $price + $discontPrice;


            $time1 =   $data['booking']['services'][$i]['timeRange']['start'];
            $time2 =  $time1 = $this->dateTimeUtil->convertUnixTSToLocalTX($time1,'d/m/Y H:i:s');

            $s = $service_name2[0]['name'];
            $s2 = $user_name2[0]['name'];


            $messages =  $messages .    "  " . $s . " with " . $s2  . "  " . " at " . $time2;

//            $this->Customer->addCustomerByBooking($customer_phone,$customer_name,$price,5);
//            $cus_add = $this->Customer->getCusByPhoneVendor(1,$customer_phone);
//            $cus_add2 =  $this->util->decodeObjectStdJson($cus_add );

//            $this->BookingTurn->confirmBookingTurn()
        }
        $servicesReturn['price'] = $price;



//
        $message = "Welcome " . $customer_name  .  ".You book success with us:". '  ' .$messages  ;



//      return  $servicesInfo;



    }




}
