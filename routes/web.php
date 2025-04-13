<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\FollowsController;
use App\Http\Controllers\FollowController;

Route::get('/', [HomeController::class, 'index']);

// ログインと登録のルート
Route::get('/login', 'Auth\LoginController@login');
Route::post('/login', 'Auth\LoginController@login');

Route::get('/register', 'Auth\RegisterController@register');
Route::post('/register', 'Auth\RegisterController@register');

Route::get('/added', 'Auth\RegisterController@added');
Route::post('/added', 'Auth\RegisterController@added');

// ログイン中のページ (ログイン状態を確認するミドルウェア)
Route::middleware(['LoginUserCheck'])->group(function() {

    // プロフィール関連
    Route::get('/profile', [UsersController::class, 'profile'])->name('users.profile');
    Route::get('/profile/{id}', [UsersController::class, 'profileupdate']);
    Route::post('/profile', [UsersController::class, 'profileupdate']); // プロフィール更新のPOST

    // 投稿関連
    Route::get('/top', [PostsController::class, 'index'])->name('timeline');
    Route::post('/top', [PostsController::class, 'postCreate']); // 投稿作成

    // 検索関連
    Route::get('/search', [UsersController::class, 'searchCreate']);
    Route::post('/search', [UsersController::class, 'search']); // 検索処理

    // フォロー関連
    Route::get('/follow-list', [FollowsController::class, 'followList']);
    Route::get('/follower-list', [FollowsController::class, 'followerList']);
    Route::get('/follow/status/{id}', [FollowsController::class, 'check_following']);

    // フォロー/アンフォロー
    Route::post('/follow/{userId}', [UsersController::class, 'follow'])->name('user.follow');
    Route::post('/unfollow/{userId}', [UsersController::class, 'unfollow'])->name('user.unfollow');

    // フォローしているユーザーの投稿を表示
    Route::get('/followed-posts', [PostsController::class, 'followPosts'])->name('followed.posts');
    Route::get('/followed-posts/{userId}', [PostsController::class, 'showFollowedPosts'])->name('followed.posts.by.user');

    // 投稿の更新・削除
    Route::get('/post/{id}/update-form', [PostsController::class, 'updateForm']); // 投稿更新フォーム
    Route::patch('/post/{id}/update', [PostsController::class, 'update'])->name('posts.update'); // 投稿更新処理
    Route::get('/post/{id}/delete', [PostsController::class, 'delete']); // 投稿削除

    // プロフィール画像の更新
    Route::post('/profile/image', [UsersController::class, 'updateProfileImage']);

    // フォロー・フォロワー一覧表示
    Route::get('/followed-users', [UsersController::class, 'showFollowedUsers']);
    Route::get('/followers', [UsersController::class, 'showFollowers']);
});

Route::middleware(['auth'])->group(function () {
    // フォロー・アンフォロー機能
    Route::post('/follow/{userId}', [UsersController::class, 'follow'])->name('follow');
    Route::post('/unfollow/{userId}', [UsersController::class, 'unfollow'])->name('unfollow');

    // フォローしているユーザーを表示
    Route::get('/followed-users/{userId}', [UsersController::class, 'showFollowedUsers'])->name('followed.users');
});

// リソースルート（投稿）
Route::resource('posts', PostsController::class);

// 特定のフォロー・フォロワーの表示
Route::get('/followed-posts', [UsersController::class, 'showFollowedPosts'])->name('followed.posts');

// フォロワー一覧表示用
Route::get('/followerList', [FollowController::class, 'index'])->name('followers.index');

Route::get('/search', [UsersController::class, 'createForm'])->name('users.search'); // ← これが必要
Route::post('/search', [UsersController::class, 'search'])->name('users.search.execute');

Route::patch('/follow/{userId}', [UsersController::class, 'toggleFollow'])->name('toggleFollow');

Route::middleware(['auth'])->group(function() {
    // ユーザーのプロフィールページ
    Route::get('/profile/{user}', [UsersController::class, 'show'])->name('users.show');
});

Route::get('/users/{user}', [UsersController::class, 'followsProfile'])->name('users.profile');

Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

Route::middleware(['auth'])->group(function () {
    // プロフィール表示
Route::get('/profile', function () {
    return view('users.profile');
})->name('users.profile.page');

    // プロフィール更新
    Route::put('/profile', [UsersController::class, 'updateProfile'])->name('profile.update');
});

Route::get('/profile/{user}', [UsersController::class, 'show'])->name('users.profile');

Route::middleware(['auth'])->group(function () {
    // プロフィール関連
    Route::get('/profile', [UsersController::class, 'profile'])->name('users.profile');
    Route::post('/profile/update', [UsersController::class, 'profileupdate'])->name('users.profile.update'); // プロフィール更新
});

Route::middleware(['auth'])->group(function () {
    // ユーザーのプロフィールページ表示
    Route::get('/users/{user}', [UsersController::class, 'show'])->name('users.show');
});

Route::get('/index', [PostsController::class, 'index'])->name('index');

Route::post('/posts', [PostsController::class, 'postCreate'])->name('posts.create');

Route::post('/posts', [PostsController::class, 'postCreate'])->name('posts.create');

Route::get('/create-form', [UsersController::class, 'createForm']);

Route::get('/create-form', [UsersController::class, 'createForm']);

Route::get('users/search', [UsersController::class, 'search'])->name('users.search');
Route::get('users/following', [UsersController::class, 'followList'])->name('users.following');
Route::get('users/followers', [UsersController::class, 'followerList'])->name('users.followers');
Route::patch('users/{user}/toggle-follow', [UsersController::class, 'toggleFollow'])->name('toggleFollow');

Route::post('/user/{user}/follow', [UserController::class, 'follow'])->name('user.follow');

Route::post('/user/{user}/unfollow', [UserController::class, 'unfollow'])->name('user.unfollow');

// posts.indexページにアクセスするためのルート
Route::get('/posts', [PostsController::class, 'index'])->name('posts.index');

// 投稿を保存するためのルート
Route::post('/posts', [PostsController::class, 'store'])->name('posts.store');

Route::post('posts.store', [PostsController::class, 'postTweet'])->name('posts.store');

Route::post('/posts', [PostsController::class, 'store'])->name('posts.store');
