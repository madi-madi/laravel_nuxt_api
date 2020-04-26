<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable =[
        'name',
        'slug',
        'owner_id',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function members()
    {
        return $this->belongsToMany(User::class)
                    ->withTimestamps();
    }

    public function designs()
    {
        return $this->hasMany(Design::class);
    }
    
    public function hasUser(User $user)
    {
        return $this->members()
                    ->where('user_id',$user)
                    ->first()?true:false;
    }
}
