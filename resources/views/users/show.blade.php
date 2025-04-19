@extends('layouts.login')

@section('content')
<div class="profile" style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 30px;">
    <!-- 左側：プロフィール画像と情報 -->
    <div style="display: flex; align-items: center;">
        <!-- プロフィール画像 -->
        <img src="{{ asset('images/icon' . rand(1, 7) . '.png') }}" alt="{{ $user->username }}'s Profile Image" width="80" height="80" style="border-radius: 50%; margin-right: 20px;">

        <!-- ユーザー名と自己紹介 -->
        <div>
            <h1 style="margin-bottom: 8px;">{{ $user->name }} のプロフィール</h1>
            <p style="margin: 0; font-size: 1rem; color: #555;">bxo: {{ $user->bio }}</p>
        </div>
    </div>

    <!-- 右側：フォローボタン -->
    <div>
        @if (auth()->user()->isFollowing($user))
            <form action="{{ route('user.unfollow', $user->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger" style="padding: 10px 20px; font-size: 14px; border-radius: 25px;">フォロー解除</button>
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
        <img src="{{ asset('images/icon' . rand(1, 7) . '.png') }}" alt="{{ $user->username }}'s Profile Image" width="80" height="80" style="border-radius: 50%; margin-right: 20px;">
    <h2>{{ $user->name }} の投稿</h2>
    @foreach($user->posts as $post)
        <div class="post mb-4" style="border: 1px solid #ddd; padding: 20px; border-radius: 10px;">
            <h5 style="font-size: 1.25rem; font-weight: bold;">{{ $post->title }}</h5>
            <p style="font-size: 1rem; color: #333;">{{ $post->content }}</p>
            <small>投稿日: {{ $post->created_at->diffForHumans() }}</small></p>
        </div>
    @endforeach
</div>
@endsection
