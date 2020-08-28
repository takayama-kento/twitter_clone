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
        $users = User::All();
        return $users;
    }
}
