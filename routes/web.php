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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/hello', function(){
    echo 'Hello World !';
});
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
Route::get('/top','PostsController@index');

Route::get('/profile','UsersController@profile');

Route::get('/search','UsersController@search');

Route::get('/follow-list','FollowsController@followList');
Route::get('/follower-list','FollowsController@followerList');

//表示用
Route::get('/post','PostController@create')->name('post.create');
//投稿を押した時
Route::post('/post','PostController@store')->name('post.store');

// Route::get('/book/{id}/update-form', 'PostsController@index');

Route::get('/hello', 'PostsController@hello');

Route::get('/update-form','PostsController@index');

Route::get('/hello', 'PostsController@hello');

// Route::⑭(⑮,⑯);

Route::get('/post/{id}/update-form', 'PostsController@updateForm');

//プロフィール閲覧で使用するユーザー情報の取得
Route::get('/user/{id}',[UserController::class,'get_user']);

//フォロー状態の確認
Route::get('/follow/status/{id}',[FollowsController::class,'check_following']);

//フォロー付与
Route::post('/follow/add',[FollowsController::class,'following']);

//フォロー解除
Route::post('/follow/remove',[FollowsController::class,'unfollowing']);

// Route::get('/create-form','PostsController@createForm');

// Route::post('/author/create','AuthorsController@authorCreate');

//この下に本の登録用のメソッドを使用するためのルーティングを設定してください。
// Route::⑭(⑮,⑯);

// Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
// Route::post('login', 'Auth\LoginController@login')->name('login.post');
// Route::get('logout', 'Auth\LoginController@logout')->name('logout');

});
