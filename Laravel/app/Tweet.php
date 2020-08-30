<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Tweet extends Model
{
    /**
     * The attributes that are mass assignable
     * @var array
     */
    protected $fillable = [
        'tweet'
    ];

    /**
     * JSONに含めるアクセサ
     */
    protected $appends = [
        'formatted_created_at', 'likes_count', 'liked_by_user',
    ];

    /** JSONに含める属性 */
    protected $visible = [
        'id', 'tweet', 'author',
        'likes_count', 'liked_by_user',
        'formatted_created_at',
    ];

    /**
     * リレーションシップ - usersテーブル
     * @return \Illuminate\Database\Eloquent\Relations\Belongsto
     */
    public function author()
    {
        return $this->belongsTo('App\User', 'user_id', 'id', 'users');
    }

    /**
     * リレーションシップ - usersテーブル
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function likes()
    {
        return $this->belongsToMany('App\User', 'likes');
    }

    /**
     * アクセサ - formatted_created_at
     */
    public function getFormattedCreatedAtAttribute()
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->attributes['created_at'])->format('Y/m/d H:i');
    }

    /**
     * アクセサ - likes_count
     */
    public function getLikesCountAttribute()
    {
        return $this->likes->count();
    }

    /**
     * アクセサ - liked_by_user
     */
    public function getLikedByUserAttribute()
    {
        return $this->likes->contains(function ($user) {
            return $user->id === Auth::user()->id;
        });
    }
}
