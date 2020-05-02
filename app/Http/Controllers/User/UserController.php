<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Repositories\Contracts\IUser;
use App\Repositories\Eloquent\Criteria\EagerLoad;

class UserController extends Controller
{
    protected $users;
    public function __construct(IUser $users)
    {
        $this->users = $users;
    }
    public function index(Request $request)
    {
        $users= $this->users->
        withCriteria([
            new EagerLoad(['designs'])

        ])->
        all();
        return response()->json(
            [
                'message'=>trans('messages.success'),
                'errors'=>null,
                'items'=>  UserResource::collection($users),
            ]
            ,200);
    }

    public function search(Request $request)
    {
        $designers = $this->users->search($request);
        $designers = UserResource::collection($designers);
        return response()->json(
            [
                'message'=>trans('messages.success'),
                'status'=>(bool)$designers,
                'errors'=>null,
                'items'=>  UserResource::collection($designers),
            ]
            ,200);
    }

    public function findByUsername($username)
    {
        $user = $this->users->findWhereFirst('username', $username);
        return response()->json(
            [
                'message'=>trans('messages.success'),
                'status'=>(bool)$user,
                'errors'=>null,
                'item'=>  new UserResource($user),
            ]
            ,200);
    }
}
