<?php


namespace App\Http\Controllers\IOS;
use App\Http\Controllers\Controller;
use App\Lib\MyUtils;
use App\Model\ConfigVendorModel;
use App\Model\CustomerIOS;
use App\Model\Vendor;
use Illuminate\Http\Request;

class CustomerController  extends Controller
{

  private $iosUser;
  private $vendor = 2;
  private $util;

    function __construct(Request $request){
        $this->util = new MyUtils();
        $this->iosUser = new CustomerIOS();
    }
  function listDataForIOS(){
      $data = $this->iosUser->listIOSCustomer($this->vendor);
      return  response($this->util->returnHttps($data,0,''))->header('X-Total-Count',99999);
  }

  function updateCusIos(Request $request){
    $data = $request ->all();

  }

  function deleteCusIosData(Request $request){
         $data = $request->all();
  }

  function assginCardForCus(Request $request){
    $data = $request->all();

  }

  function unsignCardForCus(Request $request){

  }
}
