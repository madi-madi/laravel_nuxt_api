<?php

namespace App\Http\Resources;

use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class DesignResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id"=> $this->id,
            "title"=> $this->title,
            "slug"=> $this->slug,
            "is_live"=> $this->is_live,
            "images"=> $this->images,
            "likes_count"=> $this->likes()->count(),
            "description"=> $this->description,
            "tag_list"=> [
                "tags"=> $this->tagArray,
                "tags_normalizer"=> $this->tagArrayNormalized,
            ],
            "created_at_dates"=> [
                "created_at"=> $this->created_at,
                "created_at_humans"=> $this->created_at->diffForHumans(),
                
            ],
            "updated_at_dates"=> [
                "updated_at"=> $this->updated_at,
                "updated_at_humans"=> $this->updated_at->diffForHumans(),
                
            ],
            "team"=> $this->team?[
                'name'=>$this->team->name,
                'slug'=>$this->team->slug,
            ]:null, //new TeamResource($this->team),
            "comments"=>   CommentResource::collection($this->whenLoaded('comments')),
            "user"=> new  UserResource($this->whenLoaded('user')),

        ];    
        // return parent::toArray($request);
    }
}
