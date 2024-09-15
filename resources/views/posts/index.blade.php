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
            {{ Form::input('text', 'post', null, ['required', 'class' => 'form-control', 'placeholder' => '投稿内容を入力してください']) }}
                {{ Form::submit('', ['class' => 'btn btn-primary col-2']) }}
                @endguest
                {{-- 変更ここまで --}}
            </div>
            @if ($errors->has('post'))
                <p class="alert alert-danger">{{ $errors->first('tweet') }}</p>
            @endif
        {!! Form::close() !!}

        @foreach ($posts as $post)
            <div class="mb-1">
                <strong>{{ $post->name }}</strong> {{ $post->created_at }}
            </div>
            <div class="pl-3">
                {{ $post->post }}
            </div>
                <td><a class="btn btn-primary" href="/post/{{$post->id}}/update-form">更新</a></td>
                <td><a class="btn btn-danger" href="/post/{{$post->id}}/delete" onclick="return confirm('こちらの本を削除してもよろしいでしょうか？')">削除</a></td>
            </tr>
            <hr>
        @endforeach
    </div>
@endsection
