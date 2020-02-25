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
           ->where('salary_type','payment')
           ->groupby('description')
           ->get();

       return $this->decodeStd($dbData);
   }

   public function listCommissionTypeForStaff(){
       $dbData = DB::table($this->SalaryDefine)
           ->select('description as commission')
           ->where('salary_type','commission_type')
           ->groupby('description')
           ->get();

       return $this->decodeStd($dbData);
   }
}
