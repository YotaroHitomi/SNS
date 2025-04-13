@extends('layouts.login')

@section('content')
<div class="profile" style="display: flex; align-items: center; margin-bottom: 20px;">
    <!-- プロフィール画像 -->
    <img src="{{ asset('images/icon' . rand(1, 7) . '.png') }}" alt="{{ $user->username }}'s Profile Image" width="50" height="50" style="margin-right: 15px;">

    <!-- ユーザー名と自己紹介 -->
    <div>
        <h1>{{ $user->username }} のプロフィール</h1>
        <p style="margin: 0; font-size: 1rem; color: #555;">bxo: {{ $user->bio }}</p>
    </div>

<!-- フォローする / フォロー解除ボタン -->
<div class="container" style="margin-top: 30px;">
    @if (auth()->user()->isFollowing($user))
        <!-- フォロー解除ボタン -->
        <form action="{{ route('user.unfollow', $user->id) }}" method="POST" style="display: inline-block;">
            @csrf
            <button type="submit" class="btn btn-danger" style="padding: 12px 25px; font-size: 16px;">フォロー解除</button>
        </form>
    @else
        <!-- フォローボタン -->
        <form action="{{ route('user.follow', $user->id) }}" method="POST" style="display: inline-block;">
            @csrf
            <button type="submit" class="btn btn-primary" style="padding: 12px 25px; font-size: 16px;">フォロー</button>
        </form>
    @endif
</div>
</div>
<hr>

<!-- フォロー中ユーザー一覧 -->
<div class="container">
    <ul>
        @foreach($user->followings as $followedUser)
            <li style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px;">
                <!-- フォローユーザーの名称とbio -->
                <div style="flex-grow: 1;">
                    <p style="margin: 0; font-weight: bold;">{{ $followedUser->name }}</p>
                    <p style="margin: 0; font-size: 0.9rem; color: #6c757d;">bxo: {{ $followedUser->bio }}</p>
                </div>

                <!-- ランダムにフォローユーザーのプロフィール画像を表示 -->
                <img src="{{ asset('images/icon' . rand(1, 7) . '.png') }}" alt="{{ $followedUser->name }}'s profile picture" class="profile-picture" width="40" height="40">

                <!-- フォロー / フォロー解除ボタン -->
                <div style="margin-left: 10px;">
                    @if (auth()->user()->isFollowing($followedUser))
                        <form action="{{ route('user.unfollow', $followedUser->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            <button type="submit" class="btn btn-danger" style="padding: 10px 20px; font-size: 14px;">フォロー解除</button>
                        </form>
                    @else
                        <form action="{{ route('user.follow', $followedUser->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            <button type="submit" class="btn btn-primary" style="padding: 10px 20px; font-size: 14px;">フォロー</button>
                        </form>
                    @endif
                </div>
            </li>
        @endforeach
    </ul>
</div>

<!-- ユーザーの投稿一覧 -->
<div class="container">
    <h2>{{ $user->username }} の投稿</h2>
    @foreach($user->posts as $post)
        <div class="post">
            <h5>{{ $post->title }}</h5>
            <p>{{ $post->content }}</p>
            <p><small>投稿日: {{ $post->created_at->diffForHumans() }}</small></p>
        </div>
    @endforeach
</div>
@endsection
