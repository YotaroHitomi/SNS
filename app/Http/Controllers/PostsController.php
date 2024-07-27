<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Database\Eloquent\Model;
use App\Post;
use App\User;

class PostsController extends Controller
{
    //
    public function hello(){
      $user=Auth::user();
        return view('posts.index', compact('user'));
                $posts = POST::get(); //Bookモデル（booksテーブル）からレコード情報を取得
        return view('posts.index',['posts'=>$posts]);

      $posts = Post::get(); //Bookモデル（booksテーブル）からレコード情報を取得
        return view('posts.index',['posts'=>$posts]);
    }

    public function createForm()
    {
            $users = Users::get(); //Authorモデル（authorsテーブル）からレコード情報を取得
            return view('posts.createForm',['users'=>$users]);
    }

    // public function authorCreate(Request $request)
    // {
    //     $request->validate([
    //           'authorName' => 'required|unique:authors,name|max:10',
    //     ]);
    //     $name = $request->input('authorName');
    //     Author::create(['name' => $name]);
    //     return back();
    // }

        public function index()
    {
        $posts = Post::get(); //Bookモデル（booksテーブル）からレコード情報を取得
        return view('posts.index',['posts'=>$posts]);
    }

   public function postsCreate(Request $request)
    {
        $user_id = $request->input(①);
        $title = $request->input(②);
        $price = $request->input(③);

        ④::create([
           ⑤ => ⑥,
           ⑦ => ⑧,
           ⑨ => ⑩,
        ]);
        return redirect('/index');
    }

  //   public function show(){
  // // Postモデル経由でpostsテーブルのレコードを取得
  // $posts = Post::get();
  // // フォローしているユーザーのidを取得
  // $following_id = Auth::user()->follows()->pluck(' ① ');

  // // フォローしているユーザーのidを元に投稿内容を取得
  // $posts = Post::with('user')->whereIn(' ② ', $following_id)->get();
  // return view('follow.blade.php', compact('posts'));

     public function updateForm($id)
    {
        $posts = Post::where('id', $id)->first();
        return view('posts.updateForm', ['posts'=>$posts]);
    }

        public function update(Request $request)
    {
        // 1つ目の処理
        $id = $request->input('id');
        $up_title = $request->input('upTitle');
        $up_price = $request->input('upPrice');
        // 2つ目の処理
        Post::where('id', $id)->update([
              'title' => $up_title,
              'price' => $up_price
        ]);
        // 3つ目の処理
        return redirect('/index');
    }

        public function delete($id)
    {
        Book::where('id', $id)->delete();
        return redirect('/index');
    }

        public function search(Request $request)
    {
        // 1つ目の処理
        $keyword = $request->input('keyword');
        // 2つ目の処理
        if(!empty($keyword)){
             $posts = Post::where('title','like', '%'.$keyword.'%')->get();
        }else{
             $posts = Post::all();
        }
        // 3つ目の処理
        return view('posts.index',['posts'=>$posts]);
    }
}

return redirect('/index');

return view('books.createForm');

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Follow;//Followモデルをインポート
use Illuminate\Support\Facades\Auth; // Authファサードを読み込む

class FollowController extends Controller
{
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
}
