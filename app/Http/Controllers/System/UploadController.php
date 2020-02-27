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

    function __construct(Request $request)
    {
        $this->dataRequest =$request->all();


    }
    public function updateImage(Request $request){
        // Logic for user upload of avatar
        $returnData = [];

        if($request->hasFile('image')){
            $avatar = $request->file('image');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();
            $url =  public_path('/uploads/avatars/' . $filename );
           $image =  Image::make($avatar)->resize(300, 300)->save( public_path('/uploads/avatars/' . $filename ) );

           $returnData['url'] = $url;
            $returnData['code']=0;

           return  $url;
        }
        else{
            return $returnData['code']=1;
        }

    }
}
