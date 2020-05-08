<?php
/**
 * Created by IntelliJ IDEA.
 * User: letua
 * Date: 3/5/2020
 * Time: 4:36 AM
 */

namespace App\Http\Controllers\System;
use App\Lib\MyUtils;
use App\Model\GroupService;
use App\Model\ServicesVendor;
use App\Model\StaffSalary;
use App\Model\UserAdmin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Lcobucci\JWT\Signature;


class GroupServiceController extends Controller
{
   protected $GroupService;
   protected $VendorID = 1 ;
   protected $util;

    function __construct(Request $request)
    {

        $this->util = new MyUtils();
        $this->UserModel = new UserAdmin();
        $this->ServiceModel = new ServicesVendor();
        $this->Request = $request->all();
        $this->GroupService = new GroupService();

        date_default_timezone_set('America/Chicago');

    }

    function listGroupService(){
       $data =  $this->GroupService->listServiceGroup($this->VendorID);
       return $this->util->returnHttps($data,0,'');
    }

    function addGroupService(Request $request){
        $GroupServiceField = $request->all();
        $this->GroupService->addGroupService($this->VendorID,$GroupServiceField['name']);
//        $return['code'] = 0;
        return $this->util->returnHttps('',0,'');

    }
    function editGroupService(Request $request){
        $GroupServiceField = $request->all();
        $this->GroupService->editGroupService($this->VendorID,$GroupServiceField['id'],$GroupServiceField['name']);
//        $return['code'] = 0;
        return $this->util->returnHttps('',0,'');
    }

    function deleteGroupService(Request $request){
        $GroupServiceField = $request->all();
        $id = $request->id;
        $this->GroupService->deleteGroupService($this->VendorID,$id);
//        $return['code'] = 0;
//        return $return;
        return $this->util->returnHttps('',0,'');
    }



}
