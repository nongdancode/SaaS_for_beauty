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

use Intervention\Image\ImageManager;


class UploadController extends Controller
{
 protected $UploadImage;
    function __construct(Request $request)
    {
        $this->dataRequest =$request->all();
        $this->updateImage = New ImageManager();


    }

    /**
     * @param Request $request
     */
    public function updateImage(Request $request){
        // Logic for user upload of avatar



        $returnData = [];


        if($request->hasFile('file')){
            $file = $request->file('file');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $url2 = "lash_image\ ". $filename;
            $url =  public_path( $url2 );
            $this->updateImage->make($file)->resize(300, 300)->save( $url  );

            $returnData['url'] = $url2;
            $returnData['code']=0;

            return  $returnData;
        }
        else{
            $returnData['code']=1;
            return $returnData;
        }



    }

    function uploadImageRaw(Request $request){
        if ($request->hasFile('file')) {
            $image      = $request->file('file');
            $fileName   = time() . '.' . $image->getClientOriginalExtension();

            $img = Image::make($image->getRealPath());
            $img->resize(120, 120, function ($constraint) {
                $constraint->aspectRatio();
            });

            $img->stream(); // <-- Key point

            //dd();
            Storage::disk('local')->put('images/1/smalls'.'/'.$fileName, $img, 'public');
        }
    }
}
