<?php

namespace App\Http\Controllers;

use App\User;
use App\Tweet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreateTweet;

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
    public function create(CreateTweet $request)
    {
        $tweet = new Tweet();
        $tweet->tweet = $request->get('tweet');
        $user = Auth::user();
        $tweet->user_id = $user->id;

        $user->tweets()->save($tweet);

        return response($tweet, 201);
    }

    /**
     * ツイート一覧
     */
    public function index()
    {
        $tweets = Tweet::with(['author'])
            ->orderBy(Tweet::CREATED_AT, 'desc')->get();
        
        return response()->json(['data' => $tweets]);
    }
}
