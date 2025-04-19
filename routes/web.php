<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\FollowsController;
use App\Http\Controllers\FollowController;

Route::get('/', 'HomeController@index'); // ホームページ

// ログインと登録のルート
Route::get('/login', 'Auth\LoginController@login');
Route::post('/login', 'Auth\LoginController@login');

Route::get('/register', 'Auth\RegisterController@register');
Route::post('/register', 'Auth\RegisterController@register');

// ログイン後のページ（ログイン状態を確認するミドルウェア）
Route::middleware(['LoginUserCheck'])->group(function() {

    // プロフィール関連
    Route::get('/profile', 'UsersController@profile')->name('users.profile');
    Route::get('/profile/{id}', 'UsersController@profileupdate');
    Route::post('/profile', 'UsersController@profileupdate'); // プロフィール更新のPOST

    // 投稿関連
    Route::get('/top', 'PostsController@index')->name('timeline');
    Route::post('/top', 'PostsController@postCreate'); // 投稿作成

    // 検索関連
    Route::get('/search', 'UsersController@searchCreate');
    Route::post('/search', 'UsersController@search'); // 検索処理

    // フォロー関連
    Route::get('/follow-list', 'FollowsController@followList');
    Route::get('/follower-list', 'FollowsController@followerList');
    Route::get('/follow/status/{id}', 'FollowsController@check_following');

    // フォロー/アンフォロー
    Route::post('/follow/{userId}', 'UsersController@follow')->name('user.follow');
    Route::post('/unfollow/{userId}', 'UsersController@unfollow')->name('user.unfollow');

    // フォローしているユーザーの投稿を表示
    Route::get('/followed-posts', 'PostsController@followPosts')->name('followed.posts');
    Route::get('/followed-posts/{userId}', 'PostsController@showFollowedPosts')->name('followed.posts.by.user');

    // 投稿の更新・削除
    Route::get('/post/{id}/update-form', 'PostsController@updateForm'); // 投稿更新フォーム
    Route::patch('/post/{id}/update', 'PostsController@update')->name('posts.update'); // 投稿更新処理
    Route::get('/post/{id}/delete', 'PostsController@delete'); // 投稿削除

    // プロフィール画像の更新
    Route::post('/profile/image', 'UsersController@updateProfileImage');

    // フォロー・フォロワー一覧表示
    Route::get('/followed-users', 'UsersController@showFollowedUsers');
    Route::get('/followers', 'UsersController@showFollowers');
});

// 投稿リソースルート
Route::resource('posts', 'PostsController');

// フォロワー一覧表示用
Route::get('/followerList', 'FollowController@index')->name('followers.index');

// 検索関連
Route::get('/search', 'UsersController@createForm')->name('users.search');
Route::post('/search', 'UsersController@search')->name('users.search.execute');

// フォロー/アンフォロー
Route::patch('/follow/{userId}', 'UsersController@toggleFollow')->name('toggleFollow');

// ユーザーのプロフィールページ
Route::get('/profile/{user}', 'UsersController@show')->name('users.show');
Route::get('/users/{user}', 'UsersController@followsProfile')->name('users.profile');

// ログアウト
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

// プロフィールページ更新
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', function () {
        return view('users.profile');
    })->name('users.profile.page');

    Route::put('/profile', 'UsersController@updateProfile')->name('profile.update');
});

// ユーザー関連のフォロー・フォロワー機能
Route::get('users/search', 'UsersController@search')->name('users.search');
Route::get('users/following', 'UsersController@followList')->name('users.following');
Route::get('users/followers', 'UsersController@followerList')->name('users.followers');
Route::patch('users/{user}/toggle-follow', 'UsersController@toggleFollow')->name('toggleFollow');

Route::post('/user/{user}/follow', 'UserController@follow')->name('user.follow');
Route::post('/user/{user}/unfollow', 'UserController@unfollow')->name('user.unfollow');

// 投稿ページ
Route::get('/posts', 'PostsController@index')->name('posts.index');
Route::post('/posts', 'PostsController@store')->name('posts.store');

Route::patch('posts/{post}', [PostsController::class, 'update'])->name('posts.update');
Route::delete('posts/{post}', [PostsController::class, 'destroy'])->name('posts.destroy');

// routes/web.php
Route::put('/posts/{post}', 'PostsController@update')->name('posts.update');

Route::delete('/posts/{post}', 'PostsController@destroy')->name('posts.destroy');

// フォロワー一覧（検索対応）
Route::get('/followers', 'UsersController@followers')->name('followers.index');

// フォロー/アンフォロー切替（PATCHで受ける）
Route::patch('/follow/{userId}', 'UsersController@toggleFollow')->name('toggleFollow');

// プロフィールページへのリンク（ユーザーIDで遷移）
Route::get('/users/{user}', 'UsersController@followsProfile')->name('users.profile');

Route::get('/following', [UsersController::class, 'following'])->name('users.search');
