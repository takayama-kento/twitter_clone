<?php

namespace App\Http\Controllers;

use App\User;
use App\Tweet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TweetController extends Controller
{
    public function __construct()
    {
        // 認証が必要
        $this->middleware('auth');
    }

    /**
     * ツイート投稿
     */
    public function create(Request $request)
    {
        $tweet = new Tweet();
        $tweet->tweet = $request->get('tweet');
        $tweet->user_id = $Auth::user()->id;
    }
}
