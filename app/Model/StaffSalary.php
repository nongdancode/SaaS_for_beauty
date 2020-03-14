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


   public function listPaymentTypleForStaff(){
       $dbData = DB::table($this->SalaryDefine)
           ->select('description as payment_type')
           ->where('salary_type','payment_type')
           ->groupby('description')
           ->get();

       return $this->decodeStd($dbData);
   }

   public function listCommissionForStaff($vendor,$employeeId){
       $dbData = DB::table($this->SalaryDefine)
           ->select('description as commission')
           ->where('salary_type','commission')
           ->where('vendor',$vendor)
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
}
