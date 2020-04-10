<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;

class MeController extends Controller
{
    //
    public function getMe()
    {
        $status = TRUE;
        $user = null;
        $code = 401;

        if(auth()->check()){
            $user = auth()->user();
         return    new UserResource($user);
            //$user->created_at_human = $user->created_at->diffForHumans();
            $code = 200;
            
        }
        // $code = auth()->user()?200:401;
        return response()->json([
            'user'=> $user,
            'status'=> $status,
        ],$code);
    }
}
