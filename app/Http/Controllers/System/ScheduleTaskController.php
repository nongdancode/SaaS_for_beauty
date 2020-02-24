<?php
/**
 * Created by IntelliJ IDEA.
 * User: letua
 * Date: 2/20/2020
 * Time: 7:36 AM
 */

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Lib\MyUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Input;

class ScheduleTaskController extends Controller
{

    protected $staffServices;
    protected $staffId ;


    function __construct(Request $request)
    {

        $this ->staffId = $request->input('staffId');
        $this->util = new MyUtils();




    }
   function getServicesOfStaffForScheduling(){
       return $this->staffId;
   }

}
