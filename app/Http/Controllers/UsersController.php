<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\FollowUser;
use App\Post;
use App\Validator;

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

    public function profileupdate(Request $request){
        $validator = Validator::make($request->all(),[
          'username'  => 'required|min:2|max:12',
          'mail' => ['required', 'min:5', 'max:40', 'email', Rule::unique('users')->ignore(Auth::id())],
          'newpassword' => 'min:8|max:20|confirmed|alpha_num',
          'newpassword_confirmation' => 'min:8|max:20|alpha_num',
          'bio' => 'max:150',
          'iconimage' => 'image',
        ]);

        $user = Auth::user();
        //画像登録
        $image = $request->file('iconimage')->store('public/images');
        $validator->validate();
        $user->update([
            'username' => $request->input('username'),
            'mail' => $request->input('mail'),
            'password' => bcrypt($request->input('newpassword')),
            'bio' => $request->input('bio'),
            'images' => basename($image),
        ]);

        return redirect('/profile');
    }

    //     public function searchresult(Request $request)
    // {
    //     $searchTerm = $request->input('keyword');

    //     $results = User::where('column_name', 'LIKE', '%' . $searchTerm . '%')->get(); // 検索条件を設定

    //     return view('users.search', compact('results', 'searchTerm'));
    // }



    // 自分のフォロワーのリストを表示
    public function showFollowers($userId)
    {
        // ユーザーを取得
        $user = User::findOrFail($userId);

        // フォロワーリストを取得
        $followers = $user->followers;

        // フォロワーのプロフィールを表示
        return view('profile.followers', compact('user', 'followers'));
    }

    // フォローしているユーザーのリストを表示
    public function showFollowing($userId)
    {
        // ユーザーを取得
        $user = User::findOrFail($userId);

        // フォローしているユーザーのリストを取得
        $following = $user->following;

        // フォローしているユーザーのプロフィールを表示
        return view('profile.following', compact('user', 'following'));
    }

    // 特定のユーザーのプロフィールを表示
    public function showProfile($userId)
    {
        // ユーザーを取得
        $user = User::findOrFail($userId);

        // ユーザーのプロフィールページを表示
        return view('profile.show', compact('user'));
    }



    public function postCounts(){
  $posts = Post::get();
  return view('yyyy', compact('posts'));
}

public function follow($userId)
{
    $user = auth()->user(); // 現在ログインしているユーザー
    $followedUser = User::findOrFail($userId); // フォローするユーザー

    if ($user->id !== $followedUser->id) {
        $user->follows()->attach($followedUser->id);
    }

    return redirect()->back();
}

public function unfollow($userId)
{
    $user = auth()->user(); // 現在ログインしているユーザー
    $followedUser = User::findOrFail($userId); // フォローを外すユーザー

    $user->follows()->detach($followedUser->id);

    return redirect()->back();
}

public function showFollowedUsers($userId)
{
    $user = User::findOrFail($userId);
    $followedUsers = $user->follows; // フォローしているユーザーのリスト

    return view('user.followed', compact('followedUsers'));
}
}
