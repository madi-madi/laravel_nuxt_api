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
      public function find($id)
      {
         $result = $this->model->findOrFail($id);
         return $result;
      }
      public function findWhere($column,$value){
         $result = $this->model->where($column,$value)->get();
         return $result;
      }
      public function findWhereFirst($column,$value){
        $result = $this->model->where($column,$value)->firstOrFail();
        return $result;
      }
      public function paginate($perPage=10){
        $result = $this->model->paginate($perPage);
        return $result;
      }
      public function create(array $data)
      {
        $result = $this->model->create($data);
        return $result;
      }
      public function update($id , array $data)
      {
         $result = $this->find($id);
         $result->update($data);
         return $result;
      }
      public function delete($id){}
      // get model class
      protected function getModelClass()
      {
         if(!method_exists($this,'model'))
         throw new ModelNotDefind();
         

         return app()->make($this->model());


      }
}