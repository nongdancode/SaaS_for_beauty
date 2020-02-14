<?php
/**
 * Created by IntelliJ IDEA.
 * User: letua
 * Date: 1/27/2020
 * Time: 7:57 AM
 */

namespace App\Http\Controllers\System;


use App\DataTables\SmsDataTable;
use App\Http\Controllers\Controller;
use App\Lib\MyUtils;
use App\Lib\SMSTwillo;
use App\Model\Customer;
use Illuminate\Http\Request;

class SmsController extends Controller
{
    protected $util;
    protected $fromDate;
    protected $toDate;
    protected $commonModel;
    protected $TwilloSMS;
    protected $SMSDatatable;

    function __construct(Request $_request)
    {

        $this->commonModel = new Customer();
        $this->util = new MyUtils();
        $this->TwilloSMS = new SMSTwillo();


//        MySession::set("fromDate", $this->fromDate);
//        MySession::set("toDate", $this->toDate);
//        MySession::set("gameCode", "luckyWingabar");

    }

    /**
     *
     */
    function showSupplyCustomerPhone()
    {
        $flect = $this->commonModel->getCustomerPhoneByVendor(1);

        $list_num = ['8327744593', '3463290285', '8583567673'];
        $content = 'TheLashSupply.com get FREE SHIPPING & 15% Discount for New 1st Customer code “FIRSTCUSTOMERS” - Order Now: (346) 329 0285 -   Wholesale/ Retail & Private Label';

//        $flect2 = $this->util->decodeJson($flect);
//        $this->TwilloSMS->SendMessageByList($content,$list_num);


//        $params = [
//
//            'name' => $flect2['name'],
//             'phone_number'=>$flect2['phone_number']
//        ];


//
//
//    return view('admin.sms_sending', ['data'=>json_encode($flect)]);
//
//        return view('admin.sms_sending2',['data'=>$flect]);
        return ['data' => $flect];


    }

//    function sendSMSbyOnePhoneNumber($message,$phone_number){
//      $this->TwilloSMS->SenMessageByNumber($message,$phone_number);
//    }
//


    function getCustomerByvendor()
    {
        $flect = $this->commonModel->getCustomerPhoneByVendor(1);


//        $datatable = datatables()->of($flect)
//            ->addColumn('action','<input type="checkbox" name="selected_users[]" value="{{ $phone_number }}">')
//
//
//
//            ->make(true);


        return $flect;
    }

    /**
     * @param $list_num
     * @param $content
     * @throws \Twilio\Exceptions\ConfigurationException
     * @throws \Twilio\Exceptions\TwilioException
     */
    function sendMessage($list_num, $content)
    {
//        $list_num = ['8327744593','3463290285','8583567673'];
//        $content = 'TheLashSupply.com get FREE SHIPPING & 15% Discount for New 1st Customer code “FIRSTCUSTOMERS” - Order Now: (346) 329 0285 -   Wholesale/ Retail & Private Label';

        try {
            $this->TwilloSMS->SendMessageByList($content, $list_num);
        } //catch exception
        catch (Exception $e) {
            echo 'Message: ' . $e->getMessage();
        }


    }

    function test(SmsDataTable $dataTable)
    {


        return $dataTable->render('admin.sms_sending3');


    }


}
