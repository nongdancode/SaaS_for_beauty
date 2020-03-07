<?php
/**
 * Created by IntelliJ IDEA.
 * User: letua
 * Date: 3/4/2020
 * Time: 5:16 PM
 */

namespace App\Model;
use Illuminate\Support\Facades\DB;

class GroupService extends MyModel
{
  function listServiceGroup($vendor){
      $data = DB::table('groupservice')
          ->where('vendor',$vendor)
          ->get();

      return $this->decodeStd($data);

  }

  function addGroupService($vendor,$name){
      $data = DB::table('groupservice')
          ->insertGetId(['name'=>$name,'vendor'=>$vendor]);
      return $data;

  }

  function editGroupService($vendor,$name){
      $data = DB::table('groupservice')
          ->where('vendor',$vendor)
          ->update(['name'=>$name]);

      return $data;
  }

    function deleteGroupService($vendor,$id){
        $data = DB::table('groupservice')
            ->where('vendor',$vendor)
            ->where('id',$id)
            ->delete();

        return $data;
    }

    function getGroupForService($vendor,$service_id){
        $data = DB::table('groupservice')

            ->join('groupservice_service','groupservice_service.groupservice_id','=','groupservice.id')
            ->select('groupservice.id as id','groupservice.name as name')
            ->where('groupservice_service.vendor',$vendor)
            ->where('groupservice_service.service_id',$service_id)
            ->get();
        return $this->decodeStd($data);
    }

    function assignGroupService($vendor,$service_id,$groupservice){
        $data = DB::table('groupservice_service')
            ->insertGetId(['service_id'=>$service_id,'groupservice_id'=>$groupservice,'vendor'=>$vendor]);


        return $this->decodeStd($data);
    }
}
