<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/hello', function(){
//     echo 'Hello World !';
// });
// Route::get('/home', 'HomeController@index')->name('home');

//Auth::routes();


//ログアウト中のページ
Route::get('/login', 'Auth\LoginController@login');
Route::post('/login', 'Auth\LoginController@login');

Route::get('/register', 'Auth\RegisterController@register');
Route::post('/register', 'Auth\RegisterController@register');

Route::get('/added', 'Auth\RegisterController@added');
Route::post('/added', 'Auth\RegisterController@added');

//ログイン中のページ
Route::group(['middleware' => ['LoginUserCheck']], function() {

//投稿フォーム表示用
// Route::get('/top','PostsController@index');

Route::get('/profile','UsersController@profile');

// Route::get('/top', 'PostsController@createForm');

// Route::post('/top','UsersController@userCreate');

//検索用
Route::post('/search','PostsController@search');

Route::get('/search','UsersController@searchCreate');

Route::get('/search','UsersController@searchPost');

Route::get('/search','UsersController@index');

Route::get('/search', 'UsersController@createForm');

Route::get('/search', 'UsersController@postTweet');

//更新フォーム表示用
Route::get('/post/{id}/update-form', 'PostsController@updateForm');

//投稿内容登録用
Route::post('/top', 'PostsController@postCreate');

//登録用
Route::post('/top', 'PostsController@update');

//削除用
Route::get('/post/{id}/delete', 'PostsController@delete');

//フォローリスト表示用
Route::get('/follow-list','FollowsController@followList');

//フォロワーリスト表示用
Route::get('/follower-list','FollowsController@followerList');

Route::get('/profile/{id}','UsersController@profileupdate');

Route::get('/followList','UsersController@updateProfileImage');

Route::get('/followList','UsersController@showsProfile');

Route::get('/followList','UsersController@postCounts');

// フォロー機能
// Route::get('/followList','UsersController@follow');

// アンフォロー機能
// Route::get('/followList','UsersController@unfollow');

// フォロー、フォロワーリスト一覧表示用
// Route::get('/followList','UsersController@showFollowUsers');

// Route::get('/followList','UsersController@updateIcon');

// フォロー、フォロワーの投稿リスト表示
// Route::get('/followList','UsersController@showFollowedPosts');

//フォロー状態の確認
Route::get('/follow/status/{id}','FollowsController@check_following');

Route::get('/top', 'PostsController@index')->name('timeline');
Route::post('/top', 'PostsController@postTweet')->name('timeline');

// Route::get('/search', 'UsersController@searchresult')->name('search');

// ログイン状態
// Route::get('/search',);

//     // ユーザ関連
//     Route::get('/search', 'UsersController@index');

//     Route::get('/search', 'UsersController@show');

//     Route::get('/search', 'UsersController@edit');

//     // Route::get('/search', 'UsersController@update');

//     // フォロー/フォロー解除を追加
//     Route::post('users/{user}/follow', 'UsersController@follow')->name('follow');
//     Route::delete('users/{user}/unfollow', 'UsersController@unfollow')->name('unfollow');

Route::post('/posts/{post}', 'PostController@update')->name('posts.update');

Route::post('/posts/{id}', 'PostController@update')->name('posts.update');

// Route::post('/top', 'PostsController@postTweet')->name('timeline');

// フォローリストをユーザ検索欄で表示させる
Route::post('/followerList', 'UsersController@showsFollowers');

Route::post('/following', 'UsersController@showsFollowing');

Route::post('/profile', 'UsersController@showsProfile');
});

// フォロー、アンフォロー機能用
Route::middleware('auth')->group(function() {
    Route::post('/follow/{userId}', [UserController::class, 'follow'])->name('follow');

    Route::post('/unfollow/{userId}', [UserController::class, 'unfollow'])->name('unfollow');

    Route::get('/user/{userId}/followed', [UserController::class, 'showFollowedUsers'])->name('followed.users');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/followerList', [FollowController::class, 'index'])->name('followers.index');
});

Route::get('/followed-posts', [UserController::class, 'showFollowedPosts'])->name('followed.posts');

// Route::get('/follows', [FollowController::class, 'index'])->name('follows.index');

// Route::post('/follow/{id}', [FollowController::class, 'toggleFollow'])->name('follow.toggle');

// Route::get('/users', [UserController::class, 'index'])->name('users.index');

Route::get('/followed-posts', [PostController::class, 'followPosts'])->name('followed.posts');
