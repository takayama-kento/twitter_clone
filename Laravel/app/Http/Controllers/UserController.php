<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        // 認証が必要
        $this->middleware('auth');
    }

    /**
     * ユーザー一覧
     */
    public function index()
    {
        $users = User::get();
        return response()->json(['data' => $users]);
    }

    /**
     * フォロー
     * @param int $id
     * @return array
     */
    public function follow(int $id)
    {
        $followed_user = User::where('id', $id)->with('followers')->first();

        if (! $followed_user) {
            abort(404);
        }

        $followed_user->followers()->detach(Auth::user()->id);
        $followed_user->followers()->attach(Auth::user()->id);

        return ["user_id" => $id];
    }

    /**
     * フォロー解除
     */
    public function unfollow(int $id) {
        $followed_user = User::where('id', $id)->with('followers')->fisrt();

        if (! $followed_user) {
            abort(404);
        }

        $followed_user->followers()->detach(Auth::user()->id);

        return ["user_id" => $id];
    }
}
