<?php


namespace App\Http\Controllers\System;


use App\Http\Controllers\Controller;
use App\Lib\MyUtils;
use Illuminate\Http\Request;

class BookingManagementController extends Controller
{
    protected $util;
    protected $Vendor_id = 1;
    function __construct(Request $request){
        $this->util = new MyUtils();

    }
    function ListActiveBooking(){


    }



}
