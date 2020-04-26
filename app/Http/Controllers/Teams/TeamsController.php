<?php

namespace App\Http\Controllers\Teams;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TeamResource;
use App\Repositories\Contracts\ITeam;

class TeamsController extends Controller
{
    protected $teams;
    public function __construct(ITeam $teams) {
        $this->teams = $teams;
    }
    public function index()
    {
        //
    }


    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=>['required','string','max:80','unique:teams,name']
        ]);
         $data = [
            'name'=>$request->get('name'),
            'owner_id'=>auth()->id(),
            'slug'=> Str::slug($request->name)
         ];
        $team = $this->teams->create($data);
        return response()->json(
            [
                'message'=>trans('messages.success'),
                'errors'=>null,
                'item'=> new TeamResource($team),
            ]
        );
    }

    public function show($id)
    {
        //
    }

    public function fetchUsersTeams(Request $request)
    {
        //
    }
    public function findBySlug($slug)
    {
        //
    }
    

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
