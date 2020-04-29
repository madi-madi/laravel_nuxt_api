<?php

namespace App\Http\Controllers\Teams;
use Mail;
use App\Models\Team;
use App\Mail\SendInvitationToJoinTeam;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\{
    ITeam,
    IInvitation,
    IUser
};
class InvitationsController extends Controller
{
    protected $invitations,$teams;
    public function __construct(IInvitation $invitations , ITeam $teams ,IUser $users)
    {
        $this->invitations = $invitations;
        $this->teams = $teams;
        $this->users = $users;
    }

    public function invite(Request $request ,$teamId)
    {
        // get the team
        $team = $this->teams->find($teamId);
        $message = '';
        $errors =null;
        $code = 200;
        $status = true;
        $this->validate($request,[
            'email'=>['required','email']
        ]);
        // check if the user owns the  team
        $user = auth()->user();
        if(! $user->isOwnedOfTeam($team)){
            $errors=['email'=>trans('mesaages.you_are_not_the_team_owner')];
            $code = 401;
            $message = trans('messages.error');
            $status = false;


        }

        // check if email has a pending invitation
        if($team->hasPendingInvite($request->email)){
            $errors=['email'=>trans('mesaages.email_already_has_a_pending_invite')];
            $code = 422;
            $message = trans('messages.error');
            $status = false;

        }
        // get the recipient by email
        $recipient = $this->users->findByEmail($request->email);

        // if recipient does not exist , send invitation to join the team
        if(! $recipient){
            $this->createInvitation(false,$team , $request->email);
            $message = trans('messages.invitation_sent_to_user');
        }

        // check if the team already has the user
        if($team->hasUser($recipient)){
            $errors=['email'=>trans('mesaages.this_user_seems_to_be_a_team_member_already')];
            $code = 422;
            $message = trans('messages.error');
            $status = false;
        }
        //send 
        $this->createInvitation(false,$team , $request->email);


        return response()->json([
            'status'=>$status,
            'message'=>$message,
            'errors'=>$errors
            ],$code);

    }

    public function resend($id)
    {
        # code...
    }

    public function createInvitation(bool $user_exist , Team $team , string $email)
    {
        $invitation =  $this->invitations->create([
            'team_id'=>$team->id,
            'sender_id'=>auth()->id(),
            'recipient_email'=>$email,
            'token'=>md5(uniqid(microtime())),
        ]);
        Mail::to($email)
            ->send(new SendInvitationToJoinTeam($invitation , $user_exist));
    }

}
