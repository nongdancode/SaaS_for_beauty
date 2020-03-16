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
   protected $UserModel = 'user';
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
           ->join('user','user.id','=','salarydefine.user_id')
           ->selectRaw('(curdate() - date_add(curdate(),interval -DAY(curdate())+1 DAY))*salarydefine.description) as salary
           ,user.name as name ,salarydefine.salary_type as type')

           ->where('salarydefine.vendor_id',$Vendor)
           ->where('salarydefine.user_id',$employeeId)
           ->where('salarydefine.salary_type','=','salary')
           ->get();

       return $this->decodeStd($dbData);
   }
   function getSalaryInfoForAllEmployee($vendor){
       $dbData = DB::table('salarydefine')
           ->join('user','user.id','=','salarydefine.user_id')

           ->where('vendor_id',$vendor)
           ->get();
       return $this->decodeStd($dbData);
   }

   function getComissionIncomInMonthForEmployee($Vendor,$employeeId)
   {
//       $dbData = DB::table('internaltransaction')
//           ->join('salarydefine','salarydefine.user_id','=','internaltransaction.employee_id')
//           ->select('internaltransaction.amount as amount')

   }

}
