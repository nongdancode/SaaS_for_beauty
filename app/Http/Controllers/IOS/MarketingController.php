<?php


namespace App\Http\Controllers\IOS;


use App\Lib\MyUtils;
use App\Lib\SMSTwillo;
use App\Model\ConfigVendorModel;
use App\Model\Customer;
use App\Model\CustomerIOS;
use Illuminate\Http\Request;
use Twilio\Exceptions\ConfigurationException;
use Twilio\Exceptions\TwilioException;

class MarketingController
{
    private $iosUser;
    private $VendorId = 2;
    private $util;
    private $config;
    protected $SMSUser;
    protected $customerModel;

    function __construct(Request $request){
        $this->util = new MyUtils();
        $this->iosUser = new CustomerIOS();
        $this->customerModel = new Customer();
        $this->config = new ConfigVendorModel();
        $this->TwilloSMS = new SMSTwillo();
        $this->SMSUser = $request->getContent();
    }
    function sendSMSForMkt(Request $request){
        $data = $request ->all();
//        $data = $this ->util->decodeJson($this->SMSUser);
        $nums = [];
        for($i = 0 ; $i < sizeof($data['customerIds']);$i++){
            $cus_phone = $this->customerModel->getCustomerByIdVendor($data['customerIds'][$i],$this->VendorId);

            try {
                $this->TwilloSMS->SendMessageByNumber($data['message'], $cus_phone[0]['phone_number']);

            } catch (ConfigurationException $e) {
                return $this->util->returnHttps( $e->getMessage(),1,$e->getMessage());
            } catch (TwilioException $e) {
                return $this->util->returnHttps( $e->getMessage(),1,$e->getMessage());
            }

        }
//        $return['code'] = 0;



        return $this->util->returnHttps( '',0,'');
    }
    function sendMMSForMkt(Request $request){
        $data = $request ->all();

        for($i = 0 ; $i < sizeof($data['customerIds']);$i++){

            $media = $data['images'];
            $message = $data['message'];

            $cus_phone = $this->customerModel->getCustomerByIdVendor($data['customerIds'][$i],$this->VendorId);
            try {
                $this->TwilloSMS->SendMMSbyNumber($message, $cus_phone[0]['phone_number'], $media);

            } catch (ConfigurationException $e) {
                return $this->util->returnHttps( $e->getMessage(),1,$e->getMessage());
            } catch (TwilioException $e) {
                return $this->util->returnHttps( $e->getMessage(),1,$e->getMessage());
            }


        }
        return $this->util->returnHttps( '',0,'');

//        $return['code'] = 0;
//        return $return;

    }

}
