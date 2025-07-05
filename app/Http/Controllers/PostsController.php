<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Post;

class PostsController extends Controller
{
    // 投稿一覧
    public function index()
    {
        $user = Auth::user();

        // フォローしているユーザーのIDを取得し、自分のIDも追加
        $userIds = $user->followings->pluck('id')->toArray();
        $userIds[] = $user->id;

        // デフォルトユーザーの投稿を追加したい場合
        $defaultUsersPosts = Post::whereIn('user_id', [2, 3])->latest()->get();
        $mainPosts = Post::whereIn('user_id', $userIds)->latest()->get();

        // 結合して重複排除、日付順にソート
        $posts = $mainPosts->merge($defaultUsersPosts)->unique('id')->sortByDesc('created_at');

        return view('posts.index', compact('posts'));
    }

    // 投稿の保存（新規投稿）
    public function store(Request $request)
    {
        $this->validatePost($request);

        $post = new Post();
        $post->user_id = Auth::id();
        $post->post = $request->post;
        $post->save();

        return redirect()->route('posts.index')->with('success', '投稿が完了しました');
    }

    // 投稿の更新（既存投稿の内容を更新）
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        if ($post->user_id !== auth()->id()) {
            abort(403);
        }

        $this->validatePost($request);

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

    // 共通バリデーション処理（投稿時・編集時に共通）
    private function validatePost(Request $request)
    {
        return $request->validate([
            'post' => 'required|string|min:1|max:150',
        ], [
            'post.required' => '投稿内容は入力必須です。',
            'post.min' => '投稿内容は1文字以上入力してください。',
            'post.max' => '投稿内容は150文字以内で入力してください。',
        ]);
    }
}
