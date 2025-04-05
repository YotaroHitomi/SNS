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
            'user' => Auth::user()->id, // Auth::user()は、現在ログインしている人（つまりツイートしたユーザー）
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

public function search(Request $request)
{
    $follows = Auth::user()->follows;  // または必要なデータを取得
    return view('users.search', compact('follows'));
}

    public function showFollowers($userId)
    {
        $user = User::findOrFail($userId);
        $follows = $user->follow; // フォロワーリスト
        return view('user.follows', compact('follows'));
    }

    public function showFollowing($userId)
    {
        $user = User::findOrFail($userId);
        $following = $user->following; // フォローリスト
        return view('user.following', compact('following'));
    }

public function updateProfileImage(Request $request)
{
    $request->validate([
        'profile_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $path = $request->file('profile_image')->store('profile_images', 'public');

    auth()->user()->update([
        'profile_image' => $path,
    ]);

    return back()->with('status', 'プロフィール画像が更新されました！');
}


    // 特定のユーザーのプロフィールを表示
public function showProfile($userId)
{
    $profileUser = User::findOrFail($userId); // $profileUserを取得
    return view('users.profile', compact('profileUser')); // ビューに渡す
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

public function updateIcon(Request $request)
{
    $request->validate([
        'icon' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $user = auth()->user();
    $icon = $request->file('icon');
    $iconPath = $icon->store('icons', 'public');

    $user->update(['icon_path' => $iconPath]);

    return back()->with('success', 'Icon updated successfully!');
}

public function show($id)
{
    $user = User::findOrFail($id);
    $followingCount = $user->following->count(); // フォローしているユーザーの数を取得

return view('layouts.login', compact('user', 'followingCount'));
}

    // public function showFollowedPosts()
    // {
    //     // 現在のユーザーがフォローしているユーザーを取得
    //     $user = auth()->user();

    //     // フォローしているユーザーのIDを取得
    //     $followingIds = $user->following()->pluck('following_id');

    //     // フォローしているユーザーの投稿を取得
    //     $posts = Post::whereIn('user_id', $followingIds)->latest()->get();

    //     return view('followerList', compact('posts'));
    // }

}

// class UserController extends Controller
// {
//     public function index()
//     {
//         $users = User::where('id', '!=', auth()->id())->get();
//         return view('users.index', compact('users'));
//     }
// }
