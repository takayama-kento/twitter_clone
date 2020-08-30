<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    protected $primaryKey = [
        'following_id',
        'followed_id'
    ];
    protected $fillable = [
        'following_id',
        'followed_id'
    ];

    /** JSONに含める属性 */
    protected $visible = [
        'user_id', 'followed_user_id'
    ];

    /**
     * リレーションシップ　
     */
}
