<?php

namespace App\Http\Controllers\Teams;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TeamResource;
use App\Repositories\Contracts\{
    ITeam,
    IUser,
    IInvitation
};

class TeamsController extends Controller
{
    protected $teams;
    protected $users;
    protected $invitations;

    public function __construct(ITeam $teams, 
        IUser $users, IInvitation $invitations)
    {
        $this->teams = $teams;
        $this->users = $users;
        $this->invitations = $invitations;
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

    public function removeFromTeam($teamId, $userId)
    {
        // get the team
        $team = $this->teams->find($teamId);
        $user = $this->users->find($userId);

        // check that the user is not the owner
        if($user->isOwnedOfTeam($team)){
            return response()->json([
                'message' => 'You are the team owner'
            ], 401);
        }

        // check that the person sending the request
        // is either the owner of the team or the person
        // who wants to leave the team
        if(!auth()->user()->isOwnedOfTeam($team) && 
            auth()->id() !== $user->id
        ){
            return response()->json([
                'message' => 'You cannot do this'
            ], 401);
        }

        $this->invitations->removeUserFromTeam($team, $userId);

        return response()->json(['message' => 'Success'], 200);


    }
    public function findBySlug($slug)
    {
        $design = $this->designs->withCriteria([
                new IsLive(), 
                new EagerLoad(['user', 'comments'])
            ])->findWhereFirst('slug', $slug);
        return new DesignResource($design);
    }
}
