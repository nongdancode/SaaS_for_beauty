<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Lib\MyUtils;
use App\Model\MyModel;

use App\Http\Controllers\Controller;
use App\Model\ServicesVendor;
use App\Lib\SMSTwillo;
class AppointmentController extends Controller
{


    protected $util;
    protected $fromDate;
    protected $toDate;
    protected $commonModel;
    public function __construct()
    {

        $this->commonModel = new ServicesVendor();
        $this->util = new MyUtils();
    }



    public function getReadyServices(){

       $data = $this->commonModel->getAllServicesByVendor(1);

    }

}
