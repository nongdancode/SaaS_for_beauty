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

}
