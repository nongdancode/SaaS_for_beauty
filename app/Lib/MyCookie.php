<?php
/**
 * Created by IntelliJ IDEA.
 * User: hoang
 * Date: 4/4/2017
 * Time: 10:31 AM
 */
namespace App\Lib;

class MyCookie
{

    public static function set($key, $value, $expire = 60 * 60 * 24, $path= "/")
    {
        setcookie($key, $value, time() + $expire, $path);
    }

    public static function get($key, $defaultValue = "")
    {
        $return = $defaultValue;
        if (isset($_COOKIE[$key])) {
            $return = $_COOKIE[$key];
        }
        return $return;
    }
}
