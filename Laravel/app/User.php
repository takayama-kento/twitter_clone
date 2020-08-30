<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

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

    /**
     * JSONに含めるアクセサ
     */
    protected $appends = [
        'tweets_count',
        'followers_count', 'follows_count',
        'followed_by_user', 'following_to_user'
    ];

    /**
     * JSONに含める属性
     */
    protected $visible = [
        'id', 'name',
        'tweets_count',
        'followers_count', 'follows_count',
        'followed_by_user', 'following_to_user'
    ];

    public function followers()
    {
        return $this->belongsToMany(self::class, 'followers', 'followed_id', 'following_id');
    }

    public function follows()
    {
        return $this->belongsToMany(self::class, 'followers', 'following_id', 'followed_id');
    }

    /**
     * アクセサ - followers_count
     */
    public function getFollowersCountAttribute()
    {
        return $this->followers->count();
    }

    /**
     * アクセサ - following_count
     */
    public function getFollowsCountAttribute()
    {
        return $this->follows->count();
    }

    /**
     * アクセサ - followed_by_user
     */
    public function getFollowedByUserAttribute()
    {
        if (Auth::guest()) {
            return false;
        }

        return $this->follows->contains(function ($user) {
            return $user->id === Auth::user()->id;
        });
    }

    /**
     * アクセサ - following_to_user
     */
    public function getFollowingToUserAttribute()
    {
        if (Auth::guest()) {
            return false;
        }

        return $this->followers->contains(function ($user) {
            return $user->id === Auth::user()->id;
        });
    }

    public function tweets()
    {
        return $this->hasMany('App\Tweet')->orderBy('id', 'desc');
    }
    /**
     * アクセサ - tweets_count
     */
    public function getTweetsCountAttribute()
    {
        return $this->tweets->count();
    }
}
