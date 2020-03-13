<?php
/**
 * Created by IntelliJ IDEA.
 * User: letua
 * Date: 2/12/2020
 * Time: 6:59 AM
 */

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Lib\MyUtils;
use App\Lib\SMSTwillo;
use App\Model\Customer;
use App\Model\Transaction;
use Illuminate\Http\Request;
class PaymentController extends Controller
{

    protected $util;
    protected $transactionModel;
    function __construct(Request $request)
    {


        $this->util = new MyUtils();
        $this->transactionModel = new Transaction();
        date_default_timezone_set('America/Chicago');


//        MySession::set("fromDate", $this->fromDate);
//        MySession::set("toDate", $this->toDate);
//        MySession::set("gameCode", "luckyWingabar");

    }
   function getTransactionByVendor(){
       $data = $this->transactionModel->getTransactionByVendor(1,100);

        return $data;
   }



}
