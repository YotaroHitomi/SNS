<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    // public function index()
    // {
    //     $posts = Post::get(); //Bookモデル（booksテーブル）からレコード情報を取得
    //     return view('posts.index',['posts'=>$posts]);
    // }

    //     public function user(){
    //     return $this->belongsTo('App\User');
    // }

    protected $fillable = [
        'user_id', 'post',
    ];

    // リレーションの定義
    public function user(){
    return $this->belongsTo('App\Author');
    }
}

?>
