<?php
/* 
PHP only supports single inheritance: a child class can inherit only from one single parent.

So, what if a class needs to inherit multiple behaviors? OOP traits solve this problem.

Traits are used to declare methods that can be used in multiple classes.
 Traits can have methods and abstract methods that can be used in multiple classes,
 and the methods can have any access modifier (public, private, or protected)
*/
namespace App\Models\Traits;
use App\Models\Like;

trait Likeable {
    public static function bootLikeable()
    {
        static::deleting(function($model){
            $model->removeLikes();
        });
    }

    // delete likes when model is being deleted
    public function removeLikes()
    {
        if($this->likes()->count()){
            $this->likes()->delete();
        }
    }
      public function likes()
      {
         return $this->morphMany(Like::class,'likeable');                               
      }

      public function like()
      {
                          //          return $this->morphMany(Like::class,'likeable');   
                          if(! auth()->check())
                          return;
                    // check if the current user has already liked the model
                    if($this->isLikedByUser(auth()->id()))
                    return;

                    $like = $this->likes()->create(['user_id' => auth()->id()]);

                    return $like;



      }

      public function unlike()
      {
                    //          return $this->morphMany(Like::class,'likeable');   
                    if(! auth()->check())
                    return;
                    $user_id_auth = auth()->id();
                    // check if the current user has already liked the model
                    if(! $this->isLikedByUser($user_id_auth))
                    return;

                    $this->likes()->where('user_id',$user_id_auth)->delete();

      }
      public function isLikedByUser($user_id)
      {
           return $this->likes()
           ->where('user_id',$user_id)
           ->count();
      }
}