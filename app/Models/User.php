<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['name', 'email', 'password', 'bio', 'profile_image'];

    protected $hidden = ['password', 'remember_token'];

    // 投稿とのリレーション
public function posts()
{
    return $this->hasMany(Post::class);
}
    // 自分がフォローしているユーザー一覧を取得
    public function followings()
    {
        return $this->belongsToMany(User::class, 'follows', 'following_id', 'followed_id');
    }

    // フォロワーを取得
public function followers()
{
    return $this->belongsToMany(User::class, 'follows', 'followed_id', 'following_id');
}

    // フォローしているかどうか判定
    public function isFollowing(User $user): bool
    {
        return $this->followings()->where('followed_id', $user->id)->exists();
    }

    // フォローされているかどうか判定
    public function isFollowed(User $user): bool
    {
        return $this->followers()->where('following_id', $user->id)->exists();
    }

    // プロフィール画像URLを取得するアクセサ
    public function getProfilePictureAttribute()
    {
        // プロフィール画像が設定されていれば、そのURLを返す。設定されていなければデフォルト画像を返す。
        return $this->profile_image
            ? asset('storage/' . $this->profile_image)  // 画像URLを生成
            : asset('storage/images/default-icon.png');  // デフォルト画像
    }
}
