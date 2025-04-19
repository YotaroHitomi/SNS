<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Post;
use App\Models\User;

class PostsController extends Controller
{
    // 投稿一覧
public function index()
{
    $user = Auth::user();

    // フォローしているユーザーのIDを取得し、自分のIDも追加
    $userIds = $user->followings->pluck('id')->toArray(); // フォロー中のユーザーID配列
    $userIds[] = $user->id; // 自分自身のIDを追加

    // 投稿を取得（デフォルトユーザーの投稿も含めたい場合はここで追加）
    $defaultUsersPosts = Post::whereIn('user_id', [2, 3])->latest()->get();
    $mainPosts = Post::whereIn('user_id', $userIds)->latest()->get();

    // 結合して重複排除、日付順にソート
    $posts = $mainPosts->merge($defaultUsersPosts)->unique('id')->sortByDesc('created_at');

    return view('posts.index', compact('posts'));
}

    // 投稿の保存（新規投稿）
    public function store(Request $request)
    {
        // バリデーション
        $validated = $request->validate([
            'post' => 'required|max:255', // 投稿内容が必須で255文字以内
        ]);

        // 新しい投稿を作成
        $post = new Post();
        $post->user_id = Auth::id();  // ログインしているユーザーのID
        $post->post = $request->post;  // フォームから送信された投稿内容
        $post->save();  // データベースに保存

        // 投稿後にリダイレクトする
        return redirect()->route('posts.index')->with('success', '投稿が完了しました');
    }

    // 投稿の更新（既存投稿の内容を更新）
public function update(Request $request, $id)
{
    $post = Post::findOrFail($id);

    // 本人確認
    if ($post->user_id !== auth()->id()) {
        abort(403);
    }

    $request->validate([
        'post' => 'required|string|max:255',
    ]);

    $post->post = $request->post;
    $post->save();

    return redirect()->back()->with('success', '投稿を更新しました');
}

    // 投稿の削除
public function destroy($id)
{
    $post = Post::findOrFail($id);

    if ($post->user_id !== auth()->id()) {
        abort(403);
    }

    $post->delete();

    return redirect()->back()->with('success', '投稿を削除しました');
}
}
