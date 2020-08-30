<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Follower extends Model
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
        'following_id', 'followed_id'
    ];
}
