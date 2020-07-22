<?php


namespace App\Lib;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;

class DataTableFunction
{

    public function AddcustomersByExcels($file){
        $excelfile = Excel::import(new UsersImport, storage_path($file));
        

    }

}
