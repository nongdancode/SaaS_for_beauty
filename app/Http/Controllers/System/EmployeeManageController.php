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

        $data = $this->UserModel->getStaffByVendor(1);
        return $data;
    }


    function addServices(){
        $servicesFields = $this->Request;
        $sevice_name = $servicesFields['name'];
        $service_cost = $servicesFields['cost'];
        $stepping = $servicesFields['stepping'];
        $UserFollow =$servicesFields['users'];
      $ser_id =  $this->ServiceModel->addServices($this->VendorId,$sevice_name,$service_cost,$stepping);
        for($i=0 ; $i< sizeof($UserFollow);$i++){
            $this->ServiceModel->addEmployeeForServies($this->VendorId, $ser_id,$UserFollow[$i]);
        }
    }

}
