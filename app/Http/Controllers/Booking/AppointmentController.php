<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use App\Lib\MyUtils;
use App\Model\ServicesVendor;
use App\Model\UserAdmin;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Lib\SMSTwillo;
use App\Lib\DateTimeUtils;
use DateTime;
use DateTimeZone;


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
    protected $dateTime;

    public function __construct(Request $request,Response  $input)
    {

        $this->ServiceModel = new ServicesVendor();

        $this->UserModel = new UserAdmin();
        $this->Twillo = new SMSTwillo();
        $this->util = new MyUtils();
        $this->requestBooking = $request->all();
        $this->requestBooking2 = $input->content();
        $this->dateTime = new DateTime();
        $this->dateTimeUtil = new DateTimeUtils();
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

        $data  = $this->requestBooking;
        $customer_name = $data['info']['name'];
        $customer_phone = $data['info']['phone'];
        $messages = '';

        for ($i = 0 ; $i < sizeof($data['services']);$i++ ){

            $user_name = $this->UserModel->getUserNameInfoById($data['services'][$i]['employeeId'],1);
            $user_name2 = $this->util->decodeObjectStdJson($user_name );

            $service_name = $this->ServiceModel->getServicesNameByIdandVendor(1,$data['services'][$i]['serviceId']);
            $service_name2 = $this->util->decodeObjectStdJson($service_name );

            $time1 =   $data['services'][$i]['timeRange']['start'];
            $time2 =  $time1 = $this->dateTimeUtil->convertUnixTSToLocalTX($time1,'d/m/Y H:i:s');

            $s = $service_name2[0]['name'];
            $s2 = $user_name2[0]['name'];


            $messages =  $messages .    "  " . $s . " with " . $s2  . "  " . " at " . $time2;


        }


        $message = "Welcome " . $customer_name  .  ".You book success with us:". '  ' .$messages  ;
        $sendMessage =  $this->Twillo->SenMessageByNumber($message,$customer_phone);





        return $sendMessage;

    }




}
