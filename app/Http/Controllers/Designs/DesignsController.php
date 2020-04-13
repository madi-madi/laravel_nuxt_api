<?php

namespace App\Http\Controllers\Designs;

use App\Models\Design;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DesignsController extends Controller
{
    public function update(Request $request , $id)
    {
        $this->validate($request,[
            'title'=>['required','unique:designs,title,'.$id],
            'description'=>['required','min:20','max:100']
        ]);

       $design = Design::find($id);
       $design->update([
           'title'=>$request->title,
           'description'=>$request->description,
           'slug'=>Str::slug($request->title),
           'is_live'=> ! $design->upload_successfull? false:$request->is_live,
       ]);

       return response()->json(
        [
            'message'=>trans('messages.success'),
            'errors'=>null,
            'item'=>$design,
        ]
    );
    }
}
