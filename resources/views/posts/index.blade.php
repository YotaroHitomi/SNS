@extends('layouts.login')

@section('content')
TOPページ
    <div class="container mt-3">
        {!! Form::open(['route' => 'timeline', 'method' => 'POST']) !!}
            {{ csrf_field() }}
            <div class="row mb-4">
                @guest
                    <div class="mx-auto">
                        <a class="btn btn-primary" href="{{ route('login') }}">ログインしてツイートする</a>
                        <a class="btn btn-primary" href="{{ route('register') }}">新規登録してツイートする</a>
                    </div>
                @else
<input type="text" name="post" class="form-control" placeholder="投稿内容を入力してください" required>

                {{ Form::submit('', ['class' => 'btn btn-primary col-2']) }}
                @endguest
            </div>
            <hr>
            {!! Form::close() !!}
@foreach ($posts as $post)
    <div class="mb-2 border-bottom pb-2">
        <div>
            <strong>{{ $post->name }}</strong> <small class="text-muted">{{ $post->created_at }}</small>
        </div>
        <div class="ms-3 mb-2">
            {{ $post->post }}
        </div>

        <div class="d-flex gap-2">
            <!-- 更新ボタン -->
            <a href="#" class="btn btn-sm btn-outline-primary js-modal-open"
               data-toggle="modal"
               data-target="#updateModal"
               data-id="{{ $post->id }}"
               data-content="{{ $post->post }}">
                更新
            </a>

            <!-- 削除ボタン -->
            <a href="/post/{{ $post->id }}/delete"
               class="btn btn-sm btn-danger"
               onclick="return confirm('この投稿を削除してもよろしいですか？')">
                削除
            </a>
        </div>
    </div>
    <hr>
@endforeach
    </div>
   <!-- モーダルの中身 -->
    <div class="modal js-modal">
        <div class="modal__bg js-modal-close"></div>
        <div class="modal__content">
           <form action="" method="">
                <textarea name="" class="modal_post"></textarea>
                <input type="hidden" name="" class="modal_id" value="">
                <input type="submit" value="更新">
                {{ csrf_field() }}
           </form>
           <a class="js-modal-close" href="">閉じる</a>
        </div>
    </div>

<!-- <p>{{ $posts->count() }}</p> -->
@endsection
