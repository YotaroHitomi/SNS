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

Route::post('/top','UsersController@userCreate');

//投稿内容登録用
Route::post('/top', 'PostsController@postCreate');

//検索用
Route::post('/search','PostsController@search');

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
Route::get('/follow/status/{id}','FollowController@check_following');

//フォロー付与
Route::post('/follow/add','FollowController@following');

//フォロー解除
Route::post('/follow/remove','FollowController@unfollowing');

Route::get('/top', 'PostsController@index')->name('timeline');
Route::post('/top', 'PostsController@postTweet')->name('timeline');

});
