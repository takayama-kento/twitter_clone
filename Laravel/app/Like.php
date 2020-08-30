<?php

namespace App;

use App\Tweet;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $fillable = [
        'user_id', 'tweet_id',
    ];

    /**
     * リレーションシップ - tweetsテーブル
     */
    public function tweet()
    {
        return $this->belongsTo(Tweet::class);
    }

    /**
     * リレーションシップ - usersテーブル
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
