@extends('layouts.login')

@section('content')
<div class="profile" style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 30px;">
    <!-- 左側：プロフィール画像と情報 -->
    <div style="display: flex; align-items: center;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <!-- プロフィール画像 -->
        <img src="{{ asset('images/icon' . rand(1, 7) . '.png') }}" alt="{{ $user->username }}'s Profile Image" width="40" height="40" style="border-radius: 50%; margin-right: 20px;">

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
            <img src="{{ asset('images/icon' . $iconNumber . '.png') }}" alt="{{ $post->user->username }} のアイコン" class="rounded-circle" width="40" height="40" style="margin-right: 10px;">
            <strong>{{ $post->user->username }}</strong>
        </div>
        <h5>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $post->post }}</h5>
        <p style="font-size: 1rem; color: #333;">{{ $post->content }}</p>
       <div class="post-date-top-right">
    <small>投稿日: {{ $post->created_at->diffForHumans() }}</small>
</div>
    </div>
@endforeach

</div>
@endsection
