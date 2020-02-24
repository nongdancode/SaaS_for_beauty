<?php
/**
 * Created by IntelliJ IDEA.
 * User: letua
 * Date: 2/23/2020
 * Time: 5:22 PM
 */

namespace App\Http\Controllers\System;
use App\Lib\MyUtils;
use App\Model\StaffSalary;
use App\Model\UserAdmin;
use Illuminate\Http\Request;
class EmployeeManageController extends Controller
{
    protected $salaryDefine;

    protected $VendorId = 1;


    function __construct(Request $request)
    {

        $this->util = new MyUtils();
        $this->Staff = new UserAdmin();
        $this->salaryDefine = new StaffSalary();


    }
  function showCommissionTypeOfStaff(){
       $data =  $this->salaryDefine->listCommissionTypeForStaff();

        return $data;
  }

  function showPaymentTypeOfStaff(){
      $data =  $this->salaryDefine->listPaymentTypleForStaff();

      return $data;
  }
}
