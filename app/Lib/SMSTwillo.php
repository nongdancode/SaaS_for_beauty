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


    public function SendMessageByList($content,$listNum){

        $account_sid = getenv("TWILIO_SID");
        $auth_token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_number = getenv("TWILIO_NUMBER");
        $client = new Client($account_sid, $auth_token);

        for ($x = 0; $x < $listNum; $x++) {
            $client->messages->create($listNum[$x],
                array('from' => $twilio_number, 'body' => $content));
        }


}
}
