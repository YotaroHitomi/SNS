<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Database\Eloquent\Model;
use App\Post;
use App\User;

class PostsController extends Controller
{
    //投稿フォーム表示用
    public function index(){
    {
        $posts = Post::get();

        return view('posts.index', ['posts' => $posts]);
    }
    }

    public function createForm()
    {
        $users = User::get(); //Userモデル（usersテーブル）からレコード情報を取得
        return view('posts.index',['users'=>$users]);
    }

    public function postTweet(Request $request)
    {

        Post::create([
            'user_id' => Auth::user()->id, // Auth::user()は、現在ログインしている人（つまりツイートしたユーザー）
            'post' => $request->post, // ツイート内容
        ]);
        return back();
    }

    public function updateForm($id)
    {
        $post = Post::where('id', $id)->first();
        return view('posts.index', ['post'=>$post]);
    }

    public function update(Request $request)
    {
     $request->validate([
        'user_id' => 'required|max:255',
        'post' => 'required',
    ]);

    $post = Post::findOrFail($id);
    $post->user = $request->user;
    $post->post = $request->post;
    $post->save();

    return redirect()->route('posts.index')->with('success', '投稿が更新されました。');
}

    //削除用
    public function delete($id)
    {
        Post::where('id', $id)->delete();
        return redirect('/top');
    }

        public function get_user($user_id){

        $user = User::with('following')->with('followed')->findOrFail($user_id);
        return response()->json($user);
    }

        //検索用
    public function search(Request $request){
    {
        // 1つ目の処理
        $keyword = $request->input('keyword');
        // 2つ目の処理
        if(!empty($keyword)){
             $posts = Post::where('post','like', '%'.$keyword.'%')->get();
        }else{
             $posts = Post::all();
        }
        // 3つ目の処理
        return view('users.search',['posts'=>$posts]);
    }}

    public function timeline() {
            $posts = Post::query()->whereIn('user_id', Auth::user()->follows()->pluck('followed_user_id'))->latest()->get();
            return view('posts.timeline')->with([
                'posts' => $posts,
                ]);
        }

public function followPosts()
{
    $user = Auth::user();

    // フォローしているユーザーの投稿を取得
    $followings = $user->followings()->pluck('users.id'); // フォロー中ユーザーのIDを取得

    // それらのユーザーの投稿を取得
    $posts = Post::whereIn('user_id', $followings)->latest()->get();

    return view('follows.FollowList', compact('posts'));
}
}
