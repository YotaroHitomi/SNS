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

        public function getUserTimeLine(Int $user_id)
    {
        return $this->where('user_id', $user_id)->orderBy('created_at', 'DESC')->paginate(50);
    }

    public function getTweetCount(Int $user_id)
    {
        return $this->where('user_id', $user_id)->count();
    }

}

?>

<!-- class Post extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'content'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
} -->
