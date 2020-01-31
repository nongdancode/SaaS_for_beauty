<?php
/**
 * Created by IntelliJ IDEA.
 * User: hoang
 * Date: 3/27/2017
 * Time: 3:28 PM
 */

namespace App\Lib;

MessageDisplay::init();

class MessageDisplay
{
    public static $kpiCodeDisplay = [];

    static function init()
    {
        $kpiName = array();
        $kpiName["au"] = "Active user";
        $kpiName["ad"] = "Active device";
        $kpiName["nu"] = "New user";
        $kpiName["nd"] = "New device";
        $kpiName["gr"] = "Gross revenue";
        $kpiName["pu"] = "Paying user";
        $kpiName["pd"] = "Paying device";
        $kpiName["ngr"] = "Gross revenue of NPU";
        $kpiName["npu"] = "New paying user";
        $kpiName["ndgr"] = "Gross revenue of NPD";
        $kpiName["npd"] = "New paying device";
        $kpiName["tpt"] = "Total payment transaction";

        $kpiName["arppu"] = "ARPPU";
        $kpiName["ARPU"] = "ARPU";

        self::$kpiCodeDisplay = $kpiName;
    }

    public static function getKpiName($kpiCode, $addTiming = true)
    {
        $rs = $kpiCode;
        $a = ['w' => 'weekly', 'm' => 'monthly'];
        $t = explode(".", $kpiCode);
        if (count($t) == 2) {
            if (isset(self::$kpiCodeDisplay[$t[0]])) {
                $n1 = self::$kpiCodeDisplay[$t[0]];
                $n2 = isset($a[$t[1]]) ? $a[$t[1]] : $t[1];
                if ($addTiming){
                    $rs = $n1 . " " . $n2;
                }else{
                    $rs = $n1;
                }
            }
        } else if (count($t) == 1) {
            if (isset(self::$kpiCodeDisplay[$t[0]])) {
                $rs = self::$kpiCodeDisplay[$t[0]];
            }
        }
        return $rs;
    }

    public static function getTimingDisplay()
    {
        return ['1' => 'Daily', 'w' => 'Weekly', 'm' => 'Monthly'];
    }

    public static function getXCategories($xCategoriesArr, $notYear = true)
    {
        $return = [];
        foreach ($xCategoriesArr as $value) {
            $return[] = DateTimeUtils::DBDateToHumanDate($value, $notYear);
        }
        return $return;
    }

    public static function getSubTitle($gameCode, $from, $to = "")
    {
        if($gameCode!=""){
            $gameCode = strtoupper($gameCode) . " - ";
        }
        if ($to != "") {
            $message = $gameCode . "From " . DateTimeUtils::DBDateToHumanDate($from) .
                " to " . DateTimeUtils::DBDateToHumanDate($to);
        } else {
            $message = $gameCode  . DateTimeUtils::DBDateToHumanDate($from);
        }

        return $message;
    }

    public static function nameSimpleFormat($nameRaw)
    {
        $convertChar = ["_", "-", "."];
        foreach ($convertChar as $char) {
            $nameRaw = str_replace($char, " ", $nameRaw);
        }
        $name = ucwords($nameRaw);
        return $name;
    }
}