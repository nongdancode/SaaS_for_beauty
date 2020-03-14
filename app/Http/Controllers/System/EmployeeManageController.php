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
  function showCommissionTypeOfStaff(){
       $data =  $this->salaryDefine->listCommissionForStaff();

        return $data;
  }

  function showPaymentTypeOfStaff(){
      $data =  $this->salaryDefine->listPaymentTypleForStaff();

      return $data;
  }


    function getAllEmployeeFromVendor(){

        $data = $this->UserModel->getStaffByVendor($this->VendorId);

        for($i = 0 ; $i<sizeof($data);$i++){

            $serviceInfo = $this->ServiceModel->getservicesByStaff($this->VendorId,$data[$i]['id']);
            $paymentType = $this->SalaryDefineModel->listPaymentTypleForStaff();
            $basesalary = $this->SalaryDefineModel->listBaseSalaryForStaff($this->VendorId,$data[$i]['id']);
            if(sizeof($basesalary) ==0){
                $basesalary[0]['base_salary'] = 0;
            }
            $data[$i]['social_sn'] = $data[$i]['ssn'];
            $data[$i]['payment_type'] = $paymentType[0]['payment_type'];

            $data[$i]['base_salary'] = (int)$basesalary[0]['base_salary'];
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


    function addEmployee(Request $request){
        $employeeFields = $request->all();
        $userAddId = $this->UserModel->CreateEmployeeForVendor($employeeFields['email'],$employeeFields['name'],
            $employeeFields['social_sn'], 'staff',$this->VendorId,$employeeFields['phone_number'],$employeeFields['image']);

        $return['code'] = 0;
        return $return;

    }

    function editEmployee(Request $request){
        $field = $request->all();
        $this->UserModel->editEmployee( $field['email'],$field['image'],
            $field['password'],$field['phone_number'],$field['social_sn'],$this->VendorId,$field['id']);

        $return['code'] = 0;
        return $return;
    }

    function deleteEmployee(Request $request){
       $id  = $request->id;
       $this->UserModel->deleteEmployee($this->VendorId,$id);
        $return['code'] = 0;
        return $return;

    }

}
