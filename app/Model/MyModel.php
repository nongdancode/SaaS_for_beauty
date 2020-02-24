<?php
/**
 * Created by IntelliJ IDEA.
 * User: letua
 * Date: 1/27/2020
 * Time: 7:05 AM
 */

namespace App\Model;
use App\Lib\MyUtils;
use Illuminate\Database\Eloquent\Model;
class MyModel extends Model
{

     public function decodeStd($object){
         $object2 = MyUtils::decodeObjectStdJson($object);
         return $object2;
     }
}
