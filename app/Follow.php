<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
  protected $fillable = [
    'following_id', 'followed_id'
  ];

public function getFollowCount($user_id)
  {
      return $this->where('following_id', '<>', $user_id)->count();
  }

  public function getFollowerCount($user_id)
  {
      return $this->where('followed_id', '<>',  $user_id)->count();
  }

      public function user()
    {
        return $this->belongsTo(User::class, 'followed_id');  // フォローされたユーザー
    }

    public function follower()
    {
        return $this->belongsTo(User::class, 'follower_id');  // フォロワー
    }

    public function followed()
    {
        return $this->belongsTo(User::class, 'followed_id');
    }

    public function icon()
    {
        return $this->hasOne(Icon::class);
    }

}
