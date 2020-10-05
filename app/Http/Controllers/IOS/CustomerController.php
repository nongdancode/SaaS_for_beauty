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
  private $config;

    function __construct(Request $request){
        $this->util = new MyUtils();
        $this->iosUser = new CustomerIOS();
        $this->customer = new Customer();
        $this->config = new ConfigVendorModel();
    }
  function listDataForIOS(Request $request){
      $data = $request->all();
      $cus_id = json_decode($request->filter);
      $cus_id2 = json_decode(json_encode($cus_id),true);

//      return  response($this->util->returnIoss(isset($cus_id2['name']),0,'',sizeof($data)))->header('Access-Control-Allow-Headers: origin, x-requested-with, content-type, x-total-count',sizeof($data));
     if(isset($cus_id2['name']) && isset($cus_id2['phone_number'])){
        $data = $this->iosUser->filterByPhoneAndName($this->vendor,$cus_id2['phone_number'],$cus_id2['name']);
         return  response($this->util->returnIoss($data,0,'',sizeof($data)))
             ->header('Access-Control-Allow-Headers: origin, x-requested-with, content-type, x-total-count',sizeof($data));
     }
     if(isset($cus_id2['name'])){
         $data = $this->iosUser->filterByName($this->vendor,$cus_id2['name']);
         return  response($this->util->returnIoss($data,0,'',sizeof($data)))
             ->header('Access-Control-Allow-Headers: origin, x-requested-with, content-type, x-total-count',sizeof($data));
     }
     if(isset($cus_id2['phone_number'])){
         $data = $this->iosUser->filterByPhone($this->vendor,$cus_id2['phone_number']);
         return  response($this->util->returnIoss($data,0,'',sizeof($data)))
             ->header('Access-Control-Allow-Headers: origin, x-requested-with, content-type, x-total-count',sizeof($data));
     }
      if(isset($cus_id2['last_visit'])){
          $data = $this->iosUser->filterByLastVisit($this->vendor,$cus_id2['last_visit']);
          return  response($this->util->returnIoss($data,0,'',sizeof($data)))
              ->header('Access-Control-Allow-Headers: origin, x-requested-with, content-type, x-total-count',sizeof($data));
      }
      if(isset($cus_id2['card_exp_date'])){
          $data = $this->iosUser->filterByCardexp($this->vendor,$cus_id2['card_exp_date']);
          return  response($this->util->returnIoss($data,0,'',sizeof($data)))
              ->header('Access-Control-Allow-Headers: origin, x-requested-with, content-type, x-total-count',sizeof($data));
      }
     else{

         $data = $this->iosUser->listIOSCustomer($this->vendor);
         return  response($this->util->returnIoss($data,0,'',sizeof($data)))->header('Access-Control-Allow-Headers: origin, x-requested-with, content-type, x-total-count',sizeof($data));

     }
//      $data = $this->iosUser->listIOSCustomer($this->vendor);
//      return  response($this->util->returnIoss($data,0,'',sizeof($data)))->header('Access-Control-Allow-Headers: origin, x-requested-with, content-type, x-total-count',sizeof($data));

  }

  function updateCusIos(Request $request){
    $data = $request ->all();
    $cus = $this->iosUser->customerIOS($data);
    $err = "";

    $this->iosUser->AssigneCustomerForIOS($this->vendor,$data['name'],$data['phone_number'],$data['email'],$data['birthday'],$data['visit_count']);
    if($data['card_number']!= ""){
        $AssignCard = $this->iosUser->assignaCardForCustomer($this->vendor,$data['id'],$data['card_number'],$data['card_exp_date'],$data['card_type'],$data['card_issue']);
    }elseif ($cus['card_number']== ""){
        $this->iosUser->unsignCard($this->vendor,$cus['id']);
        $err = 'delete card success';
    }
     $data2 = $this->iosUser->listIOSCustomer($this->vendor);
      return  response($this->util->returnIoss("",0,$err,sizeof($data)))
          ->header('Access-Control-Allow-Headers: origin, x-requested-with, content-type, x-total-count',sizeof($cus));

  }
  function addNewCusIos(Request $request){
      $data = $request ->all();
      $cus = $this->iosUser->customerIOS($data);
      $data3 = $this->iosUser->AssigneCustomerForIOS($this->vendor,$cus['name'],$cus['phone_number'],$cus['email'],$cus['birthday'],$cus['visit_count']);
      $addedCus = $this->customer->getCusByPhoneVendor($this->vendor,$cus['phone_number']);
      if($cus['card_number']!= ""){
          $AssignCard = $this->iosUser->assignaCardForCustomer($this->vendor, $addedCus['id'],$cus['card_number'],$cus['card_exp_date'],$cus['card_type'],$cus['card_issue']);
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

  function setConfig(Request $request){
        $data = $request->all();
        $this->config->setConfig($this->vendor,$data['config']);
  }
    function getConfig(Request $request){
        $data = $request->all();
        $data2 = $this->config->getConfig($this->vendor);
        return response($this->util->returnIoss($data2,0,'',sizeof($data2)))->header('Access-Control-Allow-Headers: origin, x-requested-with, content-type, x-total-count',sizeof($data2));
    }

}
