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
use App\Model\GroupService;
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
    protected $GroupService;




    function __construct(Request $request)
    {
        date_default_timezone_set('America/Chicago');
        $this->dataRequest =$request->all();
        $this->customerModel = new Customer();
        $this->util = new MyUtils();
        $this->ServiceModel = new ServicesVendor();
        $this->SMSUser = $request->getContent();
        $this->UserModel = new UserAdmin();
        $this->GroupService = new GroupService();

    }


    function getAllServicesByVendor(){
        $data = $this->ServiceModel->getAllServicesByVendor($this->VendorId);
        return $this->util->returnHttps($data,0,'');
    }

    function addServices(Request $request){
        $servicesFields = $request->all();
        $sevice_name = $servicesFields['name'];
        $service_cost = $servicesFields['cost'];
        $stepping = $servicesFields['stepping'];
        $UserFollow =$servicesFields['users'];
        $ser_id =  $this->ServiceModel->addServices($this->VendorId,$sevice_name,$service_cost,$stepping);
        for($i=0 ; $i< sizeof($UserFollow);$i++){
            $this->ServiceModel->addEmployeeForServies($this->VendorId, $ser_id,$UserFollow[$i]);
        }
        return $this->util->returnHttps('',0,'');
    }

    function getAllServicesByVendorForCrud(){
        $data = $this->ServiceModel->getAllServicesByVendor($this->VendorId);

        if(sizeof($data) > 0){

            for($i= 0 ; $i< sizeof($data); $i++){
                $data[$i]['groupIds'] = [];
                $user = $this->UserModel->getStaffByVendorService($this->VendorId,$data[$i]['id']);
                $GroupService = $this->GroupService->getGroupForService($this->VendorId,$data[$i]['id']);
                 foreach ($GroupService as $g){
                     $data[$i]['groupIds'][]=$g['id'];
                 }

                if(sizeof($user) >0){
                    for($a= 0 ; $a< sizeof($user); $a++){
                        $data[$i]['userIds'][] = (int)$user[$a]['user_id'];
                    }
                }

            }
        }


        return $this->util->returnHttps($data,0,'');
    }

    function  addServiceForCrud(Request $request){
        $serviveField = $request->all();
        $serviceAddId = $this->ServiceModel->addServices($this->VendorId,$serviveField['name'],$serviveField['price']
            ,$serviveField['stepping'],$serviveField['img']);
        if( sizeof($serviveField['userIds'])>0){
            for($i= 0 ; $i< sizeof($serviveField['userIds']); $i++){
               $this ->ServiceModel->addEmployeeForServies($this->VendorId,$serviceAddId,$serviveField['userIds'][$i]);
            }
        }
        foreach($serviveField['groupIds'] as $group){
          $this->GroupService->assignGroupService($this->VendorId,$serviceAddId,$group);
        }
        return $this->util->returnHttps('',0,'');

    }

    function updateServiceForCrud(Request $request){
        $fields = $request->all();
         $listStaff = $this->ServiceModel->listAllEmployeeIdOfService($this->VendorId,$fields['id']);
        $listoldId = [];
        $count = 0;


         foreach ($listStaff as $staff){
             array_push($listoldId,(int)$staff['user_id']);
         }
        $listdiff = array_values(array_diff($fields['userIds'],$listoldId));
        $listdiff2 = array_values(array_diff($listoldId,$fields['userIds']));
        $listdiff3 = $listdiff+$listdiff2;


         if(sizeof($listoldId) ==0){
             foreach ($fields['userIds'] as $id){
                 $this->ServiceModel->addEmployeeForServies(
                     $this->VendorId,
                     $fields['id'],
                     $id);
             }

         }if (sizeof($fields['userIds']) ==0){
             foreach ($listoldId as $id){
                 $this->ServiceModel->deleteEmployeOfService(
                     $this->VendorId,
                     $fields['id'],
                     $id
                 );
             }
         }
         if (sizeof($fields['userIds']) !=0 && sizeof($listoldId) !=0 && sizeof($listdiff3)!= 0){

             foreach ($listdiff3 as $id){
                 if(in_array($id, $listoldId) == True && in_array($id, $fields['userIds'])== False){
                     $this->ServiceModel->deleteEmployeOfService(
                         $this->VendorId,
                         $fields['id'],
                         $id
                     );
                 }
                 if(in_array($id,$fields['userIds'])== True &&in_array($id, $listoldId) == False ){
                     $this->ServiceModel->addEmployeeForServies(
                         $this->VendorId,
                         $fields['id'],
                         $id);
                 }
             }
         }


         $listGroup = $this->GroupService->getGroupForService($this->VendorId,$fields['id']);
         $oldGroup = [];

        foreach ($listGroup as $group){
            array_push($oldGroup ,(int)$group['id']);
        }
        $GroupDiffId = array_values(array_diff($fields['groupIds'],$oldGroup)) + array_values(array_diff($oldGroup,$fields['groupIds']));


        if(sizeof($oldGroup) ==0) {
            foreach ($fields['groupIds'] as $id) {
                $this->GroupService->assignGroupService($this->VendorId
                    , $fields['id'], $id);

            }
        }

        if (sizeof($fields['groupIds']) ==0){
            foreach ($oldGroup as $id){
              $this->GroupService->unassignGroupService($this->VendorId,$fields['id'],$id);
            }
        }
        if (sizeof($fields['groupIds']) !=0 && sizeof($oldGroup) !=0 && sizeof($GroupDiffId)!= 0){

            foreach ($GroupDiffId as $id){
                if(in_array($id, $oldGroup) == True && in_array($id, $fields['groupIds'])== False){

                    $this->GroupService->unassignGroupService($this->VendorId,$fields['id'],$id);
                    $count ++;
                }
                if(in_array($id,$fields['groupIds'])== True &&in_array($id, $oldGroup) == False){
                    $this->GroupService->assignGroupService($this->VendorId
                        , $fields['id'], $id);
                }
            }
        }

        $this->ServiceModel->updateServiceForCrud(
            $this->VendorId,
            $fields['id'],
            $fields['name'],
            $fields['price'],
            $fields['stepping'],
        $fields['img']);

//        $dataReturn['code'] = 0;
        return $this->util->returnHttps('',0,'');
    }

    function deleteServiceForCrud(Request $request){
        $id = $request->id;
        $this->ServiceModel->deleteService($this->VendorId,$id);
        return $this->util->returnHttps('',0,'');
    }


}
