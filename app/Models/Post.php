<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'user_id',
        'post',
    ];

    // 投稿は1人のユーザーに属する
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 特定ユーザーのタイムラインを取得
    public static function getUserTimeLine(int $user_id)
    {
        return self::where('user_id', $user_id)
                   ->orderBy('created_at', 'desc')
                   ->paginate(50);
    }

    // 特定ユーザーの投稿数を取得
    public static function getTweetCount(int $user_id)
    {
        return self::where('user_id', $user_id)->count();
    }
}
