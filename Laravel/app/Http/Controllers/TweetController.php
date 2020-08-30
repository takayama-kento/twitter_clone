<?php

namespace App\Http\Controllers;

use App\User;
use App\Tweet;
use App\Like;
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

    /**
     * ツイート詳細
     * @param int $tweet_id
     * @return Tweet
     */
    public function show(int $tweet_id)
    {
        $tweet = Tweet::with(['author', 'likes'])->where('id', $tweet_id)->first();

        if (! $tweet) {
            abort(404);
        }

        return $tweet;
    }

    /**
     * いいね
     * @param int $tweet_id
     * @return array
     */
    public function like(int $tweet_id)
    {
        Like::create([
            'user_id' => Auth::user()->id,
            'tweet_id' => $tweet_id
        ]);


        return ["tweet_id" => $tweet_id];
    }

    /**
     * いいね解除
     * @param int $tweet_id
     * @return array
     */
    public function unlike(int $tweet_id)
    {
        $like = Like::where('tweet_id', $tweet_id)->where('user_id', Auth::user()->id)->first();

        if (! $like) {
            abort(404);
        }

        $like->delete();

        return ["tweet_id" => $tweet_id];
    }
}
