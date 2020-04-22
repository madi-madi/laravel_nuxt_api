<?php
namespace App\Repositories\Eloquent;

use App\Models\Design;
use App\Repositories\Contracts\IDesign;
use App\Repositories\Eloquent\BaseRepository;

class DesignRepository extends BaseRepository implements IDesign
{
   public function model()
   {
      $model = Design::class;
      return $model;
   }

   public function allLive()
   {
      $result = $this->model->where('is_live',true)->get();
      return $result;
   }
   public function applyTags($id , $data)
   {
      $design = $this->find($id);
      $design->retag($data);
   }
}