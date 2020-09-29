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
      return  response($this->util->returnIoss($data,0,'',sizeof($data)))->header('Access-Control-Allow-Headers: origin, x-requested-with, content-type, x-total-count',sizeof($data));

  }

  function updateCusIos(Request $request){
    $data = $request ->all();
    $cus = $this->iosUser->customerIOS($data);

    $data3 = $this->iosUser->AssigneCustomerForIOS($this->vendor,$cus['name'],$cus['phone_number'],$cus['email'],$cus['birthday'],$cus['visit_count']);
    if($cus['card_number']!= null){
        $AssignCard = $this->iosUser->assignaCardForCustomer($this->vendor,$data['id'],$cus['card_number'],$cus['card_exp_date'],$cus['card_type'],$cus['card_issue']);
    }elseif ($cus['card_number']== null){
        $this->iosUser->unsignCard($this->vendor,$cus['id']);
    }
     $data2 = $this->iosUser->listIOSCustomer($this->vendor);
      return  response($this->util->returnIoss($data3,0,'',sizeof($data)))
          ->header('Access-Control-Allow-Headers: origin, x-requested-with, content-type, x-total-count',sizeof($cus));

  }
  function addNewCusIos(Request $request){
      $data = $request ->all();
      $cus = $this->iosUser->customerIOS($data);
      $data3 = $this->iosUser->AssigneCustomerForIOS($this->vendor,$cus['name'],$cus['phone_number'],$cus['email'],$cus['birthday'],$cus['visit_count']);
      $data['card_type'] = 'test';
      if($cus['card_number']!= null){
          $AssignCard = $this->iosUser->assignaCardForCustomer($this->vendor,$data['id'],$cus['card_number'],$cus['card_exp_date'],$cus['card_type'],$cus['card_issue']);
      }
      return  response($this->util->returnIoss($data3,0,'',sizeof($data)))
          ->header('Access-Control-Allow-Headers: origin, x-requested-with, content-type, x-total-count',sizeof($cus));
  }

  function deleteCusIosData(Request $request){
      $cus_id = json_decode($request->filter);

      $cus_id2 = json_decode(json_encode($cus_id),true);
//       return $this->util->returnIoss($cus_id2['id'][0],0,'',sizeof($cus_id2['id']));
//      exit();
      for($i = 0 ;$i< sizeof($cus_id2['id']);$i++){
          $this->iosUser->deleteCustomer($this->vendor,$cus_id2['id'][$i]);
      }

      $data2 = $this->iosUser->listIOSCustomer($this->vendor);
      return  response($this->util->returnIoss($data2,0,'',sizeof($data2)))->header('Access-Control-Allow-Headers: origin, x-requested-with, content-type, x-total-countt',sizeof($data2));
  }

  function assginCardForCus(Request $request){
    $data = $request->all();
    $this->iosUser->assignaCardForCustomer($this->vendor,$data['cus_id'],$data['card_number'],$data['card_exp'],$data['card_type'],$data['card_issue']);
      $data2 = $this->iosUser->listIOSCustomer($this->vendor);
      return  response($this->util->returnIoss($data2,0,'',sizeof($data2)))->header('Access-Control-Allow-Headers: origin, x-requested-with, content-type, x-total-count',sizeof($data2));

  }

  function unsignCardForCus(Request $request){
      $data = $request->all();
      $this->iosUser->unsignCard($this->vendor,$data['card_number']);
      $data2 = $this->iosUser->listIOSCustomer($this->vendor);
      return  response($this->util->returnIoss($data2,0,'',sizeof($data2)))->header('Access-Control-Allow-Headers: origin, x-requested-with, content-type, x-total-count',sizeof($data2));
  }

  function getcusById(Request $request){
      $cus_id = $request->cus_id;
      $data2 = $this->iosUser->getCusById($this->vendor,$cus_id);
      return  response($this->util->returnIoss($data2,0,'',sizeof($data2)))->header('Access-Control-Allow-Headers: origin, x-requested-with, content-type, x-total-count',sizeof($data2));


  }
}
