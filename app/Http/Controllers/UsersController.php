<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    /**
     * プロフィールページ表示
     */
    public function profile()
    {
        $user = Auth::user();
        return view('users.profile', compact('user'));
    }

    /**
     * プロフィール更新
     */
public function updateProfile(Request $request)
{
    $user = Auth::user();

    $request->validate([
        'username' => 'required|string|max:255',
        'mail' => 'required|email|max:255|unique:users,mail,' . $user->id,
        'bio' => 'nullable|string|max:255',
        'newpassword' => 'nullable|string|confirmed|min:6',
        'iconimage' => 'nullable|image|max:2048',
    ]);

    $user->username = $request->input('username');
    $user->mail = $request->input('mail');
    $user->bio = $request->input('bio');

    if ($request->filled('newpassword')) {
        $user->password = bcrypt($request->input('newpassword'));
    }

    if ($request->hasFile('iconimage')) {
        $filename = $request->file('iconimage')->getClientOriginalName();
        $request->file('iconimage')->move(public_path('images'), $filename);
        $user->profile_image = $filename;
    }

    $user->save();

    return redirect()->route('index')->with('success', 'プロフィールを更新しました');
}


    /**
     * ユーザー一覧・検索
     * 検索ワードがあれば絞り込み
     */
public function search(Request $request)
{
    $authUser = Auth::user();
    $query = $request->input('query', '');

    // フォロー中ユーザー取得
    $followings = $authUser->followings()
        ->when($query, fn($q) => $q->where('username', 'like', "%{$query}%"))
        ->get();

    // フォロワー取得
    $followers = $authUser->followers()
        ->when($query, fn($q) => $q->where('username', 'like', "%{$query}%"))
        ->get();

    // ユーザー一覧（自分以外）
    $users = User::where('id', '<>', $authUser->id)
        ->when($query, fn($q) => $q->where('username', 'like', "%{$query}%"))
        ->get();

    return view('users.search', compact('query', 'followings', 'followers', 'users'));
}

    /**
     * フォロー中一覧表示
     */
    public function showFollowings()
    {
        $user = Auth::user();

        // フォローしているユーザーを取得
        $followings = $user->followings()->paginate(10);

        return view('users.followings', compact('followings'));
    }

    /**
     * フォロワー一覧表示
     */
    public function showFollowers()
    {
        $user = Auth::user();

        // 自分をフォローしているユーザーを取得
        $followers = $user->followers()->paginate(10);

        return view('users.followers', compact('followers'));
    }

    /**
     * ユーザー個別ページ表示
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * フォロー・アンフォロー切替
     */
    public function toggleFollow($userId)
    {
        $user = Auth::user();

        if ($user->id == $userId) {
            return redirect()->back()->withErrors('自分自身をフォローできません。');
        }

        $targetUser = User::findOrFail($userId);

        // 既にフォローしているか
        $isFollowing = $user->followings()->where('followed_id', $userId)->exists();

        if ($isFollowing) {
            // フォロー解除
            $user->followings()->detach($userId);
        } else {
            // フォロー追加
            $user->followings()->attach($userId);
        }

        return redirect()->back();
    }

    public function followsProfile($id)
{
    $user = User::findOrFail($id);

    // もし必要なら、ユーザーの投稿やフォロー状況も取得
    $posts = $user->posts()->latest()->paginate(10);

    // ログインユーザーがこのユーザーをフォローしているかどうか
    $isFollowing = false;
    if (auth()->check()) {
        $isFollowing = auth()->user()->followings()->where('followed_id', $user->id)->exists();
    }

    return view('users.show', compact('user', 'posts', 'isFollowing'));
}

public function following(Request $request)
{
    $user = auth()->user();
    $query = $request->input('query', '');

    $followings = $user->followings()
        ->when($query, fn($q) => $q->where('username', 'like', "%{$query}%"))
        ->get();

    $followers = $user->followers()
        ->when($query, fn($q) => $q->where('username', 'like', "%{$query}%"))
        ->get();

    // 自分以外の全ユーザー（検索付き）
    $users = User::where('id', '<>', $user->id)
        ->when($query, fn($q) => $q->where('username', 'like', "%{$query}%"))
        ->get();

    return view('users.search', compact('followings', 'followers', 'users', 'query'));
}
}
