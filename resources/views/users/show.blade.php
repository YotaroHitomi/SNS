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
     style="object-fit: cover; border-radius: 50%; margin-right: 30px;">
        <!-- ユーザー名と自己紹介 -->
        <div style="max-width: 500px;">&nbsp;&nbsp;
            <h1 style="margin-bottom: 8px;">ユーザ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $user->username }}</h1>&nbsp;&nbsp;
            <p style="margin: 0; font-size: 1rem;">自己紹介 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $user->bio }}</p>
        </div>
    </div>

<!-- フォローボタン -->
<div>
    @if (auth()->id() !== $user->id)
        <form action="{{ route('toggleFollow', ['userId' => $user->id]) }}" method="POST" style="display:inline;">
            @csrf
            @method('PATCH')
@php
    $isFollowing = auth()->user()->isFollowing($user->id);
@endphp
<button type="submit"
    class="btn {{ $isFollowing ? 'btn-following' : 'btn-not-following' }}"
    style="min-width: 120px; padding: 10px 20px; font-size: 14px; margin-right: 25px; border-radius: 4px;">
    {{ $isFollowing ? 'フォロー解除' : 'フォロー' }}
</button>

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
<!-- 投稿内ユーザー画像 -->
<img src="{{ asset('images/' . $user->images) }}"
     alt="{{ $user->username }}'s Profile Image"
     width="50" height="50"
     class="rounded-circle"
     style="object-fit: cover; border-radius: 50%; margin-right: 20px;">
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
