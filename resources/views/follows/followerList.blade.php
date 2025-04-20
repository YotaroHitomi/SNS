@extends('layouts.login')

@section('content')
    <p>Follower List</p>
<!-- ユーザー情報 -->
<h1>{{ Auth::user()->username }}</h1>

<!-- フォロワーユーザーの一覧 -->
<ul style="display: flex; flex-wrap: wrap; gap: 10px;">
    @foreach($followers as $follower)
        <li style="list-style-type: none; display: flex; flex-direction: column; align-items: center;">
            <!-- フォロワーユーザーのプロフィール画像 -->
            <a href="{{ route('users.show', $follower->id) }}">
               <img
                   src="{{ asset('images/icon' . rand(1, 7) . '.png') }}"
                   alt="{{ $follower->name }}'s Profile Image"
                   width="50" height="50">
            </a>

        </li>
    @endforeach
</ul>

<hr>

<h1>フォロワーユーザーの投稿</h1>

<!-- フォロワーユーザーの投稿を表示 -->
@foreach($followers as $follower)
    @foreach($follower->posts as $post) <!-- フォロワーユーザーの投稿を表示 -->
        <div style="width: 560px; height: 150px; overflow: hidden;">
            <div class="post-header">
                <a href="{{ route('users.show', $follower->id) }}">
                    <!-- 投稿者のアイコン -->
                    <img
                        src="{{ asset('images/icon' . rand(1, 7) . '.png') }}"
                        alt="{{ $follower->name }}'s Profile Image"
                        width="50" height="50">
                </a>
                <p>{{ $post->user->name }}</p> <!-- ユーザー名を表示 -->
            </div>
            <div>
                <p>{{ $post->content }}</p> <!-- 投稿内容 -->
            </div>
            <small class="post-date">{{ $post->created_at->format('Y-m-d H:i') }}</small>
        </div>
        <hr>
    @endforeach
@endforeach

@endsection
