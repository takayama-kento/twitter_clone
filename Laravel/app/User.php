<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $visible = [
        'id', 'name',
    ];

    public function followers()
    {
        return $this->belongsToMany(self::class, 'follows', 'followed_user_id', 'user_id');
    }

    public function follows()
    {
        return $this->belongsToMany(self::class, 'follows', 'user_id', 'follower_user_id');
    }

    public function tweets()
    {
        return $this->hasMany('App\Tweet');
    }
}
