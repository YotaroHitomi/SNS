<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Follow;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\User;

class FollowsController extends Controller
{
    public function __construct()
{
    $this->middleware('auth');
}

    // フォロー中ユーザーリスト
public function followList()
{
    $user = auth()->user();

    $followings = $user->followings()->where('users.id', '!=', $user->id)->get();
    $followers = $user->followers()->where('users.id', '!=', $user->id)->get();

    if ($followings->isEmpty()) {
        $posts = collect();
    } else {
        $posts = Post::whereIn('user_id', $followings->pluck('id'))->get();
    }

    return view('follows.followList', compact('followings', 'followers', 'posts'));
}

    // フォローする
    public function follow(User $user)
    {
        if ($user->id != auth()->id()) {
            auth()->user()->followings()->attach($user->id); // フォローする
        }
        return redirect()->route('users.profile', $user->id); // プロフィールにリダイレクト
    }

    // フォローを外す
    public function unfollow(User $user)
    {
        if ($user->id != auth()->id()) {
            auth()->user()->followings()->detach($user->id); // アンフォロー
        }
        return redirect()->route('users.profile', $user->id); // プロフィールにリダイレクト
    }

// フォロワーリスト
public function followerList()
{
    $user = auth()->user();

    // ログインユーザ自身を除外して取得
    $followers = $user->followers()->where('users.id', '!=', $user->id)->get();
    $followings = $user->followings()->where('users.id', '!=', $user->id)->get();

    // フォロワーの投稿を取得（user_id IN フォロワーID）
    if ($followers->isEmpty()) {
        $posts = collect();
    } else {
        $posts = Post::whereIn('user_id', $followers->pluck('id'))->get();
    }

    return view('follows.FollowerList', compact('followers', 'followings', 'posts'));
}




    // フォローしているかどうかの状態確認
    public function check_following($id)
    {
        $check = Follow::where('following_id', Auth::id())->where('followed_id', $id);

        if ($check->count() == 0) {
            return response()->json(['status' => false]);
        } else {
            return response()->json(['status' => true]);
        }
    }

public function index(Request $request)
{
    $query = $request->input('query');

    $users = User::where('id', '!=', auth()->id())
                 ->when($query, function ($q) use ($query) {
                     return $q->where('username', 'like', "%{$query}%");
                 })
                 ->get();

    $user = auth()->user();
    $followings = $user->followings;
    $followers = $user->followers;

    return view('users.search', compact('users', 'followings', 'followers'));
}


}
