<?php
/**
 * Created by IntelliJ IDEA.
 * User: letua
 * Date: 2/26/2020
 * Time: 9:32 AM
 */

namespace App\Http\Controllers\System;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Image;

class UploadController extends Controller
{
 protected $UploadImage;
    function __construct(Request $request)
    {
        $this->dataRequest =$request->all();
        $this->updateImage = New Image();


    }
    public function updateImage(Request $request){
        // Logic for user upload of avatar
        $returnData = [];


        if($request->hasFile('image')){
            $avatar = $request->file('image');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();
            $url =  public_path('/uploads/avatars/' . $filename );
            $this->updateImage->make($avatar)->resize(300, 300)->save( public_path('/uploads/avatars/' . $filename ) );

           $returnData['url'] = $url;
            $returnData['code']=0;

           return  $returnData;
        }
        else{
          $returnData['code']=1;
            return $returnData;
        }

    }
}
