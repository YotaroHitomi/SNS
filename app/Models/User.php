<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'username',
        'mail',
        'password',
        'bio',
        'images',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // 投稿とのリレーション
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    // 自分がフォローしているユーザー一覧
    public function followings()
    {
        return $this->belongsToMany(User::class, 'follows', 'following_id', 'followed_id');
    }

    // 自分をフォローしているユーザー一覧
    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'followed_id', 'following_id');
    }

    // プロフィール画像のパスを返すアクセサ
    public function getProfilePictureAttribute()
    {
        if ($this->images && file_exists(public_path('images/' . $this->images))) {
            return asset('images/' . $this->images);
        }
        return asset('images/default_icon.png');
    }

    public function isFollowing($userId)
{
    return $this->followings()->where('followed_id', $userId)->exists();
}

}
