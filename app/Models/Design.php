<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Cviebrock\EloquentTaggable\Taggable;

class Design extends Model
{
    use Taggable;
    protected $fillable = [
        'user_id',
        'image',
        'title',
        'description',
        'slug',
        'close_to_comment',
        'is_live',
        'upload_successfull',
        'disk',
    ];
    // protected $appends = ['images'];
        public function comments()
        {
            return $this->morphMany(Comment::class,'commentable')
            ->orderBy('created_at','asc');;
        }
        public function user()
        {
            return $this->belongsTo(User::class);
        }

        public function getImagesAttribute()
        {
            $images = [
                'thumbnail'=> $this->getImagePath('thumbnail'),
                'larg'=> $this->getImagePath('large'),
                'original'=> $this->getImagePath('original')
            ];
            return $images;
        }

        protected function getImagePath($size)
        {
            $image_path = Storage::disk($this->disk)->url("uploads/designs/{$size}/".$this->image);
            return $image_path;
        }
}
