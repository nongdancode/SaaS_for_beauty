<?php
/**
 * Created by IntelliJ IDEA.
 * User: letua
 * Date: 2/25/2020
 * Time: 6:45 PM
 */

namespace App\Http\Controllers\System;
use App\Http\Controllers\Controller;
use App\Lib\MyUtils;

use App\Model\Customer;
use App\Model\ServicesVendor;
use App\Model\Transaction;
use App\Model\UserAdmin;
use Illuminate\Http\Request;

class ServiceManageController  extends Controller
{

    protected $util;
    protected $fromDate;
    protected $toDate;
    protected $customerModel;
    protected $TwilloSMS;
    protected $SMSDatatable;
    protected $SMSUser;
    protected $VendorId = 1;
    protected $ServiceModel ;
    protected $dataRequest;
    protected $UserModel;




    function __construct(Request $request)
    {
        $this->dataRequest =$request->all();
        $this->customerModel = new Customer();
        $this->util = new MyUtils();
        $this->ServiceModel = new ServicesVendor();
        $this->SMSUser = $request->getContent();
        $this->UserModel = new UserAdmin();

    }


    function getAllServicesByVendor(){
        $data = $this->ServiceModel->getAllServicesByVendor($this->VendorId);
        return $data;
    }

    function addServices(){
        $servicesFields = $this->dataRequest;
        $sevice_name = $servicesFields['name'];
        $service_cost = $servicesFields['cost'];
        $stepping = $servicesFields['stepping'];
        $UserFollow =$servicesFields['users'];
        $ser_id =  $this->ServiceModel->addServices($this->VendorId,$sevice_name,$service_cost,$stepping);
        for($i=0 ; $i< sizeof($UserFollow);$i++){
            $this->ServiceModel->addEmployeeForServies($this->VendorId, $ser_id,$UserFollow[$i]);
        }
    }

    function getAllServicesByVendorForCrud(){
        $data = $this->ServiceModel->getAllServicesByVendor($this->VendorId);
        if(sizeof($data) > 0){
            for($i= 0 ; $i< sizeof($data); $i++){
                $user = $this->UserModel->getStaffByVendorService($this->VendorId,$data[$i]['id']);
                if(sizeof($user) >0){
                    for($a= 0 ; $a< sizeof($user); $a++){
                        $data[$i]['userIds'][] = $user[$a]['user_id'];
                    }
                }

             

            }
        }


        return $data;
    }
}
