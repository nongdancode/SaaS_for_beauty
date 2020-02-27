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

    public static function safeGet($d,$k,$_d="")
    {
        if (isset($d[$k])) {
            return $d[$k];
        }
        return $_d;
    }



    public static function UpCaseKpiCode($kpiCode, $removeTiming = false)
    {
        $timing = "";
        $return = strtoupper($kpiCode);
        if (strpos($kpiCode, ".")) {
            list(, $timing) = explode(".", $kpiCode);
        }
        if ($removeTiming == false and $timing != "") {
            if ($timing == "w" || $timing == "m" || is_numeric($timing)) {
                $return = $return . " " . $timing;
            }
        }
        return $return;
    }

    public static function generateKpiCode($kpiList, $timings)
    {
        $return = array();
        foreach ($kpiList as $kpiCode) {
            foreach ($timings as $timing) {
                $return[$timing][] = $kpiCode . "." . $timing;
                $return['all'][] = $kpiCode . "." . $timing;
            }
        }
        return $return;
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

    public static function addDot($a, $b)
    {
        return $a . "." . $b;
    }

    public static function isAdmin($userName)
    {
        $userName = strtolower($userName);
        $adminList = MyConfig::getAdminList();
        if (in_array($userName, $adminList))
            return true;
        return false;
    }

    public static function logfile($message, $level = "INFO", $localOnly = false)
    {
        if (App::environment('local')) {
            $path = "C:\\kpi-tool.log";
            $enterLine = "\r\n";
        } else {
            if ($localOnly === true) {
                return;
            }
            $enterLine = "\n";
            $path = "/tmp/kpi-tool.log";
        }
        $currentTime = DateTimeUtils::getCurrentDateTime();
        $log = $currentTime . " -- " . $level . " -- " . $message . $enterLine;
        file_put_contents($path, $log, FILE_APPEND);
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

    private static function arrayToRow($array, & $rows, $keyNeed, $row = array())
    {
        foreach ($array as $key => $value) {
            if (gettype($value) == "array") {
                $row[] = $key;
                self::arrayToRow($value, $rows, $keyNeed, $row);
                unset($row[count($row) - 1]);
                $row = array_values($row);
            } else {
                for ($i = 0; $i < count($keyNeed); $i++) {
                    $v = isset($array[$keyNeed[$i]]) ? $array[$keyNeed[$i]] : "";
                    $row[] = $v;
                }
                $rows[] = $row;
                break;
            }
        }
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
}
