<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable

{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable = [
    //     'author_id', 'title', 'price',
    // ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
  /*
   *フォローされているユーザーを取得
   */

       public function articles(){
        /**
         * リレーション一対多の一側
         * user(1):article(多)
         * articleテーブルを新しい順で更新する。
         *
         *
           */
    //     return $this->hasMany('App\Article')->latest();
    // }
       }
        protected $fillable = [
            'name'
        ];

    public function followers()
{
    return $this->belongsToMany(User::class, 'follows', 'followed_id', 'follower_id');
}

public function following()
{
    return $this->belongsToMany(User::class, 'follows', 'follower_id', 'followed_id');
}

    // フォローする
    public function follow(Int $user_id)
    {
        return $this->follows()->attach($user_id);
    }

    // フォロー解除する
    public function unfollow(Int $user_id)
    {
        return $this->follows()->detach($user_id);
    }

    // フォローしているか
    public function isFollowing(Int $user_id)
    {
        return (boolean) $this->follows()->where('followed_id', $user_id)->first(['id']);
    }

    // フォローされているか
    public function isFollowed(Int $user_id)
    {
        return (boolean) $this->followers()->where('following_id', $user_id)->first(['id']);
    }

        public function follows()
    {
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'followed_id');
    }

    // public function followers()
    // {
    //     return $this->belongsToMany(User::class, 'follows', 'followed_id', 'follower_id');
    // }

    // public function followCount()
    // {
    //     return $this->follows()->count();
    // }

    // public function followerCount()
    // {
    //     return $this->followers()->count();
    // }
}
