@extends('layouts.login')

@section('content')

<!-- ユーザー情報 -->
<h1>{{ Auth::user()->username }}のフォロワーユーザー</h1>

<!-- フォロワーユーザーの一覧 -->
<ul style="display: flex; flex-wrap: wrap; gap: 10px;">
    @foreach($followers as $follower)
        <li style="list-style-type: none; display: flex; flex-direction: column; align-items: center;">
            <!-- フォロワーユーザーのプロフィール画像 -->
            <a href="{{ route('users.show', $follower->id) }}">
               <img
                   src="{{ asset('images/icon' . rand(1, 7) . '.png') }}"  <!-- 画像をランダムに表示 -->
                   alt="{{ $follower->name }}'s Profile Image"
                   width="50" height="50">
            </a>
            <span>{{ $follower->name }}</span> <!-- フォロワーユーザー名 -->
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
                        src="{{ asset('images/icon' . rand(1, 7) . '.png') }}"  <!-- 投稿者のプロフィール画像もランダムで表示 -->
                        alt="{{ $follower->name }}'s Profile Image"
                        width="50" height="50">
                </a>
                <p>{{ $follower->username }} さんの投稿</p>
            </div>
            <div>
                <p>{{ $post->content }}</p> <!-- 投稿内容 -->
            </div>
            <span>{{ $post->created_at->diffForHumans() }}</span>  <!-- 投稿日時を追加 -->
        </div>
        <hr>
    @endforeach
@endforeach

@endsection
