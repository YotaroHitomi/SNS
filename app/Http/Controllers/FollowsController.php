<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Follow;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\User;

class FollowsController extends Controller
{
    // フォロー中ユーザーリスト
    public function followList()
    {
        $user = auth()->user();
        $followings = $user->followings; // フォロー中ユーザーのリストを取得

        // フォロー中ユーザーがいない場合、投稿も空にする
        if ($followings->isEmpty()) {
            $posts = collect();
        } else {
            // フォロー中ユーザーの投稿を取得
            $posts = Post::whereIn('user_id', $followings->pluck('id'))->get();
        }

        return view('follows.followList', compact('followings', 'posts'));
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
        $followers = $user->followers;

        return view('follows.FollowerList', compact('followers'));
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
}
