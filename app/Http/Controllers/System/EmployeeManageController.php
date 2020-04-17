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
    protected $util;
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

        return $this->util->returnHttps($data,0,'');
  }

  function showPaymentTypeOfStaff(){
      $data =  $this->salaryDefine->listPaymentTypleForStaff();

      return $this->util->returnHttps($data,0,'');
  }


    function getAllEmployeeFromVendor(){

        $data = $this->UserModel->getStaffByVendor($this->VendorId);

        for($i = 0 ; $i<sizeof($data);$i++){

            $serviceInfo = $this->ServiceModel->getservicesByStaff($this->VendorId,$data[$i]['id']);
            $paymentType = $this->SalaryDefineModel->listPaymentTypleForStaff($this->VendorId,$data[$i]['id']);
            $basesalary = $this->SalaryDefineModel->listBaseSalaryForStaff($this->VendorId,$data[$i]['id']);
            $commissionType = $this->SalaryDefineModel->listCommissionForStaff($this->VendorId,$data[$i]['id']);

            if(sizeof($basesalary) ==0){
                $basesalary[0]['base_salary'] = 0;
            }
            if(sizeof($commissionType)==0){
                $commissionType[0]['commission'] = 0;
            }
            if(sizeof($paymentType)== 0 ){
                $paymentType[0]['payment_type'] = '';
            }
            $data[$i]['social_sn'] = $data[$i]['ssn'];
            $data[$i]['payment_type'] = $paymentType[0]['payment_type'];
            $data[$i]['commission_type'] =  (int)$commissionType[0]['commission'];

            $data[$i]['base_salary'] = (int)$basesalary[0]['base_salary'];
            for($a = 0 ; $a<sizeof($serviceInfo);$a++){
                $data[$i]['services'][] = $serviceInfo[$a]['id'];
            }
        }

        return $this->util->returnHttps($data,0,'');
    }

    function getEmployeeForFakerNHOLAPHAIDELETECAIDOQUYNAY(){
        $data = $this->UserModel->getStaffByVendor($this->VendorId);
        for($i = 0 ; $i<sizeof($data);$i++){
            $data[$i]['password'] = '123123@';
        }
        return $this->util->returnHttps($data,0,'');
    }


    function addEmployee(Request $request){
        $employeeFields = $request->all();
        $userAddId = $this->UserModel->CreateEmployeeForVendor($employeeFields['email'],$employeeFields['name'],
            $employeeFields['social_sn'], 'staff',$this->VendorId,$employeeFields['phone_number'],$employeeFields['image']);
         $this->salaryDefine->addEmployeeSalaryDefine($this->VendorId,$userAddId,$employeeFields['payment_type'],
            $employeeFields['commission_type'],$employeeFields['base_salary']);

//        $return['code'] = 0;
        return $this->util->returnHttps('',0,'');

    }

    function editEmployee(Request $request){
        $field = $request->all();
        $this->UserModel->editEmployee( $field['email'],$field['image'],
            $field['password'],$field['phone_number'],$field['social_sn'],$this->VendorId,$field['id']);
        $this->salaryDefine->editEmployeeSalaryDefine($this->VendorId,$field['id'],$field['payment_type'],
            $field['commission_type'],$field['base_salary']);
//        $return['code'] = 0;
        return $this->util->returnHttps('',0,'');
    }

    function deleteEmployee(Request $request){
       $id  = $request->id;
       $this->UserModel->deleteEmployee($this->VendorId,$id);
//        $return['code'] = 0;
        return $this->util->returnHttps('',0,'');


    }

}
