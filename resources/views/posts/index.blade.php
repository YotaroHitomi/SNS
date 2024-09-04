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
                    {{ Form::text('tweet', null, ['class' => 'form-control col-9 mr-auto']) }}
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
            <hr>
        @endforeach
    </div>


@endsection
