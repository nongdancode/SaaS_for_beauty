<?php
/**
 * Created by IntelliJ IDEA.
 * User: letua
 * Date: 3/3/2020
 * Time: 9:50 PM
 */

namespace App\Model;

use Illuminate\Support\Facades\DB;
class InternalTransaction  extends MyModel
{

 function saveTransactionForCheckout($vendorID,$cusId,$invoice_number,$discount,$service_id,$employee_id,$type_transaction,$status,$note,$amount){
     $data = DB::table('internaltransaction')
         ->insertGetId(['invoice_number'=>$invoice_number,'cus_id'=>$cusId,'vendor_id'=>$vendorID,'discount'=>$discount
         ,'service_id'=>$service_id ,'employee_id'=>$employee_id,'type_transaction'=>$type_transaction,'status'=>$status,
         'created_at'=>DB::raw('now()'),'note'=>$note,'amount'=>$amount]);

     return $data;
 }
      function listBillTransaction($vendor){
          $data = DB::table('internaltransaction')
              ->join('customer','customer.id','=','internaltransaction.cus_id')
              ->select('internaltransaction.type_transaction as type_transaction','internaltransaction.amount as total'
              ,'internaltransaction.note as note','customer.name as customer_name','customer.phone_number as customer_phone',
                  'internaltransaction.invoice_number as invoice_number', 'internaltransaction.created_at as created_at')
              ->where('internaltransaction.vendor_id',$vendor)
              ->where('internaltransaction.status','=','summary_bill')
              ->get();
          return $this->decodeStd($data);
 }

 function listPartBillTransaction($vendorId,$invoice){
     $data = DB::table('internaltransaction')
         ->join('service','service.id','=','internaltransaction.service_id')
         ->select('service.service_name as service_name','service.price as service_price','internaltransaction.invoice_number as invoice_number'
         ,'internaltransaction.discount as discount','internaltransaction.employee_id as employee_id','internaltransaction.service_id as service_id')
         ->where('internaltransaction.vendor_id',$vendorId)
         ->where('internaltransaction.status','=','split_bill')
         ->where('internaltransaction.invoice_number','=',$invoice)
         ->get();
     return $this->decodeStd($data);
 }



}
