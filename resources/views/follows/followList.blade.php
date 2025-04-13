@extends('layouts.login')

@section('content')
    <p>Follow List</p>

    <h1>{{ Auth::user()->username }}のフォロー中ユーザー</h1>
    <ul style="display: flex; flex-wrap: wrap; gap: 10px;">
        @foreach($followings as $user)
            <li style="list-style-type: none; display: flex; flex-direction: column; align-items: center;">
                <!-- フォローユーザーのプロフィール画像 -->
                <a href="{{ route('users.show', $user->id) }}">
                    <img src="{{ asset('images/icon' . rand(1, 7) . '.png') }}" alt="{{ $user->name }}'s Profile Image" width="50" height="50">
                </a>
                <span>{{ $user->name }}</span>
            </li>
        @endforeach
    </ul>
<hr>
    <h1>フォローしているユーザーの投稿</h1>
    @foreach ($posts->unique('user_id') as $post) <!-- 重複投稿を避けるためにuniqueでユーザーごとの投稿を絞る -->
        <div style="width: 560px; height: 150px; overflow: hidden;">
            <div class="post-header">
                <a href="{{ route('users.show', $post->user->id) }}">
                    <img src="{{ asset('images/icon' . rand(1, 7) . '.png') }}" alt="{{ $post->user->name }}'s Profile Image" width="50" height="50">
                </a>
               <p>{{ $post->user->username }} さんの投稿</p>

            </div>
            <div>
                <p>{{ $post->content }}</p>
            </div>
            <span>{{ $post->created_at->diffForHumans() }}</span>  <!-- 投稿日時を追加 -->
        </div>
        <hr>
    @endforeach
@endsection
