<?php
/**
 * Created by IntelliJ IDEA.
 * User: letua
 * Date: 2/24/2020
 * Time: 9:53 PM
 */

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


class CheckinController extends Controller
{

    protected $UserModel ;
    protected $VendorId = 1 ;
    protected $requestCheckin;
    protected $ScheduleTaskModel;
    protected $util;
    protected $Customer;




    public function __construct(Request $request)
    {
        $this->Customer = new Customer();
        $this->UserModel = new UserAdmin();
        $this->util = new MyUtils();
        $this->requestCheckin = $request->all();
        $this->ScheduleTaskModel = new ScheduleTask();

        date_default_timezone_set('America/Chicago');
    }

  function CustomerChecking(){
        $dataCus = $this->requestCheckin;
        $cusName = $dataCus['name'];
        $cusPhone = $dataCus['phone'];
        $CustomerData = $this->Customer->getCusByPhoneVendor($this->VendorId,$cusPhone);
        if(sizeof($CustomerData) > 0 && $CustomerData[0]['birthday'] != null ){
            $this->Customer->updateNameCustomer($this->VendorId,$cusPhone,$cusName);
            $CustomerData = $this->Customer->getCusByPhoneVendor($this->VendorId,$cusPhone);
            $CustomerDataOFBooking = $this->ScheduleTaskModel->getCusBooking($this->VendorId,$CustomerData[0]['id']);
            $CustomerId = $CustomerData[0]['id'];
            $visit_count = $CustomerData[0]['visit_count']+1;
            $this->Customer->updateVisitCountForCustomer($this->VendorId,$CustomerId,$visit_count);
            if(sizeof($CustomerDataOFBooking) >0){
                foreach($CustomerDataOFBooking as $cus){
                    $this->ScheduleTaskModel->updateCusBooking($this->VendorId,$cus['cus_id']);
                }
            }else{
                $this->ScheduleTaskModel->addCusCheckin($this->VendorId,$CustomerId);
            }
            return   $this->util->returnHttps($CustomerData,0,'') ;
        }
        if($dataCus['birthday']!= null){
            $cusDob = date('yy-m-d', $dataCus['birthday']);
        }else{
            $cusDob = null;
        }

        if(sizeof($CustomerData) == 0 || $CustomerData[0]['birthday'] == null){

            $this->Customer->addCustomerCheckin($this->VendorId,$cusPhone,$cusName,$cusDob);
            $CustomerData = $this->Customer->getCusByPhoneVendor($this->VendorId,$cusPhone);
            $CustomerDataOFBooking = $this->ScheduleTaskModel->getCusBooking($this->VendorId,$CustomerData[0]['id']);
            $CustomerId = $CustomerData[0]['id'];
            if($cusDob  != ''){
                $visit_count = $CustomerData[0]['visit_count']+1;
            }
            else{
                $visit_count = 0;
            }
            $this->Customer->updateVisitCountForCustomer($this->VendorId,$CustomerId,$visit_count);
            if(sizeof($CustomerDataOFBooking) >0){
                foreach($CustomerDataOFBooking as $cus){
                    $this->ScheduleTaskModel->updateCusBooking($this->VendorId,$cus['cus_id']);
                }
            }else{
                $this->ScheduleTaskModel->addCusCheckin($this->VendorId,$CustomerId);
            }
            return   $this->util->returnHttps($CustomerData,0,'') ;
        }

  }



}
