<?php
namespace App\Repositories\Eloquent;

use App\Models\Design;
use Illuminate\Http\Request;
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
   public function addComment($designId ,array $data)
   {
      //get the design for which we want to create comment
      $design = $this->find($designId);
      // create comment for a design
      $comment = $design->comments()->create($data);
      return $comment;
   }

   public function like($id)
   {
      $design = $this->model->findOrFail($id);
      if($design->isLikedByUser(auth()->id()))
      $design->unlike();
      else
      $design->like();
   }

   public function isLikedByUser($id)
   {
      $design = $this->model->findOrFail($id);
       return $design->isLikedByUser(auth()->id());
   }

   public function search(Request $request)
   {
       $query = (new $this->model)->newQuery();
       $query->where('is_live', true);
       // return only designs with comments
       if($request->has_comments){
           $query->has('comments');
       }
       // return only designs assigned to teams
       if($request->has_team){
           $query->has('team');
       }
       // search title and description for provided string
       if($request->q){
           $query->where(function($q) use ($request){
               $q->where('title', 'like', '%'.$request->q.'%')
                   ->orWhere('description', 'like', '%'.$request->q.'%');
           });
       }
       // order the query by likes or latest first
       if($request->orderBy=='likes'){
           $query->withCount('likes') // likes_count
               ->orderByDesc('likes_count');
       } else {
           $query->latest();
       }
       return $query->with('user')->get();
   }
}