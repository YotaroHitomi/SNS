@extends('layouts.login')

@section('content')
<div class="profile" style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 30px;">
    <!-- 左側：プロフィール画像と情報 -->
    <div style="display: flex; align-items: center;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <!-- プロフィール画像 -->
<img src="{{ asset('images/' . $user->profile_image) }}"
     alt="{{ $user->username }}'s Profile Image"
     width="50" height="50"
     class="me-3 rounded-circle"
     style="object-fit: cover;">
        <!-- ユーザー名と自己紹介 -->
        <div style="max-width: 500px;">&nbsp;&nbsp;
            <h1 style="margin-bottom: 8px;">name : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $user->username }}</h1>&nbsp;&nbsp;
            <p style="margin: 0; font-size: 1rem; c">bxo : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $user->bio }}</p>
        </div>
    </div>

    <!-- フォローボタン -->
    <div>
        @if (auth()->user()->isFollowing($user))
            <form action="{{ route('user.unfollow', $user->id) }}" method="POST">
                @csrf
               <button type="submit" class="btn {{ auth()->user()->followings->contains($user->id) ? 'btn-following' : 'btn-not-following' }}" style="padding: 10px 20px; font-size: 14px; border-radius: 4px; margin-right: 25px">
            {{ auth()->user()->followings->contains($user->id) ? 'フォロー解除' : 'フォロー' }}
        </button>
        </form>
            </form>
        @else
            <form action="{{ route('user.follow', $user->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary" style="padding: 10px 20px; font-size: 14px; border-radius: 25px;">フォロー</button>
            </form>
        @endif
    </div>
</div>
<hr>


<!-- ユーザーの投稿一覧 -->
<div class="container mt-5">
 @foreach($user->posts as $post)
    <div class="post mb-4" style="border-bottom: 1px solid #ccc; padding-bottom: 15px; margin-bottom: 20px;">
        <div style="display: flex; align-items: center; margin-bottom: 10px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            @php
                $iconNumber = ($post->user->id % 7) + 1;
            @endphp
<img src="{{ asset('images/' . $user->profile_image) }}"
     alt="{{ $user->username }}'s Profile Image"
     width="50" height="50"
     class="me-3 rounded-circle"
     style="object-fit: cover;">
            <strong>{{ $post->user->username }}</strong>
        </div>
        <h5>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $post->post }}</h5>
        <p style="font-size: 1rem; color: #333;">{{ $post->content }}</p>
       <div class="post-date-top-right">
   <small class="post-date">{{ $post->created_at->format('Y-m-d H:i') }}</small>
</div>
    </div>
@endforeach

</div>
@endsection
