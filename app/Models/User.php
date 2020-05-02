<?php

namespace App\Models;
use App\Notifications\VerifyEmail;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Auth\Notifications\ResetPassword;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject , MustVerifyEmail
{
    use Notifiable , SpatialTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    'name', 
    'email',
    'password',
    'username',
    'tagline',
    'about',
    'location',
    'avilable_to_hire',
    ];

    protected $spatialFields = [
        'location'
        ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    protected $appends=[
        'photo_url'
    ];

    public function getPhotoUrlAttribute()
    {
        return 'https://www.gravatar.com/avatar/'.md5(strtolower($this->email)).'.jpg?s=200&d=mm';
    }
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sendEmailVerificationNotification(){
        $this->notify(new VerifyEmail);
    }

        // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function sendResetPAsswordEmailNotification($token){
        $this->notify(new ResetPassword($token));
    }

    public function designs()
    {
        return $this->hasMany(Design::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
// team the user belongsTo
    public function teams()
    {
        return $this->belongsToMany(Team::class)
                    ->withTimestamps();
    }

    public function ownedTeams()
    {
        return $this->teams()
                    ->where('owner_id',$this->id);
    }

    public function isOwnedOfTeam($team)
    {
        return (bool)$this->teams()
                        ->where('id',$team->id)
                        ->where('owner_id',$this->id)
                        ->count();


    }

    public function invitations()
    {
        return $this->hasMany(Invitation::class, 'recipient_email', 'email');
    }

        // relationships for chat messaging
        public function chats()
        {
            return $this->belongsToMany(Chat::class, 'participants');
        }
    
        public function messages()
        {
            return $this->hasMany(Message::class);
        }
    
        public function getChatWithUser($user_id)
        {
            $chat = $this->chats()
                        ->whereHas('participants', function($query)  use ($user_id){
                            $query->where('user_id', $user_id);
                        })
                        ->first();
            return $chat;
        }
}
