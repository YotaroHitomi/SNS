<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Follow;//Followモデルをインポート
use Illuminate\Support\Facades\Auth; // Authファサードを読み込む

use App\Post;

class FollowsController extends Controller
{
    public function index()
    {
        // ログイン中のユーザーのフォロワーを取得
        $user = auth()->user();
        $followers = $user->followers()->with('follower')->get();

        return view('follow.index', compact('followers'));
    }
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

        //フォローする(中間テーブルをインサート)
        public function following(Request $request){

            //自分がフォローしているかどうか検索
            $check = Follow::where('following', Auth::id())->where('followed', $request->user_id);

            //検索結果が0(まだフォローしていない)場合のみフォローする
            if($check->count() == 0):
                $follow = new Follow;
                $follow->following = Auth::id();
                $follow->followed = $request->user_id;
                $follow->save();
            endif;
        }

        //フォローを外す
        public function unfollowing(Request $request){

            //削除対象のレコードを検索して削除
            $unfollowing = Follow::where('following', Auth::id())->where('followed', $request->user_id)->delete();

        }

// フォローリスト用
public function followList()
{
    $user = auth()->user();
    $followings = $user->followings()->get(); // フォロー中のユーザー一覧

    return view('follows.FollowList', compact('followings'));
}

// フォロワーリスト用
public function followerList()
{
    $user = auth()->user();
    $followers = $user->follower()->get(); // フォロー中のユーザー一覧

    return view('follows.FollowerList', compact('follower'));
}

    }

//     class FollowController extends Controller
// {
//     public function index()
//     {
//         $user = auth()->user();
//         $followingUsers = $user->following()->with('posts')->get();

//         return view('follows.index', compact('followingUsers'));
//     }
// }

// class FollowController extends Controller
// {
//     public function toggleFollow($id)
//     {
//         $user = auth()->user();
//         $isFollowing = $user->isFollowing($id);

//         if ($isFollowing) {
//             // フォロー解除
//             $user->following()->detach($id);
//         } else {
//             // フォローする
//             $user->following()->attach($id);
//         }

//         return back(); // リロード
//     }
// }
