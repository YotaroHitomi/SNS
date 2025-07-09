<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    // プロフィールページの表示
    public function profile()
    {
        $user = Auth::user(); // ログインユーザーを取得

        // フォロー数とフォロワー数を取得
        $followsCount = $user->followings()->count();
        $followersCount = $user->followers()->count();

        // プロフィール画像ファイル名を取得
        $profileImage = $user->images;  // ここを 'images' に統一

        return view('users.profile', compact('user', 'followsCount', 'followersCount', 'profileImage'));
    }

    // プロフィールの更新
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        // バリデーション
        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'mail' => 'required|mail|unique:users,mail,' . $user->id,  // 'mail'カラムに合わせる
            'newpassword' => 'nullable|min:6|confirmed',
            'bio' => 'nullable|string',
            'iconimage' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // ユーザー情報を更新
        $user->username = $request->username;
        $user->mail = $request->mail;

        // パスワードが設定されていれば更新
        if ($request->filled('newpassword')) {
            $user->password = Hash::make($request->newpassword);
        }

        // Bioの更新
        $user->bio = $request->bio;

        // アイコン画像の更新（画像がアップロードされた場合のみ）
        if ($request->hasFile('iconimage')) {
            $image = $request->file('iconimage');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images'), $imageName);
            $user->images = $imageName;  // DBにファイル名だけ保存
        }

        // ユーザー情報を保存
        $user->save();

        return redirect()->route('top')->with('success', 'プロフィールが更新されました');
    }

    // フォローの処理
    public function follow(User $user)
    {
        if ($user->id != auth()->id()) {
            auth()->user()->followings()->attach($user->id); // フォローする
        }
        return redirect()->route('users.profile', $user->id); // プロフィールにリダイレクト
    }

    // アンフォローの処理
    public function unfollow(User $user)
    {
        if ($user->id != auth()->id()) {
            auth()->user()->followings()->detach($user->id); // フォロー解除
        }
        return redirect()->route('users.profile', $user->id); // プロフィールにリダイレクト
    }

    // フォロー状態をトグル
    public function toggleFollow($userId)
    {
        $user = auth()->user();
        $targetUser = User::findOrFail($userId);

        if ($user->followings->contains($targetUser)) {
            $user->followings()->detach($targetUser);
        } else {
            $user->followings()->attach($targetUser);
        }

        return redirect()->route('users.profile', $userId);
    }

    // フォロー中ユーザーのプロフィールと投稿を表示
    public function followsProfile($id)
    {
        $user = User::with('followings.posts')->findOrFail($id);

        $followings = $user->followings;

        return view('users.show', compact('followings', 'user'));
    }

    // プロフィールの更新（別メソッド）
    public function profileupdate(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'bio' => 'nullable|string|max:1000',
            'iconimage' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',  // ここも'iconimage'に統一
        ]);

        $user = Auth::user();

        if ($request->hasFile('iconimage')) {
            $image = $request->file('iconimage');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images'), $imageName);
            $user->images = $imageName;
        }

        $user->username = $request->input('username');
        $user->bio = $request->input('bio');
        $user->save();

        return redirect()->route('users.profile')->with('success', 'プロフィールが更新されました');
    }

    // 特定のユーザーのプロフィールページ表示
    public function show($id)
    {
        $user = User::with('posts', 'followings.posts')->findOrFail($id);

        return view('users.show', compact('user'));
    }

    // ユーザーのフォロー中ユーザー一覧とその投稿を表示
    public function showFollowings()
    {
        $followings = auth()->user()->followings()->with('posts')->get();

        $posts = Post::whereIn('user_id', $followings->pluck('id'))->get();

        return view('users.followings', compact('followings', 'posts'));
    }

    // ユーザー検索機能（フォロー中・フォロワー）
public function search(Request $request)
{
    $query = $request->input('query');

    $users = User::where('username', 'like', "%{$query}%")
                 ->where('id', '<>', auth()->id()) // 自分は除くなら
                 ->get();

    return view('users.search', compact('users', 'query'));
}

    // フォロワー一覧表示（投稿も含む）
    public function followersProfile($id)
    {
        $user = User::with('followers.posts')->findOrFail($id);

        $followers = $user->followers;

        return view('follows.FollowerList', compact('followers', 'user'));
    }

    // フォロー中ユーザー検索
    public function followingList(Request $request)
    {
        $query = $request->input('query');
        $user = auth()->user();

        $followingsQuery = $user->followings();

        if ($query) {
            $followingsQuery->where(function ($q) use ($query) {
                $q->where('username', 'like', "%{$query}%")
                  ->orWhere('username', 'like', "%{$query}%");
            });
        }

        $followings = $followingsQuery->get();

        return view('users.search', compact('followings'));
    }

    // フォロワー一覧検索
public function followers(Request $request)
{
    $query = $request->input('query');

    // ログイン中のユーザーを除くユーザー一覧を取得し、検索ワードがあれば絞り込み
    $usersQuery = User::where('id', '<>', auth()->id());

    if (!empty($query)) {
        $usersQuery->where('username', 'like', '%' . $query . '%');
    }

    $users = $usersQuery->get();

    return view('follows.FollowerList', compact('users', 'query'));
}

    // フォロワー一覧を表示（別メソッド）
    public function showFollowers(Request $request)
    {
        $query = $request->input('query');

        $followers = auth()->user()->followers;

        if ($query) {
            $followers = $followers->filter(function($follower) use ($query) {
                return str_contains($follower->username, $query);
            });
        }

        return view('your_view_name', [
            'followings' => $followers,
        ]);
    }

    // フォロー中ユーザー一覧検索
    public function following(Request $request)
    {
        $query = $request->input('query');
        $user = auth()->user();

        $followingsQuery = $user->followings();

        if ($query) {
            $followingsQuery->where('username', 'like', '%' . $query . '%');
        }

        $followings = $followingsQuery->get();

        return view('users.search', [
            'followings' => $followings,
            'followers' => collect(),
            'query' => $query
        ]);
    }

    // フォロー中ユーザーの投稿一覧表示
    public function followList()
    {
        $user = auth()->user();
        $followings = $user->followings;

        if ($followings->isEmpty()) {
            $posts = collect();
        } else {
            $posts = Post::whereIn('user_id', $followings->pluck('id'))->get();
        }

        return view('search', compact('followings', 'posts'));
    }

    public function createForm()
    {
        return view('users.search');
    }
}
