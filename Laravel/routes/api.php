<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// 会員登録
Route::post('/register', 'Auth\RegisterController@register')->name('register');

// ログイン
Route::post('/login', 'Auth\LoginController@login')->name('login');

// ログアウト
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

// ログインユーザー
Route::get('/user', fn() => Auth::user())->name('user');

// ユーザー一覧
Route::get('/users', 'UserController@index')->name('user.index');

// ユーザー詳細
Route::get('/users/{id}', 'UserController@show')->name('user.show');

// ユーザー詳細用のツイート一覧
Route::get('/users/{id}/tweets', 'UserController@tweets')->name('user.tweets');

// フォロー
Route::put('/users/{id}/follow', 'UserController@follow')->name('user.follow');

// フォロー解除
Route::delete('/users/{id}/follow', 'UserController@unfollow')->name('user.unfollow');

// ツイート投稿
Route::post('/tweet/create', 'TweetController@create')->name('tweet.create');

// ツイート一覧
Route::get('/tweets', 'TweetController@index')->name('tweet.index');

// ツイート詳細
Route::get('/tweets/{tweet_id}', 'TweetController@show')->name('tweet.show');