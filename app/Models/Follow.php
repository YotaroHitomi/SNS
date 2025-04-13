<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    protected $fillable = [
        'following_id', 'followed_id',
    ];

    // フォローしているユーザーを取得
    public function following()
    {
        return $this->belongsTo(User::class, 'following_id');
    }

    // フォローされているユーザーを取得
    public function followed()
    {
        return $this->belongsTo(User::class, 'followed_id');
    }

    // フォローしている数を取得
    public function getFollowCount($user_id)
    {
        return $this->where('following_id', $user_id)->count();
    }

    // フォロワー数を取得
    public function getFollowerCount($user_id)
    {
        return $this->where('followed_id', $user_id)->count();
    }

    // アイコンの取得（ユーザーがフォローしている場合）
    public function icon()
    {
        return $this->hasOne(Icon::class);
    }
}
