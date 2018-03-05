<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    /**
     * The Users that being followed.
     */
    public function following()
    {
        return $this->belongsToMany('App\User', 'user_follow', 'user_id', 'following');
    }

    public function followers()
    {
        return $this->belongsToMany('App\User', 'user_follow', 'following', 'user_id' );
    }

    public function group()
    {
        return $this->belongsTo('App\Group');
    }
}
