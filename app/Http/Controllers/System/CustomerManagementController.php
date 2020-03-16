<?php


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

class CustomerManagementController extends Controller
{

    protected $vendorId = 1;
    protected $customerModel;




    function __construct(Request $request)
    {

        $this->customerModel = new Customer();
        $this->util = new MyUtils();
        $this->TwilloSMS = new SMSTwillo();


        date_default_timezone_set('America/Chicago');

    }

    function showCustomerHistory(Request $request){
        $cus_id = $request->id;
        $data = $this->customerModel->showCustomerHistory($this->vendorId,$cus_id);
        if(sizeof($data)>0){
            for ($i = 0 ; $i<sizeof($data);$i++){
                $data[$i]['count'] = (int)$data[$i]['count'];
            }
        }

        return $data;

    }

}
