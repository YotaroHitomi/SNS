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

    // フォローしているユーザーのIDと自分自身のIDをまとめる
    $userIds = $user->followings->pluck('id')->toArray();
    $userIds[] = $user->id;

    // 指定したユーザーのみの投稿を取得
    $posts = Post::whereIn('user_id', $userIds)
                ->with('user') // リレーションがある場合の最適化（N+1防止）
                ->latest()
                ->get();

    return view('posts.index', compact('posts'));
}


    // 投稿の保存（新規投稿）
    public function store(Request $request)
    {
        // バリデーション
    $request->validate([
        'post' => 'required|string|min:1|max:150',
    ], [
        'post.required' => '入力必須です。',
        'post.min' => '1文字以上入力してください。',
        'post.max' => '150文字以内で入力してください。',
    ]);

    $post = new Post();
    $post->user_id = auth()->id();   // ここでメールアドレスではなくIDをセット
    $post->post = $request->post;
    $post->save();

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
        'post' => 'required|string|min:1|max:150',
    ], [
        'post.required' => '入力必須です。',
        'post.min' => '1文字以上入力してください。',
        'post.max' => '150文字以内で入力してください。',
    ]);

    $post->post = $request->post;
    $post->save();

    return redirect()->route('posts.index')->with('success', '投稿を更新しました');
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

public function __construct()
{
    $this->middleware('auth');
}
}
