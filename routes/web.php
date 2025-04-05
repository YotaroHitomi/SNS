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
Route::get('/top','PostsController@index');

Route::get('/profile','UsersController@profile');

Route::get('/top', 'PostsController@createForm');

Route::get('/search', 'UsersController@createForm');

Route::get('/search', 'UsersController@postTweet');

Route::post('/top','UsersController@userCreate');

//投稿内容登録用
Route::post('/top', 'PostsController@postCreate');

//検索用
Route::post('/search','PostsController@search');

Route::get('/search','UsersController@searchCreate');

Route::get('/search','UsersController@searchPost');

Route::get('/search','UsersController@index');

//更新フォーム表示用
Route::get('/post/{id}/update-form', 'PostsController@updateForm');

//登録用
Route::post('/top', 'PostsController@update');

//削除用
Route::get('/post/{id}/delete', 'PostsController@delete');

//フォローリスト表示用
Route::get('/follow-list','FollowsController@followList');

//フォロワーリスト表示用
Route::get('/follower-list','FollowsController@followerList');

Route::get('/profile/{id}','FollowsController@get_user');

//フォロー状態の確認
Route::get('/follow/status/{id}','FollowsController@check_following');

//フォロー付与
Route::post('/follow/add','FollowsController@following');

//フォロー解除
Route::post('/follow/remove','FollowsController@unfollowing');

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

Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');

Route::put('/posts/{id}', [PostController::class, 'update'])->name('posts.update');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/follow/{userId}', [FollowController::class, 'follow']);
    Route::delete('/unfollow/{userId}', [FollowController::class, 'unfollow']);
    Route::get('/following', [FollowController::class, 'following']);
    Route::get('/followers', [FollowController::class, 'followers']);
});


Route::get('/user/{userId}/followers', [ProfileController::class, 'showFollowers'])->name('user.followers');
Route::get('/user/{userId}/following', [ProfileController::class, 'showFollowing'])->name('user.following');
Route::get('/user/{userId}/profile', [ProfileController::class, 'showProfile'])->name('user.profile');
});


Route::middleware('auth')->group(function() {
    Route::post('/follow/{userId}', [UserController::class, 'follow'])->name('follow');
    Route::post('/unfollow/{userId}', [UserController::class, 'unfollow'])->name('unfollow');
    Route::get('/user/{userId}/followed', [UserController::class, 'showFollowedUsers'])->name('followed.users');
});
