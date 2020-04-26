<?php

namespace App\Http\Controllers\Teams;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\{
    IDesign,
    IInvitation
};
class InvitationsController extends Controller
{
    protected $invitations,$designs;
    public function __construct(IInvitation $invitations , IDesign $designs)
    {
        $this->invitations = $invitations;
        $this->designs = $designs;
    }

    public function invite(Request $request ,$teamId)
    {
        # code...
    }

    public function resend($id)
    {
        # code...
    }

}
