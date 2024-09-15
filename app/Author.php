<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
        // リレーションの定義
        public function posts(){
        return $this->hasMany('App\Post');
        }

}
