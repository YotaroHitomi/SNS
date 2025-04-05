@extends('layouts.app')

@section('content')
    <div class="profile">
        <h1>{{ $user->name }} のプロフィール</h1>
        <img src="{{ $user->profile_picture }}" alt="{{ $user->name }}'s profile picture" class="profile-picture">
        <p>自己紹介: {{ $user->bio }}</p>

        <h3>フォロワー: {{ $user->followers->count() }}</h3>
        <h3>フォロー中: {{ $user->following->count() }}</h3>
    </div>
    <div class="container">
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <img src="{{ $user->profile_image }}" class="card-img-top" alt="Profile Image">
                <div class="card-body">
                    <h5 class="card-title">{{ $user->name }}</h5>
                    <p class="card-text">{{ $user->bio }}</p>
                    <a href="#" class="btn btn-primary">フォローする</a>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <h2>{{ $user->name }} の投稿</h2>
            @foreach($user->posts as $post)
                <div class="post">
                    <h5>{{ $post->title }}</h5>
                    <p>{{ $post->content }}</p>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
