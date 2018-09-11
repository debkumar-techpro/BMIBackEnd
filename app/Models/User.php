<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class User extends Model implements AuthenticatableContract, JWTSubject
{
    // attempt
    use Authenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'deleted_at'
    ];


    // jwt
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    // jwt 一
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * Get the posts for the user.
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
    public function courseParticipant($value='')
    {
        return $this->hasOne(CourseParticipant::class, 'user_id');
    }
}