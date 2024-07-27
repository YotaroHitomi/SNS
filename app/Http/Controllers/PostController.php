<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
public function show(){
  // Postモデル経由でpostsテーブルのレコードを取得
  $posts = Post::get();
  return view('yyyy', compact('posts'));
}
}
