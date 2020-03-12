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
    protected $Customer;
    protected $requestCheckin;
    protected $ScheduleTaskModel;


    public function __construct(Request $request)
    {
        $this->Customer = new Customer();
        $this->UserModel = new UserAdmin();
        $this->util = new MyUtils();
        $this->requestCheckin = $request->all();
        $this->ScheduleTaskModel = new ScheduleTask();
    }

  function CustomerChecking(){
        $dataCus = $this->requestCheckin;
        $cusName = $dataCus['name'];
        $cusPhone = $dataCus['phone'];

        $this->Customer->addCustomerCheckin($this->VendorId,$cusPhone,$cusName);

        $CustomerData = $this->Customer->getCusByPhoneVendor($this->VendorId,$cusPhone);
        $CustomerDataOFBooking = $this->ScheduleTaskModel->getCusBooking($this->VendorId,$CustomerData[0]['id']);
        $CustomerId = $CustomerData[0]['id'];



        if(sizeof($CustomerDataOFBooking) >0){
            foreach($CustomerDataOFBooking as $cus){
              $this->ScheduleTaskModel->updateCusBooking($this->VendorId,$cus['cus_id']);
            }
        }else{
            $this->ScheduleTaskModel->addCusCheckin($this->VendorId,$CustomerId);
        }


        $returnData['code'] = 0;

        return   $returnData;



  }

}
