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

        // リレーションの定義
        public function posts(){
        return $this->hasMany('App\Post');
        }

        //フォローしているユーザー
        public function following()
        {
            return $this->belongsToMany(User::class, 'follows','following', 'followed');
        }

        //フォローされているユーザー
        public function followed()
        {

            return $this->belongsToMany(User::class, 'follows','followed','following');

        }

    }
