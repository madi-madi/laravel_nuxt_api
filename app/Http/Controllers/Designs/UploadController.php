<?php

namespace App\Http\Controllers\Designs;

use App\Jobs\UploadImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UploadController extends Controller
{
    public function upload(Request $request)
    {
        $this->validate($request,[
            'image'=>['required','image','mimes:png,jpg,gif,jpeg,bmp','max:2048']
        ]);
        // get the image
        $image = $request->file('image');
        $image_path = $image->getPathName();
        
        // get the original file name and replace any space with _under
        // example :  dev ibrahim.png = timestamp()dev_ibrahim.png
        $file_name = time()."_".preg_replace('/\$+/','_',strtolower($image->getClientOriginalName()));
        
        // move the image to the temporery location tem
        $tmp  = $image->storeAs('uploads/original',$file_name,'tmp');
        // create the database recored for the design
        $design = auth()->user()->designs()->create([
            'image'=>$file_name,
            'disk'=>\config('site.upload_disk'),
        ]);

        // dispatch a job to handle the image manipulation
        $this->dispatch(new UploadImage($design));

        return response()->json(
            [
                'message'=>trans('messages.success'),
                'errors'=>null,
                'item'=>$design,
            ]
        );

    }
}
