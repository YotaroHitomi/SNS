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
    $profileImage = $user->profile_picture; // アクセサを使用してプロフィール画像URLを取得

    return view('users.profile', compact('user', 'followsCount', 'followersCount', 'profileImage'));
}

    // プロフィールの更新
    public function updateProfile(Request $request)
    {
        // バリデーション
        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'mail' => 'required|email|max:255',
            'newpassword' => 'nullable|min:6|confirmed',
            'bio' => 'nullable|string',
            'iconimage' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // 現在のユーザーを取得
        $user = Auth::user();

        // ユーザー情報を更新
        $user->username = $request->username;
        $user->mail = $request->mail;

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

        return redirect()->route('profile.profile')->with('status', 'Profile updated successfully!');
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

        return view('users.followsProfile', compact('followings', 'user'));
    }

    // プロフィールの更新
    public function profileupdate(Request $request)
    {
        // バリデーション
        $request->validate([
            'name' => 'required|string|max:255',
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
        $user->name = $request->input('name');
        $user->bio = $request->input('bio');
        $user->save();

        // 成功した場合、リダイレクトしてメッセージを表示
        return redirect()->route('users.profile')->with('success', 'プロフィールが更新されました');
    }

    // 特定のユーザーのプロフィールページ
    public function show($id)
    {
        $user = User::with('posts', 'followings.posts')  // フォローユーザの投稿も一緒に取得
            ->findOrFail($id);

        // プロフィールページ用に、フォローユーザの情報も返す
        return view('users.show', compact('user'));
    }

    // ユーザーのフォローしているユーザー一覧を表示
    public function showFollowings()
    {
        $followings = auth()->user()->followings;  // ユーザーのフォローユーザーを取得

        return view('users.followings', compact('followings'));
    }

    // ユーザー検索機能
public function search(Request $request)
{
    $query = $request->input('query');

    // ユーザー名で部分一致検索を行い、結果を返す
    $followings = Auth::user()->followings()
        ->where('username', 'like', '%' . $query . '%')
        ->get();

    return view('users.search', compact('followings', 'query'));
}
    // ユーザー作成フォーム（必要に応じて追加）
    public function createForm()
    {
        // ここにフォーム表示などの処理を追加
        return view('users.search'); // 例えば create.blade.php ビューを表示
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

public function followList()
{
    // ユーザーがフォローしているユーザーを取得
    $followings = Auth::user()->followings;

    return view('users.followList', compact('followings'));
}

public function followers(Request $request)
{
    $user = auth()->user();
    $query = $request->input('query');

    // ユーザーが検索した場合
    if ($query) {
        $followings = $user->followings()->where('username', 'LIKE', "%{$query}%")->get();
    } else {
        $followings = $user->followings;
    }

    return view('followers.index', compact('followings'));
}

public function showFollowers()
{
    $followers = Auth::user()->followers;  // 現在ログインしているユーザーのフォロワーを取得

    // フォロワー情報をログに出力
    Log::info('Followers: ', $followers->toArray());

    return view('users.followerList', compact('followers'));
}


}
