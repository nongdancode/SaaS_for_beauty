<?php
/**
 * Created by IntelliJ IDEA.
 * User: letua
 * Date: 1/27/2020
 * Time: 7:57 AM
 */

namespace App\Http\Controllers\System;


use App\Lib\MyUtils;
use App\Model\MyModel;use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\UserAdmin;
use App\Lib\SMSTwillo;

class SmsController extends Controller
{
    protected $util;
    protected $fromDate;
    protected $toDate;
    protected $commonModel;
    protected $TwilloSMS;
    function __construct(Request $_request)
    {

        $this->commonModel = new UserAdmin();
        $this->util = new MyUtils();
        $this->TwilloSMS = new SMSTwillo();



//        MySession::set("fromDate", $this->fromDate);
//        MySession::set("toDate", $this->toDate);
//        MySession::set("gameCode", "luckyWingabar");

    }

    /**
     *
     */
    function showSupplyCustomerPhone(){
        $flect = $this->commonModel->getUserPhone(10,'',"CUS_SUPPLY");

        $list_num = ['8327744593','3463290285','8583567673'];
        $content = 'TheLashSupply.com get FREE SHIPPING & 15% Discount for New 1st Customer code “FIRSTCUSTOMERS” - Order Now: (346) 329 0285 -   Wholesale/ Retail & Private Label';

//        $flect2 = $this->util->decodeJson($flect);
//        $this->TwilloSMS->SendMessageByList($content,$list_num);


//        $params = [
//
//            'name' => $flect2['name'],
//             'phone_number'=>$flect2['phone_number']
//        ];





     return view('admin.sms_sending', $flect);




    }
}
