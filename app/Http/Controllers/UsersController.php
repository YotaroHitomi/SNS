<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\FollowUser;
use App\Post;

class UsersController extends Controller
{
    //
    public function profile(){
        return view('users.profile');
    }

        public function createForm()
    {
        $users = User::get(); //Userモデル（usersテーブル）からレコード情報を取得
        return view('posts.index',['users'=>$users]);
    }

    public function postTweet(Request $request)
    {

        Post::create([
            'user_id' => Auth::user()->id, // Auth::user()は、現在ログインしている人（つまりツイートしたユーザー）
            'post' => $request->post, // ツイート内容
        ]);
        return back();
    }

    //登録用
    public function userCreate(Request $request)
    {

        $request->validate([
              'userName' => 'required|unique:users,name|max:10',
        ]);
        $name = $request->input('usersName');
        User::create(['name' => $name]);
        return back();
    }

        public function index(){
    {
        $posts = Post::get();

        return view('users.search', ['posts' => $posts]);
    }
    }

        public function searchCreate()
    {
        $users = User::get(); //Userモデル（usersテーブル）からレコード情報を取得
        return view('users.search',['users'=>$users]);
    }

    public function searchPost (Request $request)
    {

        Post::create([
            // 'user_id' => Auth::user()->id, // Auth::user()は、現在ログインしている人（つまりツイートしたユーザー）
            'post' => $request->post, // ツイート内容
        ]);
        return back();
    }
}
