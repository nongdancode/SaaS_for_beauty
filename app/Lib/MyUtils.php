<?php
/**
 * Created by IntelliJ IDEA.
 * User: hoang
 * Date: 3/16/2017
 * Time: 3:28 PM
 */
namespace App\Lib;

use Illuminate\Support\Facades\App;

class MyUtils
{
    public static function numberFormat($number)
    {
        $return = $number;
        if ($number != "" && is_numeric($number)) {
            if (strpos($number, ".") !== false) {
                $f = ($number < 1) ? 4 : 2;
                $return = number_format($number, $f);
            } else if (strpos($number, ",") === false and strpos($number, "%") === false) {
                $return = number_format($number);
            }
        }
        return $return;
    }

    public static function validateDate($date)
    {
        $d = \DateTime::createFromFormat('Y-m-d', $date);
        return $d && $d->format('Y-m-d') === $date;
    }


    public static function removeDayNotNeed(& $dayArr, $min)
    {
        $willRemove = array();
        for ($i = 0; $i < count($dayArr); $i++) {
            if ($dayArr[$i] < $min) {
                $willRemove[] = $i;
            }
        }
        if (count($willRemove) > 3) {
            for ($i = 0; $i < count($willRemove); $i++) {
                unset($dayArr[$i]);
            }
        }
        $dayArr = array_values($dayArr);
        sort($dayArr);
    }





    public static function randomString($length = 10)
    {
        return substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);
    }

    public static function keyArrayToIndexArray($keyArr, $keyNeed)
    {
        $rows = array();
        self::arrayToRow($keyArr, $rows, $keyNeed);
        $return = $rows;
        return $return;
    }



    public static function decodeJson($json){
        $j2 = json_decode($json, true);
        return $j2;
    }

    public static  function decodeObjectStdJson($json)
    {
        $j2 = json_decode(json_encode($json), true);
        return $j2;
    }

    public function checkDuplicateTime(){

    }

    public function returnHttps($data,$code,$error){
      $return = [];
      $return['data'] = $data;
      $return['code'] = $code;
      $return['error'] = $error;
      return  $return;
    }

    public function returnIoss($data,$code,$error,$total){
        $return = [];
        $return['data'] = $data;
        $return['code'] = $code;
        $return['error'] = $error;
        $return['total'] = $total;
        return  $return;
    }
}
