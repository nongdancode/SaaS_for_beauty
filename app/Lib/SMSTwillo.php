<?php
/**
 * Created by IntelliJ IDEA.
 * User: letua
 * Date: 1/28/2020
 * Time: 12:57 PM
 */

namespace App\Lib;
use Twilio\Rest\Client;

class SMSTwillo
{
    protected $account_sid;
    protected $auth_token;
    protected $twilio_number;
    protected $client;

    function __construct()
    {

//        $this -> account_sid = getenv("TWILIO_SID");
//        $this -> auth_token = getenv("TWILIO_AUTH_TOKEN");
//        $this-> twilio_number = getenv("TWILIO_NUMBER");
//        $this-> client = new Client($this->account_sid, $this->auth_token);

    }

    /**
     * @param $content
     * @param $listNum
     * @throws \Twilio\Exceptions\ConfigurationException
     * @throws \Twilio\Exceptions\TwilioException
     */
    public function SendMessageByList($content, $listNum)
    {

        $account_sid = getenv("TWILIO_SID");
        $auth_token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_number = getenv("TWILIO_NUMBER");



        for ($x = 0; $x < $listNum; $x++) {
            $client = new Client($account_sid, $auth_token);
            $client->messages->create($listNum[$x],
                array('from' => $twilio_number, 'body' => $content));
        }
    }


    /**
     * @param $message
     * @param $number
     * @throws \Twilio\Exceptions\ConfigurationException
     * @throws \Twilio\Exceptions\TwilioException
     */
    public function SenMessageByNumber($message, $number)
    {
        $account_sid = getenv("TWILIO_SID");
        $auth_token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_number = getenv("TWILIO_NUMBER");
        $client = new Client($account_sid, $auth_token);
        $client->messages->create($number,
            array('from' => $twilio_number, 'body' => $message));
    }

}
