<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    public function index()
    {
        $books = Book::get(); //Bookモデル（booksテーブル）からレコード情報を取得
        return view('books.index',['books'=>$books]);
    }

    //     public function user(){
    //     return $this->belongsTo('App\User');
    // }
}

?>
