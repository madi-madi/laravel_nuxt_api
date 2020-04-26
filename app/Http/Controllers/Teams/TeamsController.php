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
            ],200
        );
    }

    public function show($id)
    {
        $team = $this->teams->find($id);
        return response()->json(
            [
                'message'=>trans('messages.success'),
                'errors'=>null,
                'item'=> new TeamResource($team),
            ],200
        );
    }

    public function fetchUsersTeams(Request $request)
    {
        $teams = $this->teams->fetchUsersTeams();
        return response()->json(
            [
                'message'=>trans('messages.success'),
                'errors'=>null,
                'item'=> TeamResource::collection($team),
            ],200
        );
    }
    public function findBySlug($slug)
    {
        //
    }
    

    public function update(Request $request, $id)
    {
        $team = $this->teams->find($id);
        $this->authorize('update', $team);

        $this->validate($request, [
            'name' => ['required','string','max:80','unique:teams,name,'.$id]
        ]);
        $team = $this->teams->update($id, [
            'name' => $request->name
        ]);

        return response()->json(
            [
                'message'=>trans('messages.success'),
                'errors'=>null,
                'item'=> new TeamResource($team),
            ]
        );
    }

    public function destroy($id)
    {
        //
    }
}
