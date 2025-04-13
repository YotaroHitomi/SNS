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

        // ユーザーがフォローしているユーザーの投稿を取得
        $followings = $user->followings;  // フォローしているユーザーのコレクション
        $followedPosts = Post::whereIn('user_id', $followings->pluck('id'))->latest()->get();  // フォロー中のユーザーの投稿を取得

        // デフォルトの投稿（User One と User Two の投稿を取得）
        $defaultUsersPosts = Post::whereIn('user_id', [2, 3])  // User One と User Two のID（デフォルトユーザーのID）
                             ->latest()->get();

        // フォローしているユーザーの投稿とデフォルト投稿をマージ
        $posts = $followedPosts->merge($defaultUsersPosts);

        // 投稿を新しい順に並べ替え
        $posts = $posts->sortByDesc('created_at');

        return view('posts.index', compact('posts', 'followings'));
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

        // 投稿後にリダイレクトする（投稿完了後にどこかにリダイレクトしたい場合）
        return redirect()->route('posts.index');  // 適切なルートにリダイレクト
    }

    // 投稿の更新（既存投稿の内容を更新）
    public function update(Request $request, $id)
    {
        $request->validate([
            'post' => 'required',  // 投稿内容が必須
        ]);

        $post = Post::findOrFail($id);

        // 自分の投稿かどうかをチェック
        if (Auth::id() != $post->user_id) {
            abort(403, 'Unauthorized action.');  // 不正な操作
        }

        $post->post = $request->post;  // 投稿内容を更新
        $post->save();  // データベースに保存

        return redirect()->route('posts.index')->with('success', '投稿が更新されました。');
    }

    // 投稿の編集フォーム（編集画面に遷移）
    public function edit($id)
    {
        $post = Post::findOrFail($id);

        // 自分の投稿かどうかをチェック
        if (Auth::id() != $post->user_id) {
            abort(403, 'Unauthorized action.');  // 不正な操作
        }

        return view('posts.edit', compact('post'));  // 編集画面を表示
    }

    // 投稿の削除
    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        // 自分の投稿かどうかをチェック
        if (Auth::id() != $post->user_id) {
            abort(403, 'Unauthorized action.');  // 不正な操作
        }

        $post->delete();  // データベースから削除

        return redirect()->route('posts.index')->with('success', '投稿が削除されました');
    }

    public function postTweet(Request $request)
{
    // バリデーション
    $request->validate([
        'post' => 'required|max:255',
    ]);

    // 投稿を新規作成
    $post = new Post();
    $post->user_id = Auth::id();  // ログイン中のユーザーID
    $post->post = $request->post;  // フォームから送信された内容
    $post->save();  // 投稿を保存

    // 投稿完了後、適切な場所にリダイレクト
    return redirect()->route('posts.index')->with('success', '投稿が完了しました');
}
}
