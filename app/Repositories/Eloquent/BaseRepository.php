<?php

namespace App\Repositories\Eloquent;

use Exception;
use App\Models\User;
use App\Exceptions\ModelNotDefind;
use App\Repositories\Contracts\IBase;


abstract class BaseRepository implements IBase {
      protected $model;
      public function __construct()
      {
          $this->model = $this->getModelClass();
      }
      public function all()
      {
         $users= $this->model::all();
         return $users;
      }
      // get model class
      protected function getModelClass()
      {
         if(!method_exists($this,'model'))
         throw new ModelNotDefind();
         

         return app()->make($this->model());


      }
}