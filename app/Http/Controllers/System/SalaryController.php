<?php


namespace App\Http\Controllers\System;


use App\Lib\MyUtils;
use App\Model\ServicesVendor;
use App\Model\StaffSalary;
use App\Model\UserAdmin;
use Illuminate\Http\Request;

class SalaryController
{
    protected $salaryDefine;
    protected $VendorId = 1;
    protected $UserModel;
    protected $ServiceModel;
    protected $SalaryDefineModel;
    function __construct(Request $request)
    {

        $this->util = new MyUtils();
        $this->Staff = new UserAdmin();
        $this->salaryDefine = new StaffSalary();
        $this->UserModel = new UserAdmin();
        $this->ServiceModel = new ServicesVendor();
        $this->Request = $request->all();
        $this->SalaryDefineModel = new StaffSalary();

        date_default_timezone_set('America/Chicago');



    }

    function calculateSalary(){
      $StaffSalarys = $this->SalaryDefineModel->getIncomeMonthByMonthForEmployee($this->VendorId);
      $currMonth = date('Y-m');
      $currDate = date('d');




        for($i= 0 ;$i< sizeof($StaffSalarys);$i++){
            $baseSalary = $this->SalaryDefineModel->listBaseSalaryForStaff($this->VendorId,$StaffSalarys[$i]['employee_id']);
            $Comission = $this->SalaryDefineModel->listCommissionForStaff($this->VendorId,$StaffSalarys[$i]['employee_id']);
            $payment_type = $this->SalaryDefineModel->listPaymentTypleForStaff($this->VendorId,$StaffSalarys[$i]['employee_id']);
            $currentBaseSalary = 0;
            $StaffSalarys[$i]['commission_salary'] = 0;




            $StaffSalarys[$i]['commission_type'] = (int)$Comission[0]['commission'];
            $StaffSalarys[$i]['base_salary'] = (int)$baseSalary[0]['base_salary'];
            $StaffSalarys[$i]['payment_type'] = $payment_type[0]['payment_type'];


           if($StaffSalarys[$i]['commission_type'] != 0){
               $StaffSalarys[$i]['commission_salary'] =  $StaffSalarys[$i]['income_service']/100*$StaffSalarys[$i]['commission_type'];
           }else{
               $StaffSalarys[$i]['commission_salary'] =  0;
           }

            if($currMonth == $StaffSalarys[$i]['month_salary']){
                $currentBaseSalary =  $StaffSalarys[$i]['base_salary'] *(int)$currDate;
            }else{
                $numDay = cal_days_in_month(CAL_GREGORIAN, date($StaffSalarys[$i]['month_salary'],'m'), date($StaffSalarys[$i]['month_salary'],'y'));
                $currentBaseSalary =  $StaffSalarys[$i]['base_salary'] *$numDay;
            }
            if($currentBaseSalary >  $StaffSalarys[$i]['commission_salary']){
                $StaffSalarys[$i]['salary_total'] = $currentBaseSalary;
            }else{
                $StaffSalarys[$i]['salary_total'] =$StaffSalarys[$i]['commission_salary'];
            }


        }
        return $this->util->returnHttps($StaffSalarys,0,'');
    }
}
