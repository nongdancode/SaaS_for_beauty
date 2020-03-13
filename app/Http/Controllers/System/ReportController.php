<?php
/**
 * Created by IntelliJ IDEA.
 * User: letua
 * Date: 2/12/2020
 * Time: 9:39 AM
 */

namespace App\Http\Controllers\System;
use App\Http\Controllers\Controller;
use App\Lib\MyUtils;

use App\Model\Customer;
use App\Model\Transaction;
use Illuminate\Http\Request;

class ReportController  extends Controller
{

    protected $customerModel;
    protected $paymentModel;
    function __construct(Request $request)
    {

        $this->customerModel = new Customer();
        $this->paymentModel = new Transaction();
        date_default_timezone_set('America/Chicago');




//        MySession::set("fromDate", $this->fromDate);
//        MySession::set("toDate", $this->toDate);
//        MySession::set("gameCode", "luckyWingabar");

    }

    function apiCustomerReportByPieChart(){
        $data = $this ->customerModel->getCustomerByDemandandTimeSteamp(120);
        return $data ;
    }

    function apiPaymentReportByPieChart(){
        $data = $this-> paymentModel-> getTransactionByVendorBytimStamp(1,150);
        return $data;
    }

    function apiPaymentPiechartByStatusTransaction()
    {


    }


}
