<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use App\Lib\MyUtils;
use App\Model\ServicesVendor;
use App\Model\UserAdmin;
use Illuminate\Http\Request;


class AppointmentController extends Controller
{

    protected $requestBooking;
    protected $util;
    protected $fromDate;
    protected $toDate;
    protected $ServiceModel;
    protected $DataModel;

    public function __construct(Request $request)
    {

        $this->ServiceModel = new ServicesVendor();
        $this->util = new MyUtils();
        $this->DataModel = new UserAdmin();

        $this->requestBooking = $request->all();
    }


    function getReadyServices()
    {

        $data = $this->ServiceModel->getAllServicesByVendor(1);

        return $data;

    }

    function getAllFromEmployee()
    {

        $data = $this->DataModel->getStaffByAllServices(1);
        $data2 = json_decode(json_encode($data), true);


        for ($i = 0; $i < sizeof($data); $i++) {

            $subDay = $this->DataModel->getTurnDayOfEmployeeForBooking($data2[$i]['id'], $data2[$i]['service_id'], 1);
            $subDay2 = $this->util->decodeObjectStdJson($subDay);
            for ($a = 0; $a < sizeof($subDay); $a++) {
                $data2[$i]['available'][$subDay2[$a]['day2']] = $this->util->decodeObjectStdJson(

                    $this->DataModel
                        ->getAllEmployeeTurnInDayForBooking($data2[$i]['id'], $data2[$i]['service_id'], $subDay2[$a]['day1'], 1));


            }

        }


        return $data2;
    }

    function confirmBooking()
    {
        return $this->requestBooking;
    }




}
