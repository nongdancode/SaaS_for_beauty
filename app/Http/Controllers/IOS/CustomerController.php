<?php


namespace App\Http\Controllers\IOS;
use App\Http\Controllers\Controller;
use App\Lib\MyUtils;
use App\Model\ConfigVendorModel;
use App\Model\Customer;
use App\Model\CustomerIOS;
use App\Model\UserAdmin;
use App\Model\Vendor;
use Illuminate\Http\Request;

class CustomerController  extends Controller
{

  private $iosUser;
  private $customer;
  private $vendor = 2;
  private $util;

    function __construct(Request $request){
        $this->util = new MyUtils();
        $this->iosUser = new CustomerIOS();
        $this->customer = new Customer();
    }
  function listDataForIOS(){
      $data = $this->iosUser->listIOSCustomer($this->vendor);
      return  response($this->util->returnHttps($data,0,''))->header('X-Total-Count',99999);

  }

  function updateCusIos(Request $request){
    $data = $request ->all();
    $this->iosUser->AssigneCustomerForIOS($this->vendor,$data['name'],$data['phone_number'],$data['email'],$data['birthday'],$data['visit_count']);
    return response($this->util->returnHttps('',0,''))->header('X-Total-Count',99999);

  }

  function deleteCusIosData(Request $request){
         $data = $request->all();
         $this->iosUser->deleteCustomer($this->vendor,$data['cus_id']);
      return response($this->util->returnHttps('',0,''))->header('X-Total-Count',99999);
  }

  function assginCardForCus(Request $request){
    $data = $request->all();
    $this->iosUser->assignaCardForCustomr($this->vendor,$data['cus_id'],$data['card_number'],$data['card_exp'],$data['card_type'],$data['card_issue']);
      return response($this->util->returnHttps('',0,''))->header('X-Total-Count',99999);

  }

  function unsignCardForCus(Request $request){
      $data = $request->all();
      $this->iosUser->unsignCard($this->vendor,$data['card_number']);
      return response($this->util->returnHttps('',0,''))->header('X-Total-Count',99999);
  }
}
