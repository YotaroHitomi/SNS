@extends('layouts.login')

@section('content')
    <p>Follow List</p>

    <!-- フォローユーザーの一覧 -->
    <ul style="display: flex; flex-wrap: wrap; gap: 10px;">
        @foreach($followings as $following)
            <li style="list-style-type: none; display: flex; flex-direction: column; align-items: center;">
                <!-- フォローユーザーのプロフィール画像 -->
                <a href="{{ route('users.show', $following->id) }}">
                    <img
                        src="{{ asset('images/icon' . rand(1, 7) . '.png') }}"
                        alt="{{ $following->name }}'s Profile Image"
                        width="50" height="50">
                </a>
                <!-- ユーザー名もプロフィールページへリンク -->
                <a href="{{ route('users.show', $following->id) }}" style="text-decoration: none; color: black;">

                </a>
            </li>
        @endforeach
    </ul>

    <hr>

    <h1>フォローユーザーの投稿</h1>

    <!-- フォローユーザーの投稿を表示 -->
        @foreach ($posts as $post)
            <div style="width: 560px; min-height: 150px;" class="post mb-4 border rounded p-3 bg-light">
                <div class="post-header d-flex align-items-center mb-2">
                    <a href="{{ route('users.show', $post->user->id) }}" class="d-flex align-items-center text-decoration-none text-dark">
                        <img src="{{ asset('images/icon' . rand(1, 7) . '.png') }}"
                             alt="{{ $post->user->name }}'s Profile Image" width="50" height="50" class="me-3 rounded-circle">
                        <strong>{{ $post->user->name }}</strong>
                    </a>
                </div>
                <p class="mt-2">{{ $post->post }}</p>

                <small class="post-date">{{ $post->created_at->format('Y-m-d H:i') }}</small>

                @if(Auth::check() && Auth::user()->id == $post->user_id)
                    <div class="post-actions d-flex justify-content-end">
                        <button class="btn btn-warning js-modal-open me-2" data-id="{{ $post->id }}" data-content="{{ $post->post }}" style="background: none; border: none;">
                            <img src="{{ asset('images/edit.png') }}" alt="編集" style="width: 30px; height: 30px; border-radius: 5px;">
                        </button>

                        <!-- 削除ボタン：モーダル表示 -->
                        <button type="button" class="btn btn-danger js-delete-open" data-post-id="{{ $post->id }}" style="background: none; border: none;">
                            <img src="{{ asset('images/trash.png') }}" alt="削除" style="width: 20px; height: 20px; border-radius: 5px;">
                        </button>
                    </div>
                @endif
            </div>
        @endforeach
@endsection
