<?php
/**
 * Created by IntelliJ IDEA.
 * User: hoang
 * Date: 5/3/2017
 * Time: 11:07 AM
 */
namespace App\Lib;

class MyConfig
{
    // admin users, don't allow {add, edit, delete} the admin user on frontend
    public static function getAdminList(){
        return ["tuong", "binh", "oanh"];
    }

    public static function getGlobalAccount(){
        return Constant::$GLOBAL_ACCOUNT;
    }
    public static function getColorList(){
        return ['#7CB5EC', '#F56954', '#00A65A', '#C07BCC', '#C3C66C', "#F08080",
            "#20B2AA", "#778899", "#9370DB", "#3CB371", "#191970", "#FF4500"];
    }

    public static function getAccountantUserList(){
        return ["viet", "minh.lam", "oanh", "tuong", "ha"];
    }
}
