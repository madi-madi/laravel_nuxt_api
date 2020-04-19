<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Repositories\Contracts\IUser;

class UserController extends Controller
{
    protected $users;
    public function __construct(IUser $users)
    {
        $this->users = $users;
    }
    public function index(Request $request)
    {
        $users= $this->users->all();
        return response()->json(
            [
                'message'=>trans('messages.success'),
                'errors'=>null,
                'items'=>  UserResource::collection($users),
            ]
            ,200);
    }
}
