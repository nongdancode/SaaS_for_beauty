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

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $type = $request->data;
            if($type = '{"type":"mms"}'){
                $type2 = 'MMS_image/';
            }

            $name = time() . $file->getClientOriginalName();
            $filePath = $type2 . $name;
            $da = Storage::disk('s3')->put($filePath, file_get_contents($file),'public');
            return Storage::disk('s3')->url($filePath);
        }
    }



}
