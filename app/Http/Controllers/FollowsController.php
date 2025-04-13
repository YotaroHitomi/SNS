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
        $followings = $user->followings()->get(); // フォロー中ユーザーのリストを取得

        // フォロー中ユーザーがいない場合、投稿も空にする
        if ($followings->isEmpty()) {
            $posts = collect();
        } else {
            $posts = Post::whereIn('user_id', $followings->pluck('id'))->get(); // フォロー中ユーザーの投稿を取得
        }

        return view('follows.followList', compact('followings', 'posts')); // フォロー中ユーザーを渡す
    }

    // フォローする
    public function follow($followedUserId)
    {
        $user = auth()->user();

        // すでにフォローしていない場合のみフォローする
        if (!$user->isFollowing(User::find($followedUserId))) {
            $user->followings()->attach($followedUserId); // フォロー処理
        }
    }

    // フォローを外す
    public function unfollow($followedUserId)
    {
        $user = auth()->user();

        // すでにフォローしている場合のみアンフォローする
        if ($user->isFollowing(User::find($followedUserId))) {
            $user->followings()->detach($followedUserId); // アンフォロー処理
        }
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
