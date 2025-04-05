<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Follow;//Followモデルをインポート
use Illuminate\Support\Facades\Auth; // Authファサードを読み込む

use App\Post;

class FollowsController extends Controller
{
    //フォローしているかどうかの状態確認
    public function check_following($id){

        //自分がフォローしているかどうか検索
        $check = Follow::where('following', Auth::id() )->where('followed', $id);

        if($check->count() == 0):
            //フォローしている場合
            return response()->json(['status' => false]);
        elseif($check->count() != 0):
            //まだフォローしていない場合
            return response()->json(['status' => true]);
        endif;
    }
    public function follow($userId)
    {
        $follow = Follow::create([
            'follower_id' => Auth::id(),
            'followed_id' => $userId,
        ]);

        return response()->json(['message' => 'Followed successfully']);
    }

    public function unfollow($userId)
    {
        Follow::where('follower_id', Auth::id())
            ->where('followed_id', $userId)
            ->delete();

        return response()->json(['message' => 'Unfollowed successfully']);
    }

    public function following()
    {
        $following = Auth::user()->following()->get();
        return response()->json($following);
    }

    public function followers()
    {
        $followers = Auth::user()->followers()->get();
        return response()->json($followers);
    }
}
