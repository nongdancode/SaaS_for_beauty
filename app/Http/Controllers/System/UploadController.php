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

use Illuminate\Support\Facades\Storage;
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


        if($request->hasFile('file') ){
            $file = $request->file('file');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $url2 = "lash_image". $filename;
            $url =  public_path("lash_image/". $filename );
            $this->updateImage->make($file)->resize(300, 300)->save( $url  );

            $returnData['data'] = $url;
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

    function upImageToS3(Request $request)
    {
        $returnData = [];


        if($request->hasFile('file')){
            $file = $request->file('file');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $image_normal = Image::make($file)->widen(800, function ($constraint) {
                $constraint->upsize();
            });
            $image_thumb = Image::make($file)->crop(100,100);
            $image_normal = $image_normal->stream();
            $image_thumb = $image_thumb->stream();
            $path = "lash_image/";

            Storage::disk('s3')->put($path.$file, $image_normal->__toString());
            Storage::disk('s3')->put($path.'thumbnails/'.$file, $image_thumb->__toString());
            $this->updateImage->make($file)->resize(300, 300)->save( $url  );

            $returnData['url'] = $path;
            $returnData['code']=0;

            return  $returnData;
        }
        else{
            $returnData['code']=1;
            return $returnData;
        }
}

function testS3(){
    $my_file = 'file.txt';
    $handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file);
    $data = 'Test data to see if this works!';
    fwrite($handle, $data);

    $storagePath = Storage::disk('s3')->put("uploads", $my_file, 'public');
}
}
