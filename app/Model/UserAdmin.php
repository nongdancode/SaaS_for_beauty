<?php
/**
 * Created by IntelliJ IDEA.
 * User: letua
 * Date: 1/27/2020
 * Time: 7:07 AM
 */

namespace App\Model;
use Illuminate\Support\Facades\DB;

class UserAdmin extends  MyModel
{
    protected $user = "user";



    function getUserNameInfoById($id,$vendorid){
        $data = DB::table($this->user)->select('id','name','phone_number')
            ->where('id','=',$id)
            ->where('vendor','=',$vendorid)
            ->get();
        return $this->decodeStd($data);
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

    function CreateEmployeeForVendor($email,$name,$ssn,$role,$vendor,$phone_number,$img){
        $queryState = DB::table('user')->insertGetId(
            ['email' => $email, 'ssn'=> $ssn,'name'=>$name,'role'=> $role,'vendor'=>$vendor,'phone_number'=>$phone_number,'image'=>$img]
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

        $queryState = DB::table('scheduletask')->join('user', 'user.id', '=', 'scheduletask.user_ids')
            ->join('service', 'scheduletask.services_ids', '=', 'service.id')
            ->select('scheduletask.user_ids as id', 'user.name', 'user.image as img', 'scheduletask.services_ids as service_id', 'service.service_name')
            ->where('scheduletask.vendor', '=', $vendor)
            ->groupBy('scheduletask.user_ids', 'user.name', 'user.image', 'scheduletask.services_ids', 'service.service_name', 'scheduletask.day')
            ->get();
        return $this->decodeStd($queryState);
    }

    function getStaffByALlServicesVer2($vendor){
        $queryState = DB::table('user')
            ->join('users_services','user.id','=','users_services.user_id')
            ->join('service','service.id','=','users_services.services_id')
            ->select('user.id as id','user.name','user.image as img',
                'users_services.services_id as service_id','service.service_name')
            ->where('users_services.vendor_id',$vendor)
            ->groupBy('user.id','user.name','user.image',
                'users_services.services_id','service.service_name')
            ->get();

        return $this->decodeStd($queryState);
    }

    function getServicesByStaff($vendor,$staffId){
        $queryState = DB::table('scheduletask')->join('user', 'user.id', '=', 'scheduletask.user_ids')
            ->join('service', 'scheduletask.services_ids', '=', 'service.id')
            ->select( 'scheduletask.services_ids as id', 'service.service_name as name','service.image as img','service.duration as stepping')
            ->where('scheduletask.vendor', '=', $vendor)
            ->where('scheduletask.user_ids', '=', $staffId)
            ->groupBy('scheduletask.services_ids ', 'service.service_name ','service.image','service.duration')
            ->get();
        return $this->decodeStd($queryState);
    }

    function getStaffByVendor($vendor){
        $queryState = DB::table('user')
            ->where('vendor',$vendor)

            ->get();
        return $this->decodeStd($queryState);
    }


    function getAllEmployeeTurnInDayForBooking($employeeId, $servicesId, $day, $vendor)
    {
        $queryState = DB::table('scheduletask')

            ->select(DB::raw('(TIME_TO_SEC(start_time) +  UNIX_TIMESTAMP(day)) as start_time'),
            DB::raw('(TIME_TO_SEC(end_time) +  UNIX_TIMESTAMP(day)) as end_time'))
            ->where('services_ids', '=', $servicesId)
            ->where('user_ids', '=', $employeeId)
            ->where('vendor', '=', $vendor)
            ->where('day', '=', $day)
            ->where('status','=','active')
            ->get();

        return $this->decodeStd($queryState);
    }
    function getScheduleForStaff($employeeId,$vendor){
        $queryState = DB::table('scheduletask')

            ->join('service', 'scheduletask.services_ids', '=', 'service.id')
            ->select( 'scheduletask.services_ids as id', 'service.service_name as name','service.image as img',
                'service.duration as stepping','service.image as img'
            ,DB::raw('(TIME_TO_SEC(scheduletask.start_time) +  UNIX_TIMESTAMP(scheduletask.day)) as start_time'),
                DB::raw('(TIME_TO_SEC(scheduletask.end_time) +  UNIX_TIMESTAMP(scheduletask.day)) as end_time'))
            ->where('scheduletask.vendor', '=', $vendor)
            ->where('scheduletask.user_ids', '=', $employeeId)

            ->get();
        return $this->decodeStd($queryState);
    }

    function AddStaffForVendor($name,$password,$phone_number,$birthday,$image,$email,$vendor,$ssn,$role){
        $queryState = DB::table('user')->insertGetId(
            ['email'=>$email, 'password'=> $password,'name'=>$name,$role=> 'staff','vendor'=>$vendor,'phone_number'=>$phone_number,
                'birthday'=>$birthday,'image'=>$image,'ssn'=>$ssn]
        );
        return $queryState;
    }

    function UpdateStaffForVendor($name,$password,$phone_number,$birthday,$image,$email,$vendor,$ssn,$role){
        $queryState = DB::table('user')->updateOrInsert(['email'=>$email,'vendor'=>$vendor],
            ['email'=>$email, 'password'=> $password,'name'=>$name,$role=> 'staff','phone_number'=>$phone_number,
                'birthday'=>$birthday,'image'=>$image,'ssn'=>$ssn]
            );
    }



    function getTurnDayOfEmployeeForBooking($employeeId, $servicesId, $vendor,$nowTime)
    {
        $queryState = DB::table('scheduletask')

            ->select('services_ids', 'user_ids', 'day as day1', DB::raw('UNIX_TIMESTAMP(day) as day2'))
            ->where('services_ids', '=', $servicesId)
            ->where('user_ids', '=', $employeeId)
            ->where('vendor', '=', $vendor)
            ->where('day','>=',$nowTime )
            ->get();

        return $this->decodeStd($queryState);
    }

    function getStaffByVendorService($vendor,$service){
        $queryState = DB::table('user')
            ->join('users_services','user.id','=','users_services.user_id')
            ->join('service','service.id','=','users_services.services_id')
             ->select('users_services.user_id as user_id','user.name as user_name',
                'users_services.services_id as service_id','service.service_name')
            ->where('users_services.vendor_id',$vendor)
            ->where('users_services.services_id',$service)
            ->get();
        return $this->decodeStd($queryState);

    }

    function addServiceForEmployee($vendorId,$servicesID,$employeeId)
    {
        $dbData = DB::table('users_services')->insertGetId(['vendor_id' => $vendorId, 'services_id' => $servicesID, 'user_id' => $employeeId
        ]);

        return $dbData;


    }

    function getInforStaff($vendor,$employee){
        $queryState = DB::table('user')
            ->where('vendor',$vendor)
            ->where('id',$employee)
            ->get();
        return $this->decodeStd($queryState);
    }

    function editEmployee($email,$img,$password,$phone_number,$social_number,$vendor,$id)
    {
        $queryState = DB::table('user')

            ->where('vendor',$vendor)
            ->where('id',$id)
            ->update(['email'=>$email,'image'=>$img,'password'=>$password,'phone_number'=>$phone_number,'ssn'=>$social_number]);

        return $queryState;

    }
    function deleteEmployee($vendor,$employee_id){
        $dbData = DB::table('users_services')
            ->where('vendor_id',$vendor)
            ->where('user_id',$employee_id)
            ->delete();


        $dbData2 = DB::table('user')
            ->where('vendor',$vendor)
            ->where('id',$employee_id)
            ->delete();

        $dbData3 = DB::table('scheduletask')
            ->where('vendor',$vendor)
            ->where('user_ids',$employee_id)
            ->delete();

        $dbData4 = DB::table('salarydefine')
            ->where('vendor_id',$vendor)
            ->where('user_id',$employee_id)
            ->delete();


    }


    }
