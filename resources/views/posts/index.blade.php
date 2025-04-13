@extends('layouts.login')

@section('content')
TOPページ
<div class="container mt-3">
    {!! Form::open(['route' => 'posts.store', 'method' => 'POST']) !!}
        {{ csrf_field() }}
        <div class="row mb-4">
            @guest
                <div class="mx-auto">
                    <a class="btn btn-primary" href="{{ route('login') }}">ログインしてツイートする</a>
                    <a class="btn btn-primary" href="{{ route('register') }}">新規登録してツイートする</a>
                </div>
            @else
                <div class="d-flex align-items-center w-100">
                    <!-- ユーザーアイコン -->
                    <img src="{{ asset('images/icon1.png') }}" alt="User Icon">

                    <!-- 投稿フォーム（textareaに変更） -->
                    <textarea name="post" class="form-control" placeholder="投稿内容を入力してください" required style="border: none; border-radius: 25px; height: 125px; width: 70%;"></textarea>

                    <!-- 送信ボタン -->
                    <button type="submit" class="btn btn-primary ms-2" style="width: 60px; height: 60px; padding: 0; border-radius: 50%; align-items: center; justify-content: center;">
                        <i class="fas fa-paper-plane" style="font-size: 24px;"></i>
                    </button>
                </div>
            @endguest
        </div>
        <hr>
    {!! Form::close() !!}

    <!-- フォローしているユーザーの投稿のみ表示 -->
    <div class="container">
        <h1>フォローしているユーザーの投稿</h1>
        @foreach ($posts as $post)
            <div style="width: 560px; height: 150px; overflow: hidden;" class="post">
                <div class="post-header">
                    <a href="{{ route('users.show', $post->user->id) }}">
                        <img src="{{ asset('images/icon' . rand(1, 7) . '.png') }}"
                             alt="{{ $post->user->name }}'s Profile Image" width="50" height="50">
                    </a>
                    <p>{{ $post->user->name }} さんの投稿</p>
                </div>
                <p>{{ $post->post }}</p>
                <span>{{ $post->created_at->diffForHumans() }}</span>

                <!-- 更新ボタン -->
                @can('update', $post)
                    <a href="#" class="btn btn-warning btn-sm ms-2" data-bs-toggle="modal" data-bs-target="#editModal-{{ $post->id }}">更新</a>
                @endcan

                <!-- 削除ボタン -->
                @can('delete', $post)
                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="d-inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm ms-2">削除</button>
                    </form>
                @endcan
            </div>

            <!-- 更新用モーダル -->
            <div class="modal fade" id="editModal-{{ $post->id }}" tabindex="-1" aria-labelledby="editModalLabel-{{ $post->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel-{{ $post->id }}">投稿を編集</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('posts.update', $post->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <textarea name="post" class="form-control" required>{{ $post->post }}</textarea>
                                <button type="submit" class="btn btn-primary mt-3">更新</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

@endsection
