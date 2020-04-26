<?php
namespace App\Repositories\Eloquent;

use App\Models\Team;
use App\Repositories\Contracts\ITeam;
use App\Repositories\Eloquent\BaseRepository;

class TeamRepository extends BaseRepository implements ITeam
{
   public function model()
   {
      $model = Team::class;
      return $model;
   }

   public function fetchUsersTeams()
   {
      return ;
   }


}