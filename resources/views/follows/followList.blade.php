@extends('layouts.login')

@section('content')
    <p style="margin-right: 20px;">Follow List</p>


    <h1>{{ Auth::user()->username }}</h1>
    <ul style="display: flex; flex-wrap: wrap; gap: 10px;">
        @foreach($followings as $user)
            <li style="list-style-type: none; display: flex; flex-direction: column; align-items: center;">
                <!-- フォローユーザーのプロフィール画像 (クリックでプロフィールページへ遷移) -->
                <a href="{{ route('users.show', $user->id) }}">
                    <img src="{{ asset('images/icon' . rand(1, 7) . '.png') }}" alt="{{ $user->name }}'s Profile Image" width="50" height="50">
                </a>
                <!-- ユーザー名もプロフィールページへリンク -->
                <a href="{{ route('users.show', $user->id) }}" style="text-decoration: none; color: black;">
                    <p>{{ $user->username }}</p> <!-- ユーザー名を表示 -->
                </a>
            </li>
        @endforeach
    </ul>

    <hr>
    <h1>フォローしているユーザーの投稿</h1>
    @foreach ($posts->unique('user_id') as $post) <!-- 重複投稿を避けるためにuniqueでユーザーごとの投稿を絞る -->
        <div style="width: 560px; height: 150px; overflow: hidden;">
            <div class="post-header">
                <!-- 投稿者のプロフィールアイコン (クリックでプロフィールページへ遷移) -->
                <a href="{{ route('users.show', $post->user->id) }}">
                    <img src="{{ asset('images/icon' . rand(1, 7) . '.png') }}" alt="{{ $post->user->name }}'s Profile Image" width="50" height="50">
                </a>
                <!-- 投稿者のユーザー名もプロフィールページへリンク -->
                <a href="{{ route('users.show', $post->user->id) }}" style="text-decoration: none; color: black;">
                    <p>{{ $post->user->name }}</p> <!-- ユーザー名を表示 -->
                </a>
            </div>
            <div>
                <p>{{ $post->content }}</p>
            </div>
            <small class="post-date">{{ $post->created_at->format('Y-m-d H:i') }}</small>
        </div>
        <hr>
    @endforeach
@endsection
