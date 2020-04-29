<?php
namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Contracts\IUser;
use App\Repositories\Eloquent\BaseRepository;

class UserRepository extends BaseRepository implements IUser
{
   public function model()
   {
      $model = User::class;
      return $model;
   }

   public function findByEmail($email)
   {
      return $this->model->where('email',$email)->first();
   }

}