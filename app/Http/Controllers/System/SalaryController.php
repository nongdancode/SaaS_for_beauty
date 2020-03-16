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

    function calculateSalary(Request $request){

    }
}
