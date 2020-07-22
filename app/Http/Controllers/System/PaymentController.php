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
use App\Model\InternalTransaction;
use App\Model\Transaction;
use Illuminate\Http\Request;
class PaymentController extends Controller
{

    protected $util;
    protected $transactionModel;
    protected $vendorId = 1;
    protected $InternalTransaction;
    protected $Twillo;
    function __construct(Request $request)
    {


        $this->util = new MyUtils();
        $this->transactionModel = new Transaction();
        $this->InternalTransaction = new InternalTransaction();
        $this->Twillo = new SMSTwillo();
        date_default_timezone_set('America/Chicago');


    }
     function getBillTransactionByVendor(){
        $data = $this->InternalTransaction->listBillTransaction($this->vendorId);
        $deposit = 0;
        $tax = 10;
        $return = [];
         $aboutInfo['companyName']='The lash supply';
         $aboutInfo['phone'] = '8327744593';
         $address['streetAddress'] = '250 Bellard';
         $address['city'] = "Houston";
         $address['state'] = "Texas";
         $aboutInfo['address'] = $address;

        for($i = 0;$i< sizeof($data);$i++){

            $return[$i]['type'] = $data[$i]['type_transaction'];
            $return[$i]['id'] = $data[$i]['id'];
            $return[$i]['invoice']['id'] = $data[$i]['invoice_number'];
            $return[$i]['created'] = strtotime($data[$i]['created_at'])*1000;
            $return[$i]['invoice']['deposit'] = $deposit;
            $return[$i]['invoice']['tax'] = $tax;
            $return[$i]['invoice']['total'] = $data[$i]['total'];

            $return[$i]['invoice']['about'] = $aboutInfo;
            $return[$i]['invoice']['about']['customer']['name'] = $data[$i]['customer_name'];
            $return[$i]['invoice']['about']['customer']['phone'] = $data[$i]['customer_phone'];

            $billparts = $this->InternalTransaction->listPartBillTransaction($this->vendorId,$data[$i]['invoice_number']);

            for($a=0 ;$a<sizeof($billparts) ;$a++){
                $return[$i]['invoice']['services'][$a]['name'] = $billparts[$a]['service_name'];
                $return[$i]['invoice']['services'][$a]['price'] = $billparts[$a]['service_price'];
                $return[$i]['invoice']['services'][$a]['discount'] = $billparts[$a]['discount'];

            }

        }

        return $this->util->returnHttps($return,0,'');
     }

    function sendBillSMS(Request $request){
       $info = $request->all();
       $cusName = $info['about']['customer']['name'];
       $cusPhone = $info['about']['customer']['phone'];
       $totalAmount = $info['total'];

       $message = "Thank You ". $cusName." we received the payment amount: ". $totalAmount . " $";
       $this->Twillo->SendMessageByNumber($message,$cusPhone);

       $return['code'] = 0;
        return $this->util->returnHttps('',0,'');

    }





}
