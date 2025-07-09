@extends('layouts.login')

@section('content')
<div class="profile" style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 30px;">
    <!-- 左側：プロフィール画像と情報 -->
    <div style="display: flex; align-items: center;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <!-- プロフィール画像 -->
        <img src="{{ asset('images/' . $user->images) }}"
             alt="{{ $user->username }}'s Profile Image"
             width="50" height="50"
             class="me-3 rounded-circle"
             style="object-fit: cover; margin-right: 30px;">
        <!-- ユーザー名と自己紹介 -->
        <div style="max-width: 500px;">&nbsp;&nbsp;
            <h1 style="margin-bottom: 8px;">name &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $user->username }}</h1>&nbsp;&nbsp;
            <p style="margin: 0; font-size: 1rem;">bxo &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $user->bio }}</p>
        </div>
    </div>

    <!-- フォローボタン -->
    <div>
        @if (auth()->user()->isFollowing($user))
            <form action="{{ route('user.unfollow', $user->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn {{ auth()->user()->followings->contains($user->id) ? 'btn-following' : 'btn-not-following' }}" style="padding: 10px 20px; font-size: 14px; border-radius: 4px; margin-right: 25px;">
                    {{ auth()->user()->followings->contains($user->id) ? 'フォロー解除' : 'フォロー' }}
                </button>
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
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                <!-- 左側：アイコン＋ユーザー名 -->
                <div style="display: flex; align-items: center; margin-left: 20px;">
                    @php
                        $iconNumber = ($post->user->id % 7) + 1;
                    @endphp
                    <img src="{{ asset('images/' . $user->images) }}"
                         alt="{{ $user->username }}'s Profile Image"
                         width="50" height="50"
                         class="rounded-circle"
                         style="object-fit: cover; margin-right: 20px;">
                    <strong style="font-size: 1.1rem;">{{ $post->user->username }}</strong>
                </div>
                <!-- 右上：投稿日時 -->
               <div class="post-date-top-right">
    <small class="post-date">{{ $post->created_at->format('Y-m-d H:i') }}</small>
</div>
            </div>

            <!-- 投稿内容 -->
            <h5 style="margin-left: 70px;">{{ $post->post }}</h5>
            <p style="font-size: 1rem; color: #333; margin-left: 70px;">{{ $post->content }}</p>
        </div>
    @endforeach
</div>
@endsection
