@extends('layouts.login')

@section('content')
<p>followList</p>
    <h1>{{Auth::user()->username}}のフォロー中ユーザー</h1>
    <ul>
        @foreach($followings as $user)
            <li>
                <img src="{{ $followed->profile_image ? asset('storage/' . $followed->profile_image) : asset('images/default-avatar.png') }}" alt="{{ $followed->name }}のアイコン" width="50" height="50">
                <span>{{ $followed->name }}</span>
            </li>
        @endforeach
    </ul>
        <h1>フォローしているユーザーの投稿</h1>

    @foreach ($followings as $user)
        <div class="post">
            <div class="post-header">
                <a href="{{ route('user.profile', $post->user->id) }}">
                    <img src="{{ asset('storage/' . $post->user->profile_image) }}" alt="{{ $post->user->name }} のアイコン" class="post-author-icon">
                </a>
                <p>{{ $post->user->name }} さんの投稿</p>
            </div>
            <p>{{ $post->content }}</p>
            <span>{{ $post->created_at->diffForHumans() }}</span>
        </div>
    @endforeach

@endsection
