<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            "name"=> $this->name,
            "username"=> $this->username,
            "designs"=> DesignResource::collection($this->whenloaded('designs')),
            "email"=> $this->email,
            "email_verified_at"=> $this->email_verified_at,
            "tagline"=> $this->tagline,
            "about"=> $this->about,
            "location"=> $this->location,
            "formatted_address"=> $this->formatted_address,
            "available_to_hire"=> $this->available_to_hire,
            "created_at_dates"=> [
                "created_at"=> $this->created_at,
                "created_at_humans"=> $this->created_at->diffForHumans(),

            ],
            "updated_at"=> $this->updated_at,

        ];
        // return parent::toArray($request);
    }
}
