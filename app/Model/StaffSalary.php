<?php
/**
 * Created by IntelliJ IDEA.
 * User: letua
 * Date: 2/22/2020
 * Time: 8:21 PM
 */

namespace App\Model;

use Illuminate\Support\Facades\DB;

class StaffSalary extends MyModel
{
   protected $UserModel = 'users';
   protected $SalaryDefine = 'salarydefine';


   public function listPaymentTypleForStaff($vendor,$employeeId){
       $dbData = DB::table($this->SalaryDefine)
           ->select('description as payment_type')
           ->where('salary_type','payment_type')
           ->where('vendor_id',$vendor)
           ->where('user_id',$employeeId)

           ->get();

       return $this->decodeStd($dbData);
   }



   public function listCommissionForStaff($vendor,$employeeId){
       $dbData = DB::table($this->SalaryDefine)
           ->select('description as commission')
           ->where('salary_type','commission')
           ->where('vendor_id',$vendor)
           ->where('user_id',$employeeId)
           ->get();

       return $this->decodeStd($dbData);
   }

   public function listBaseSalaryForStaff($vendor,$employeeId){
       $dbData = DB::table($this->SalaryDefine)
           ->select('description as base_salary')
           ->where('salary_type','salary')
           ->where('vendor_id',$vendor)
           ->where('user_id',$employeeId)
           ->get();

       return $this->decodeStd($dbData);
   }

   function addEmployeeSalaryDefine($vendor,$employeeId,$payment_type,$commission_type,$base_salary){
       $dbData = DB::table($this->SalaryDefine)->insertGetId(['user_id'=>$employeeId,
           'vendor_id'=>$vendor,'salary_type'=>'payment_type','description'=>$payment_type]);
       $dbData2 = DB::table($this->SalaryDefine)->insertGetId(['user_id'=>$employeeId,
           'vendor_id'=>$vendor,'salary_type'=>'commission','description'=>$commission_type]);

       $dbData3 = DB::table($this->SalaryDefine)->insertGetId(['user_id'=>$employeeId,
           'vendor_id'=>$vendor,'salary_type'=>'salary','description'=>$base_salary]);

   }

   function editEmployeeSalaryDefine($vendor,$employeeId,$payment_type,$commission_type,$base_salary){
       $dbData = DB::table($this->SalaryDefine)->updateOrInsert(['user_id'=>$employeeId,
           'vendor_id'=>$vendor,'salary_type'=>'payment_type'],['description'=>$payment_type]);
       $dbData2 = DB::table($this->SalaryDefine)->updateOrInsert(['user_id'=>$employeeId,
           'vendor_id'=>$vendor,'salary_type'=>'commission'],['description'=>$commission_type]);

       $dbData3 = DB::table($this->SalaryDefine)->updateOrInsert(['user_id'=>$employeeId,
           'vendor_id'=>$vendor,'salary_type'=>'salary'],['description'=>$base_salary]);
   }

   function updateIncomeForEmployee($Vendor,$employeeId,$type,$income){
       $dbData = DB::table('salarydefine')

           ->where('vendor_id',$Vendor)
           ->where('user_id',$employeeId)
           ->where('salary_type',$type)
           ->update(['income'=>$income]);

   }

   function getCurrentBaseSalaryIncome($Vendor,$employeeId){
       $dbData = DB::table('salarydefine')
           ->join('users','users.id','=','salarydefine.user_id')
           ->selectRaw('(curdate() - date_add(curdate(),interval -DAY(curdate())+1 DAY))*salarydefine.description) as salary
           ,users.name as name ,salarydefine.salary_type as type')

           ->where('salarydefine.vendor_id',$Vendor)
           ->where('salarydefine.user_id',$employeeId)
           ->where('salarydefine.salary_type','=','salary')
           ->get();

       return $this->decodeStd($dbData);
   }
   function getSalaryInfoForAllEmployee($vendor){
       $dbData = DB::table('salarydefine')
           ->join('users','users.id','=','salarydefine.user_id')
           ->where('vendor_id',$vendor)
           ->get();
       return $this->decodeStd($dbData);
   }

   public function getIncomeMonthByMonthForEmployee($Vendor)
   {
       $dbData = DB::table('internaltransaction')
           ->join('users','users.id','=','internaltransaction.employee_id')
         ->selectRaw('DATE_FORMAT(internaltransaction.created_at,\'%Y-%m\') as month_salary,sum(internaltransaction.amount) as income_service,users.name as employee_name,users.id as employee_id')
           ->where('internaltransaction.vendor_id','=',$Vendor)
           ->groupBy('month_salary','users.name','users.id')
           ->get();
       return $this->decodeStd($dbData);
   }



}
