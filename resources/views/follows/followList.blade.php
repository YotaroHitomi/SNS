@extends('layouts.login')

@section('content')
<!-- フォローユーザー一覧 -->
<div style="display: flex; gap: 15px; font-size: 20px; flex-wrap: wrap; min-height: 50px; padding: 20px 0; margin-top: 65px;">
    <p style="margin-left: 25px;">フォローリスト</p>

    <ul style="display: flex; flex-wrap: wrap; gap: 10px; margin-top: -50px;">
        @foreach($followings as $following)
            @if($following->id !== Auth::id())
                <li style="list-style-type: none; display: flex; align-items: center;">
                    <a href="{{ route('users.show', $following->id) }}" style="display: flex; align-items: center; text-decoration: none; color: black;">
                        <img src="{{ $following->profile_picture }}"
                             alt="{{ $following->username }}'s Profile Image"
                             width="50" height="50"
                             class="rounded-circle object-fit-cover"
                             style="object-fit: cover; border-radius: 50%;">
                    </a>
                </li>
            @endif
        @endforeach
    </ul>
</div>

<!-- フォローユーザーの投稿 -->
<hr class="section-divider">

@foreach ($posts as $post)
    <div style="height: 90px;" class="post mb-4 border rounded p-3 bg-light">
        <!-- 投稿ヘッダー：アイコンと名前 -->
        <div class="post-header" style="display: flex; align-items: center; margin-bottom: 10px;">
            <a href="{{ route('users.show', $post->user->id) }}" style="display: flex; align-items: center; text-decoration: none; color: black;">
                <img src="{{ $post->user->profile_picture }}"
                     alt="{{ $post->user->username }}'s Profile Image"
                     width="50" height="50"
                     class="rounded-circle object-fit-cover"
                     style="object-fit: cover; border-radius: 50%;">
                <span style="margin-left: 10px;">{{ $post->user->username }}</span>
            </a>
        </div>

        <!-- 投稿内容 -->
        <div>
            <p style="margin-left: 60px;">{{ $post->post }}</p>
        </div>

        <!-- 投稿日時 -->
        <div class="post-date-top-right">
            <small class="post-date">{{ $post->created_at->format('Y-m-d H:i') }}</small>
        </div>
    </div>
@endforeach
@endsection
