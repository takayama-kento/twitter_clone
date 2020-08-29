<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    /** JSONに含める属性 */
    protected $visible = [
        'user_id', 'followed_user_id'
    ];

    /**
     * リレーションシップ　
     */
}
