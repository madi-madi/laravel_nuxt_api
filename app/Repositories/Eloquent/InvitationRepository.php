<?php
namespace App\Repositories\Eloquent;

use App\Models\Invitation;
use App\Repositories\Contracts\IInvitation;
use App\Repositories\Eloquent\BaseRepository;

class InvitationRepository extends BaseRepository implements IInvitation
{
   public function model()
   {
      $model = Invitation::class;
      return $model;
   }
}