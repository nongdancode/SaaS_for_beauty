<?php
/**
 * Created by IntelliJ IDEA.
 * User: letua
 * Date: 1/27/2020
 * Time: 7:07 AM
 */

namespace App\Model;
use App\Lib\DateTimeUtils;
use App\Lib\MyUtils;
use Illuminate\Support\Facades\DB;

class UserAdmin extends MyModel
{
    protected $table = "user";

    function getUserPhone($numUser,$date,$role){
        $dbData = $this->selectRaw('name,phone_number' )

            ->where("last_visit", $date)
            ->where("role", $role)

            ->get($numUser);

        return $dbData;

    }

    function CreateAdminUserRole($email,$name,$password,$role,$vendor){
        $queryState = DB::table('user')->insertGetId(
            ['email' => $email, 'password'=> $password,'name'=>$name,'role'=> $role,'vendor'=>$vendor]
        );

        if($queryState){
            return "Success";
        }
        else{
            return "False ";
        }
    }

}
