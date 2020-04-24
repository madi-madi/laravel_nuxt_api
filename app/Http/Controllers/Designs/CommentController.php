<?php

namespace App\Http\Controllers\Designs;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Repositories\Contracts\{
    IComment,
    IDesign
};

class CommentController extends Controller
{
    protected $comments,$designs;
    public function __construct(IComment $comments , IDesign $designs)
    {
        $this->comments = $comments;
        $this->designs = $designs;
    }

    public function store(Request $request , $designId)
    {
        $this->validate($request,[
            'body'=>['required']
        ]);
         $data = [
            'body'=>$request->get('body'),
            'user_id'=>auth()->id()
         ];
        $comment = $this->designs->addComment($designId,$data);
        return response()->json(
            [
                'message'=>trans('messages.success'),
                'errors'=>null,
                'item'=> new CommentResource($comment),
            ]
        );
        
    }
}
