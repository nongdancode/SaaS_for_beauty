<?php
/**
 * Created by IntelliJ IDEA.
 * User: hoang
 * Date: 3/27/2017
 * Time: 11:38 AM
 */
namespace App\Lib;
use App\Model\MTUserPermission;

session_start();
class MySession
{
    function __construct()
    {

    }

    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function get($key, $valueDefault = "")
    {
        if (isset($_SESSION[$key]))
            return $_SESSION[$key];
        return $valueDefault;

    }
    public static function getCurrentUserName(){
        return self::get("account_name");
    }

    public static function getCurrentGameCode(){
        return self::get("gameCode");
    }

}