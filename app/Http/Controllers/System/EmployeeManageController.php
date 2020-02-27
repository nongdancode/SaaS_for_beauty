<?php
/**
 * Created by IntelliJ IDEA.
 * User: letua
 * Date: 2/23/2020
 * Time: 5:22 PM
 */

namespace App\Http\Controllers\System;
use App\Lib\MyUtils;
use App\Model\ServicesVendor;
use App\Model\StaffSalary;
use App\Model\UserAdmin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Lcobucci\JWT\Signature;

class EmployeeManageController extends Controller
{
    protected $salaryDefine;

    protected $VendorId = 1;
    protected $UserModel;
    protected $ServiceModel;


    function __construct(Request $request)
    {

        $this->util = new MyUtils();
        $this->Staff = new UserAdmin();
        $this->salaryDefine = new StaffSalary();
        $this->UserModel = new UserAdmin();
        $this->ServiceModel = new ServicesVendor();
        $this->Request = $request->all();


    }
  function showCommissionTypeOfStaff(){
       $data =  $this->salaryDefine->listCommissionTypeForStaff();

        return $data;
  }

  function showPaymentTypeOfStaff(){
      $data =  $this->salaryDefine->listPaymentTypleForStaff();

      return $data;
  }


    function getAllEmployeeFromVendor(){

        $data = $this->UserModel->getStaffByVendor($this->VendorId);
        for($i = 0 ; $i<sizeof($data);$i++){
            $serviceInfo = $this->ServiceModel->getservicesByStaff($this->VendorId,$data[$i],$data[$i]['id']);
            for($a = 0 ; $a<sizeof($serviceInfo);$a++){
                $data[$i]['services'][] = $serviceInfo[$a]['id'];
            }
        }

        return $data;
    }

    function getEmployeeForFakerNHOLAPHAIDELETECAIDOQUYNAY(){
        $data = $this->UserModel->getStaffByVendor($this->VendorId);
        for($i = 0 ; $i<sizeof($data);$i++){
            $data[$i]['password'] = '123123@';
        }
        return $data;


    }




    function addEmployee(){
        $employeeFields = $this->Request;
//        $this->UserModel->CreateEmployeeForVendor($employeeFields['email'],$employeeFields['name'],$employeeFields)


    }

}
