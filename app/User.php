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

        // フォロー用
    public function followings()
    {
        return $this->belongsToMany(User::class, 'follows', 'following_id', 'followed_id');
    }

// フォロワー用
        public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'followed_id');
    }

    //     // フォロワー→フォロー
    // public function followUsers()
    // {
    //     return $this->belongsToMany('App\User', 'follow_users', 'followed_user_id', 'following_user_id');
    // }

    // // フォロー→フォロワー
    // public function follows()
    // {
    //     return $this->belongsToMany('App\User', 'follow_users', 'following_user_id', 'followed_user_id');
    // }

    // public function getAllUsers(Int $user_id)
    // {
    //     return $this->Where('id', '<>', $user_id)->paginate(5);
    // }

    //     // フォローする
    // public function follow(Int $user_id)
    // {
    //     return $this->follows()->attach($user_id);
    // }

    // // フォロー解除する
    // public function unfollow(Int $user_id)
    // {
    //     return $this->follows()->detach($user_id);
    // }

    // // フォローしているか
    // public function isFollowing(Int $user_id)
    // {
    //     return (boolean) $this->follows()->where('followed_id', $user_id)->first(['id']);
    // }

    // // フォローされているか
    // public function isFollowed(Int $user_id)
    // {
    //     return (boolean) $this->followers()->where('following_id', $user_id)->first(['id']);
    // }

    //     public function updateProfile(Array $params)
    // {
    //     if (isset($params['profile_image'])) {
    //         $file_name = $params['profile_image']->store('public/profile_image/');

    //         $this::where('id', $this->id)
    //             ->update([
    //                 'screen_name'   => $params['screen_name'],
    //                 'name'          => $params['name'],
    //                 'profile_image' => basename($file_name),
    //                 'email'         => $params['email'],
    //             ]);
    //     } else {
    //         $this::where('id', $this->id)
    //             ->update([
    //                 'screen_name'   => $params['screen_name'],
    //                 'name'          => $params['name'],
    //                 'email'         => $params['email'],
    //             ]);
    //     }

    //     return;
    // }

    }

//     class User extends Authenticatable
// {
//     use HasFactory, Notifiable;

//     public function followers()
//     {
//         return $this->belongsToMany(User::class, 'follows', 'followed_id', 'follower_id');
//     }

//     public function following()
//     {
//         return $this->belongsToMany(User::class, 'follows', 'follower_id', 'followed_id');
//     }

//     public function posts()
//     {
//         return $this->hasMany(Post::class);
//     }
// }

// class User extends Authenticatable
// {
//     use HasFactory, Notifiable;

//     // フォローしているユーザー
//     public function following()
//     {
//         return $this->belongsToMany(User::class, 'follows', 'follower_id', 'followed_id');
//     }

//     // フォロワーの取得
//     public function followers()
//     {
//         return $this->belongsToMany(User::class, 'follows', 'followed_id', 'follower_id');
//     }

//     // フォロー状態の確認
//     public function isFollowing($userId)
//     {
//         return $this->following()->where('followed_id', $userId)->exists();
//     }
// }
