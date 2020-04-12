<?php

namespace App\Http\Controllers\Designs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function upload(Request $request)
    {
        $this->validate($request,[
            'image'=>['require','image','mimes:png,jpg,gif,jpeg,bmp','max:2048']
        ]);
    }
}
