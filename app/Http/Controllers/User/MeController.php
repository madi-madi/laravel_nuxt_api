<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
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
            $user->created_at_human = $user->created_at->diffForHumans();
            $code = 200;
            
        }
        // $code = auth()->user()?200:401;
        return response()->json([
            'user'=> $user,
            'status'=> $status,
        ],$code);
    }
}
