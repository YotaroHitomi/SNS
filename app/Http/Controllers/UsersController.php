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

        // プロフィール画像のURLを取得
        $profileImage = $user->profile_picture;

        return view('users.profile', compact('user', 'followsCount', 'followersCount', 'profileImage'));
    }

    // プロフィールの更新
    public function updateProfile(Request $request)
    {
        // バリデーション
        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'. $user->id,
            'newpassword' => 'nullable|min:6|confirmed',
            'bio' => 'nullable|string',
            'iconimage' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // 現在のユーザーを取得
        $user = Auth::user();

        // ユーザー情報を更新
        $user->username = $request->username;
        $user->email = $request->email;

        // パスワードが設定されていれば更新
        if ($request->newpassword) {
            $user->password = Hash::make($request->newpassword);
        }

        // Bioの更新
        $user->bio = $request->bio;

        // アイコン画像の更新（画像がアップロードされた場合のみ）
        if ($request->hasFile('iconimage')) {
            $imagePath = $request->file('iconimage')->store('images', 'public');
            $user->profile_image = $imagePath;  // ここを修正
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

    // すでにフォローしているかどうかの判定
    if ($user->followings->contains($targetUser)) {
        // フォロー解除 -> フォロワーを削除
        $user->followings()->detach($targetUser);
    } else {
        // 新たにフォロー
        $user->followings()->attach($targetUser);
    }

    // フォロー解除した場合でもリストからは削除されないように、リダイレクト
    return redirect()->route('users.profile', $userId);
}

    // フォロワー情報と投稿を表示
    public function followsProfile($id)
    {
        // ユーザーIDに基づいてユーザー情報を取得
        $user = User::with('followings.posts')  // フォローユーザーの投稿も一緒に取得
            ->findOrFail($id);

        // フォローユーザーの情報と投稿をビューに渡す
        $followings = $user->followings;

        return view('users.show', compact('followings', 'user'));
    }

    // プロフィールの更新
    public function profileupdate(Request $request)
    {
        // バリデーション
        $request->validate([
            'username' => 'required|string|max:255',
            'bio' => 'nullable|string|max:1000',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048', // 画像のバリデーション
        ]);

        $user = Auth::user();

        // プロフィール画像の更新処理（画像が送信されている場合）
        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $path = $image->store('profile_images', 'public');
            $user->profile_image = $path;
        }

        // 名前と自己紹介の更新
        $user->username = $request->input('username');
        $user->bio = $request->input('bio');
        $user->save();

        // 成功した場合、リダイレクトしてメッセージを表示
        return redirect()->route('users.profile')->with('success', 'プロフィールが更新されました');
    }

    // 特定のユーザーのプロフィールページ
    public function show($id)
    {
        $user = User::with('posts', 'followings.posts')  // フォローユーザーの投稿も一緒に取得
            ->findOrFail($id);

        return view('users.show', compact('user'));
    }

    // ユーザーのフォローしているユーザー一覧を表示
public function showFollowings()
{
    // 'posts'も一緒に取得！
    $followings = auth()->user()->followings()->with('posts')->get();

    $posts = Post::whereIn('user_id', $followings->pluck('id'))->get();

    return view('users.followings', compact('followings', 'posts'));
}


    // ユーザー検索機能
public function search(Request $request)
{
    $query = $request->input('query');

    $user = auth()->user();

    // 検索処理（フォロワーとフォローの両方）
    $followings = $user->followings()->where('username', 'like', "%{$query}%")->get();
    $followers = $user->followers()->where('username', 'like', "%{$query}%")->get();

    return view('users.search', compact('query', 'followings', 'followers'));
}

public function followersProfile($id)
{
    // ユーザーIDに基づいてユーザー情報を取得
    $user = User::with('followers.posts')  // フォロワーユーザーの投稿も一緒に取得
        ->findOrFail($id);

    // フォロワーユーザーの情報と投稿をビューに渡す
    $followers = $user->followers;  // ここでフォロワーユーザーを取得

    // 修正: $user 変数もビューに渡す
    return view('follows.FollowerList', compact('followers', 'user'));  // ここで $user を渡す
}

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

public function followers(Request $request)
{
    $user = Auth::user();

    // フォロワーのユーザー一覧を取得
    $followersQuery = $user->followers();

    // クエリパラメータが存在する場合のみ検索を行う
    $query = $request->input('query');

    // 検索クエリがあればフィルタリング
    if ($request->filled('query')) {
        $followersQuery = $followersQuery->where(function ($q) use ($query) {
            $q->where('username', 'like', "%{$query}%")
              ->orWhere('username', 'like', "%{$query}%");
        });
    }

    $followers = $followersQuery->get(); // フォロワーを取得

    return view('users.search', compact('followers', 'query'));
}


public function showFollowers(Request $request)
{
    $query = $request->input('query');

    // 自分のフォロワーユーザーを取得
    $followers = auth()->user()->followers;

    // 検索処理
    if ($query) {
        $followers = $followers->filter(function($follower) use ($query) {
            return str_contains($follower->username, $query);
        });
    }

    return view('your_view_name', [
        'followings' => $followers,
    ]);
}

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
        'followers' => collect(), // <= 追加
        'query' => $query
    ]);
}


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

    // ビュー名を 'search' に変更
    return view('search', compact('followings', 'posts'));
}

public function createForm()
{
    return view('users.search'); // 例：resources/views/users/create.blade.php
}
}
