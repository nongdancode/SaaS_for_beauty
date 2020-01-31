<?php
/**
 * Created by IntelliJ IDEA.
 * User: hoang
 * Date: 3/27/2017
 * Time: 10:32 AM
 */
namespace App\Lib;

class DateTimeUtils
{
    private static function getDayArrEveryTiming($fromDate, $toDate, $timing)
    {
        $return = [];
        while ($fromDate < $toDate) {
            $return[] = $fromDate;
            $fromDate = self::incrementDay($fromDate, $timing);
        }
        if (!in_array($toDate, $return)) $return[] = $toDate;

        return $return;
    }

    private static function getDayArrEveryWeek($fromDate, $toDate)
    {
        $return = [];
        $getDate = self::getEndOfWeek($fromDate);
        while (true) {
            $tt = floatval(strtotime($getDate)) - floatval(strtotime($toDate));
            if ($tt > 0) break;
            $return[] = $getDate;

            $t1 = self::incrementDay($getDate, 1);
            $getDate = self::getEndOfWeek($t1);

        }
        if (!in_array($toDate, $return)) $return[] = $toDate;
        return $return;
    }

    private static function getDayArrEveryMonth($fromDate, $toDate)
    {
        $return = [];
        $getDate = DateTimeUtils::getEndOfMonth($fromDate);

        while (true) {
            $tt = floatval(strtotime($getDate)) - floatval(strtotime($toDate));
            if ($tt > 0) break;
            $return[] = $getDate;

            $t1 = DateTimeUtils::incrementDay($getDate, 1);
            $getDate = DateTimeUtils::getEndOfMonth($t1);
        }
        if (!in_array($toDate, $return)) $return[] = $toDate;
        return $return;
    }

    public static function getEndOfWeek($getDay)
    {
        $ts = strtotime($getDay);
        $end = (date('w', $ts) == 0) ? $ts : strtotime('next sunday', $ts);
        $endOfWeek = date('Y-m-d', $end);
        return $endOfWeek;
    }

    public static function getBeginOfWeek($getDay)
    {
        $ts = strtotime($getDay);
        $begin = (date('w', $ts) == 1) ? $ts : strtotime('last Monday', $ts);
        $beginOfWeek = date('Y-m-d', $begin);
        return $beginOfWeek;
    }

    public static function getEndOfMonth($getDay)
    {
        $endOfMonth = date("Y-m-t", strtotime($getDay));
        return $endOfMonth;
    }

    public static function getDayArrByTiming($fromDate, $toDate, $timing)
    {
        if ($fromDate > $toDate)
            return [];

        switch ($timing) {
            case "w":
                $return = self::getDayArrEveryWeek($fromDate, $toDate);
                break;
            case "m":
                $return = self::getDayArrEveryMonth($fromDate, $toDate);
                break;
            default:
                $return = self::getDayArrEveryTiming($fromDate, $toDate, $timing);
                break;
        }
        return $return;
    }

    public static function incrementDay($day, $numberOfIncrement)
    {
        $return = date('Y-m-d', strtotime("$numberOfIncrement day", strtotime($day)));
        return $return;
    }

    public static function formDateToDBDate($formDate)
    {
        return str_replace("/", "-", $formDate);
    }

    public static function DBDateToFormDate($dbDate)
    {
        return str_replace("-", "/", $dbDate);
    }

    public static function DBDateToHumanDate($dbDate, $notYear = true)
    {
        if ($notYear) {
            $return = date("d-M", strtotime($dbDate));
        } else {
            $return = date("d-M-Y", strtotime($dbDate));
        }
        return $return;
    }

    public static function getCurrentDate()
    {
        $return = date('Y-m-d', strtotime('today'));
        return $return;
    }

    public static function getCurrentDateTime()
    {
        $return = date('Y-m-d H:i:s');
        return $return;
    }

    public static function getYesterday()
    {
        $return = date('Y-m-d', strtotime('-1 days'));
        return $return;
    }

    public static function getStartOfWeek($day)
    {
        $dayNumber = date('w', strtotime($day));
        // return if is monday
        if ($dayNumber == 1) {
            $return = $day;
        } else {
            $return = date("Y-m-d", strtotime('last Monday', strtotime($day)));
        }
        return $return;
    }

    public static function getStartOfMonth($day)
    {
        return date("Y-m-01", strtotime($day));
    }

    public static function getLast48Weeks()
    {
        $currentDate = DateTimeUtils::getCurrentDate();
        $last48Weeks = DateTimeUtils::incrementDay($currentDate, -48 * 7);
        $dayArr = DateTimeUtils::getDayArrByTiming($last48Weeks, $currentDate, "w");
        $return = [];
        foreach ($dayArr as $day) {
            $date = new \DateTime($day);
            $week = $date->format("W");
            $return[$day] = "Week " . $week . " (" . $day . ")";
        }
        krsort($return);
        return $return;
    }

    public static function getLast12Months()
    {
        $currentDate = DateTimeUtils::getCurrentDate();
        $lastYear = DateTimeUtils::incrementDay($currentDate, -365);
        $dayArr = DateTimeUtils::getDayArrByTiming($lastYear, $currentDate, "m");
        $return = [];
        foreach ($dayArr as $day) {
            $date = new \DateTime($day);
            $month = $date->format("M");
            $return[$day] = $month . " (" . $day . ")";
        }
        krsort($return);
        return $return;
    }
}
