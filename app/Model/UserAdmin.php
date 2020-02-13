<?php
/**
 * Created by IntelliJ IDEA.
 * User: letua
 * Date: 1/27/2020
 * Time: 7:07 AM
 */

namespace App\Model;
use Illuminate\Support\Facades\DB;

class UserAdmin extends MyModel
{
    protected $table = "user";

//    function getUserPhone($numUser,$date,$role){
//        $dbData = $this->selectRaw('name,phone_number' )
//
//            ->where("last_visit", $date)
//            ->where("role", $role)
//
//            ->get($numUser);
//
//        return $dbData;
//
//    }

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

    function getStaffByAllServices($vendor)
    {
//
//
//        DB::raw('UNIX_TIMESTAMP(scheduletask.day) as day' )
        $queryState = DB::table('scheduletask')->join('user', 'user.id', '=', 'scheduletask.user_ids')
            ->join('service', 'scheduletask.services_ids', '=', 'service.id')
            ->select('scheduletask.user_ids as id', 'user.name', 'user.image as img', 'scheduletask.services_ids as service_id', 'service.service_name'
            )
            ->where('scheduletask.vendor', '=', $vendor)
            ->groupBy('scheduletask.user_ids', 'user.name', 'user.image', 'scheduletask.services_ids', 'service.service_name', 'scheduletask.day')
            ->get();
        return $queryState;
    }

    function getAllEmployeeTurnInDayForBooking($employeeId, $servicesId, $day, $vendor)
    {
        $queryState = DB::table('scheduletask')->select(DB::raw('(TIME_TO_SEC(start_time) +  UNIX_TIMESTAMP(day)) as start_time'),
            DB::raw('(TIME_TO_SEC(end_time) +  UNIX_TIMESTAMP(day)) as end_time'))
            ->where('services_ids', '=', $servicesId)
            ->where('user_ids', '=', $employeeId)
            ->where('vendor', '=', $vendor)
            ->where('day', '=', $day)
            ->get();

        return $queryState;
    }

    function getTurnDayOfEmployeeForBooking($employeeId, $servicesId, $vendor)
    {
        $queryState = DB::table('scheduletask')->select('services_ids', 'user_ids', 'day as day1', DB::raw('UNIX_TIMESTAMP(day) as day2'))
            ->where('services_ids', '=', $servicesId)
            ->where('user_ids', '=', $employeeId)
            ->where('vendor', '=', $vendor)
            ->get();

        return $queryState;
    }

}
