@extends('layouts.login')

@section('content')
    <div style="display: flex; align-items: center; gap: 15px; flex-wrap: wrap;">
        <p style="margin-left:25px;">Follower List</p>

<!-- フォロワーユーザーの一覧 -->
<ul style="display: flex; flex-wrap: wrap; gap: 10px;">
    @foreach($followers as $follower)
        <li style="list-style-type: none; display: flex; flex-direction: column; align-items: center;">
            <!-- フォロワーユーザーのプロフィール画像 -->
            <a href="{{ route('users.show', $follower->id) }}">
               <img
                   src="{{ asset('images/icon' . rand(1, 7) . '.png') }}"
                   alt="{{ $follower->username }}'s Profile Image"
                   width="50" height="50">
            </a>
        </li>
    @endforeach
</ul>
</div>

<hr>

<!-- フォロワーユーザーの投稿を表示 -->
@foreach($followers as $follower)
    @foreach($follower->posts as $post)
        <div style="height: 125px;" class="post mb-4 border rounded p-3 bg-light">
            <!-- 投稿ヘッダー（アイコンと名前を横並び） -->
            <div class="post-header" style="display: flex; align-items: center; margin-bottom: 10px;">
                <a href="{{ route('users.show', $follower->id) }}" style="display: flex; align-items: center; text-decoration: none; color: black;">
                    <img
                        src="{{ asset('images/icon' . rand(1, 7) . '.png') }}"
                        alt="{{ $follower->username }}'s Profile Image"
                        width="50" height="50"
                        style="border-radius: 50%;">
                    <span style="margin-left: 10px;">{{ $post->user->username }}</span>
                </a>
            </div>

            <!-- 投稿内容 -->
            <div>
                <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $post->post }}</p>
            </div>

            <!-- 投稿日時 -->
               <div class="post-date-top-right">
    <small>投稿日: {{ $post->created_at->diffForHumans() }}</small>
</div>

        </div>
    @endforeach
@endforeach


@endsection
