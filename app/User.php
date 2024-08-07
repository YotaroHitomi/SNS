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
    protected $fillable = [
        'username', 'mail', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

        //リレーション定義を追加
    //「１対多」の「多」側 → メソッド名は複数形でhasManyを使う
    // public function posts(){
    //     return $this->hasMany('App\Post');
    // }
}

// class User extends Model
// {
//     //↓下記を追加してください
//     protected $fillable = [
//         'name'
//     ];
//     //リレーション(前ページで記載済みなのでこちらの追記は不要)
//     public function posts(){
//         return $this->hasMany('App\Post');
//     }

// }

// {
//     public function following()
//     {
//         return $this->belongsToMany(User::class, 'follows','following', 'followed');


//     }

//     //フォローされているユーザー
//     public function followed()
//     {

//         return $this->belongsToMany(User::class, 'follows','followed','following');

//     }


// }
