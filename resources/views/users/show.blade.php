@extends('layouts.login')

@section('content')
<div class="profile" style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 30px;">
    <!-- 左側：プロフィール画像と情報 -->
    <div style="display: flex; align-items: center;">
        <!-- プロフィール画像 -->
        <img src="{{ asset('images/icon' . rand(1, 7) . '.png') }}" alt="{{ $user->username }}'s Profile Image" width="80" height="80" style="border-radius: 50%; margin-right: 20px;">

        <!-- ユーザー名と自己紹介 -->
        <div style="max-width: 500px;">
            <h1 style="margin-bottom: 8px;">name : {{ $user->username }}</h1>
            <p style="margin: 0; font-size: 1rem; c">bxo : {{ $user->bio }}</p>
        </div>
    </div>

    <!-- フォローボタン -->
    <div>
        @if (auth()->user()->isFollowing($user))
            <form action="{{ route('user.unfollow', $user->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger" style="padding: 10px 20px; font-size: 14px; border-radius: 25px; background-color: #dc3545; border-color: #dc3545;">
                フォロー解除
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
        <div style="display: flex; align-items: center; margin-bottom: 10px;">
            @php
                $iconNumber = ($post->user->id % 7) + 1;
            @endphp
            <img src="{{ asset('images/icon' . $iconNumber . '.png') }}" alt="{{ $post->user->username }} のアイコン" class="rounded-circle" width="40" height="40" style="margin-right: 10px;">
            <strong>{{ $post->user->username }}</strong>
        </div>
        <h5>{{ $post->post }}</h5>
        <p style="font-size: 1rem; color: #333;">{{ $post->content }}</p>
        <div style="font-size: 0.9rem; color: #888; text-align: right;">
            <small>投稿日: {{ $post->created_at->diffForHumans() }}</small>
        </div>
    </div>
@endforeach

</div>
@endsection
